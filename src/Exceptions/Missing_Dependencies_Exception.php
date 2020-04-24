<?php

namespace BernskioldMedia\WP\WP_Dependency_Checker\Exceptions;

/**
 * Class Missing_Dependencies_Exception
 *
 * @package BernskioldMedia\WP\WP_Dependency_Checker\Exceptions
 */
class Missing_Dependencies_Exception extends \Exception {

	/**
	 * Missing Dependencies
	 *
	 * @var array
	 */
	private $missing_dependencies;

	/**
	 * Construct the exception.
	 *
	 * @param  array  $missing_dependencies
	 */
	public function __construct( $missing_dependencies ) {
		$this->missing_dependencies = $missing_dependencies;
		parent::__construct( 'Not all dependencies were loaded. Missing: ' . $this->get_names() );
	}

	/**
	 * Get a list of missing dependency names.
	 *
	 * @return array
	 */
	public function get_names(): array {
		return array_values( $this->missing_dependencies );
	}

}
