<?php

namespace BernskioldMedia\WP\WP_Dependency_Checker\Traits;

use BernskioldMedia\WP\WP_Dependency_Checker\Admin\Missing_Dependency_Notice;
use BernskioldMedia\WP\WP_Dependency_Checker\Dependency_Check;
use BernskioldMedia\WP\WP_Dependency_Checker\Exceptions\Missing_Dependencies_Exception;
use ReflectionClass;

/**
 * Trait Has_Dependencies
 *
 * Include this trait for example on your main plugins file.
 * Then you can use the has_dependencies function where you need to check, before
 * running your main plugin code.
 *
 * @package BernskioldMedia\WP\WP_Dependency_Checker
 */
trait Has_Dependencies {

	/**
	 * Check if the plugin meets all dependencies.
	 *
	 * @return bool
	 */
	public static function has_dependencies(): bool {
		try {
			Dependency_Check::has_dependencies( static::$dependencies );

			return true;
		} catch ( Missing_Dependencies_Exception $error ) {
			static::add_missing_dependencies_notice( $error );

			return false;
		}
	}

	/**
	 * Add a missing dependency notice.
	 *
	 * @param  Missing_Dependencies_Exception  $e
	 */
	protected static function add_missing_dependencies_notice( Missing_Dependencies_Exception $e ) {
		$notice = new Missing_Dependency_Notice( static::get_dependency_plugin_name(), $e->get_names() );
		$notice->init();
	}

	/**
	 * Get the current plugin name.
	 *
	 * @return string
	 */
	private static function get_dependency_plugin_name(): string {

		if ( ! function_exists( 'get_plugin_data' ) ) {
			return '';
		}

		$class = new ReflectionClass( static::class );
		$data  = get_plugin_data( $class->getFileName() );

		return $data['Name'] ?? '';
	}

}
