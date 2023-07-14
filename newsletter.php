<?php
/**
 * Plugin name: Newsletter WP Plugin
 * Plugin URI: https://github.com/adambasa-dp/newsletter-wp-plugin
 * Version: 1.0.0
 * Requires PHP: 8.1
 * Description: WP Newsletter is a custom WordPress plugin that allows users to create customizable newsletter shortcodes, handle form submissions, store submissions in a dedicated database table, and export those submissions to a CSV format.
 * Author: Adam Basa
 * Author URI: https://www.developress.io/
 * License: MIT
 * Text Domain: dp
 * Domain Path: /i18n
 */

namespace dp;


use dp\app\domains\database\Database;
use dp\app\domains\Domains;
use Exception;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Plugin starter
 */
class Newsletter_WP_Plugin {
	/**
	 * Initialize the plugin
	 */
	public static function init(): void {
		$class = __CLASS__;
		new $class;
	}

	/**
	 * Activate plugin functionality
	 *
	 * @throws Exception If the table name is already used by another plugin or theme.
	 */
	static function activate_plugin(): void {
		// create custom tables in DB.
		if ( ! Database::create_table() ) {
			// WordPress do not provider user-friendly way to interrupt activation process. We need to do that "brutally".
			throw new Exception( __( 'The table name is already used by another plugin or theme.', 'dp' ) );
		}

		// set version of the plugin.
		update_option( 'wp_newsletter_plugin', '1.0' );
	}

	/**
	 * Run baby, run!!!
	 */
	function __construct() {
		new Domains();
	}
}

add_action( 'plugins_loaded', [ __NAMESPACE__ . '\\Newsletter_WP_Plugin', 'init' ] );
register_activation_hook( __FILE__, [ __NAMESPACE__ . '\\Newsletter_WP_Plugin', 'activate_plugin' ] );
