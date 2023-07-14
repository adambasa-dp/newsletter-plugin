<?php
/**
 * Add menu page for Newsletter
 */

namespace dp\app\domains\admin_panel;

/**
 * Menu definition and handling view requests
 */
class Admin_Panel {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'crm_admin_menu' ] );
	}

	/**
	 * Add menu pages
	 *
	 * @return void
	 */
	function crm_admin_menu(): void {
		add_menu_page(
			'Newsletter',
			__( 'Newsletter', 'dp' ),
			'manage_options',
			'newsletter-wp-plugin',
			[ '\dp\app\domains\newsletter\Newsletter', 'view_controller' ],
			'dashicons-email-alt',
			2
		);
	}
}
