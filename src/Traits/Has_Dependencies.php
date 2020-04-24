<?php

namespace BernskioldMedia\WP\Traits\WP_Dependency_Checker;

use BernskioldMedia\WP\WP_Dependency_Checker\Admin\Missing_Dependency_Notice;
use BernskioldMedia\WP\WP_Dependency_Checker\Dependency_Check;
use BernskioldMedia\WP\WP_Dependency_Checker\Exceptions\Missing_Dependencies_Exception;

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
	 * A list of all dependencies.
	 *
	 * @var array
	 */
	protected static $dependencies = [];

	/**
	 * Check if the plugin meets all dependencies.
	 */
	public static function has_dependencies() {
		try {
			Dependency_Check::has_dependencies( static::$dependencies );
		} catch ( Missing_Dependencies_Exception $error ) {
			static::add_missing_dependencies_notice( $error );
		}
	}

	/**
	 * Add a missing dependency notice.
	 *
	 * @param  Missing_Dependencies_Exception  $e
	 */
	protected static function add_missing_dependencies_notice( Missing_Dependencies_Exception $e ) {
		$notice = new Missing_Dependency_Notice( $e->get_names() );
		$notice->init();
	}

}
