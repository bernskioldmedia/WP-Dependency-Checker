<?php

namespace BernskioldMedia\WP\WP_Dependency_Checker\Admin;

/**
 * Class Missing_Dependency_Notice
 *
 * @package BernskioldMedia\WP\WP_Dependency_Checker\Admin
 */
class Missing_Dependency_Notice {

	/**
	 * @var string
	 */
	const CAPABILITY = 'activate_plugins';

	/**
	 * @var array
	 */
	private $missing_dependencies_names;

	/**
	 * @var string
	 */
	private $message;

	/**
	 * @var string
	 */
	private $missing_plugins_string;

	/**
	 * Missing_Dependency_Notice constructor.
	 *
	 * @param  array  $missing_dependencies_names
	 */
	public function __construct( $missing_dependencies_names ) {
		$this->missing_dependencies_names = $missing_dependencies_names;
		$this->create_missing_plugins_string();
	}

	/**
	 * Run the notice display.
	 */
	public function init() {
		add_action( 'admin_notices', [ $this, 'render' ] );
	}

	/**
	 *
	 *
	 * @param $message
	 *
	 * @return $this
	 */
	public function message( $message ): self {
		$this->message = $message;

		return $this;
	}

	/**
	 * Create a string of names of missing plugins.
	 */
	private function create_missing_plugins_string() {
		$plugins_list = [];

		foreach ( $this->missing_dependencies_names as $name ) {
			$plugins_list[] = '<strong>' . $name . '</strong>';
		}

		$this->missing_plugins_string = implode( ', ', $plugins_list );
	}

	/**
	 * Get a string of missing plugins to use the message.
	 *
	 * @return mixed
	 */
	public function get_missing_plugins_string() {
		return $this->missing_plugins_string;
	}

	/**
	 * Get the error message. Include %s for a comma separated
	 * list of plugins that are not active.
	 *
	 * @return string
	 */
	public function get_message() {
		if ( $this->message ) {
			return $this->message;
		}

		return wp_kses( '<strong>Dependencies Missing:</strong> The <em>BM People</em> plugin cannot run because the following required plugins are not active: %s. Please activate them.',
			[
				'strong' => [],
				'em'     => [],
			] );
	}

	/**
	 * Render the notice.
	 */
	public function render() {

		if ( $this->can_see_notice() ) {
			return;
		}

		?>
		<div class="notice notice-error is-dismissable">
			<p><?php printf( $this->get_message(), $this->get_missing_plugins_string() ); ?></p>
		</div>
		<?php

	}

	/**
	 * Check if the user can see the notice.
	 *
	 * @return mixed
	 */
	private function can_see_notice() {
		return current_user_can( $this->get_capability() );
	}

	/**
	 * Get which capability can see the notice.
	 *
	 * @return string
	 */
	public function get_capability(): string {
		return add_filter( 'dependency_notice_capability', self::CAPABILITY );
	}

}
