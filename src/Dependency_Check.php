<?php

namespace BernskioldMedia\WP\WP_Dependency_Checker;

use BernskioldMedia\WP\WP_Dependency_Checker\Exceptions\Missing_Dependencies_Exception;

/**
 * Class Dependency_Check
 *
 * @package BernskioldMedia\WP\WP_Dependency_Checker
 */
class Dependency_Check {

	/**
	 * Check if all dependencies are loaded.
	 *
	 * @param  array  $dependencies
	 *
	 * @return bool
	 * @throws Missing_Dependencies_Exception
	 */
	public static function has_dependencies( $dependencies ): bool {
		$missing_dependencies = static::get_missing_dependencies( $dependencies );

		if ( ! empty( $missing_dependencies ) ) {
			throw new Missing_Dependencies_Exception( $missing_dependencies );
		}

	}

	/**
	 * Get an array of missing dependencies.
	 *
	 * @param  array   $dependencies
	 * @param  string  $return  Either "names" or "paths".
	 *
	 * @return array
	 */
	public static function get_missing_dependencies( array $dependencies, $return = 'names' ): array {
		$missing_plugins = array_filter( $dependencies, [ static::class, 'is_plugin_inactive' ], ARRAY_FILTER_USE_BOTH );

		if ( 'paths' === $return ) {
			return array_values( $missing_plugins );
		}

		return array_keys( $missing_plugins );
	}

	/**
	 * Check if we have a dependency based on the plugin file path.
	 *
	 * @param  string  $plugin_file_path
	 *
	 * @return bool
	 */
	public static function has_dependency( $plugin_file_path ): bool {
		return static::is_plugin_active( $plugin_file_path );
	}

	/**
	 * Get a list of active plugins.
	 *
	 * @return array
	 */
	protected static function get_active_plugins(): array {
		return apply_filters( 'active_plugins', get_option( 'active_plugins' ) );
	}

	/**
	 * Check if a plugin is active.
	 *
	 * @param  string  $plugin_file_path
	 *
	 * @return bool
	 */
	public static function is_plugin_active( $plugin_file_path ): bool {
		return in_array( $plugin_file_path, static::get_active_plugins(), true );
	}

	/**
	 * Check if a plugin is inactive.
	 *
	 * @param  string  $plugin_file_path
	 *
	 * @return bool
	 */
	public static function is_plugin_inactive( $plugin_file_path ): bool {
		return ! static::is_plugin_active( $plugin_file_path );
	}

}
