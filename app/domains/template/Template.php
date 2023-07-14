<?php
/**
 * Handle custom templating by the end user
 */

namespace dp\app\domains\template;

/**
 * Handle custom templating by the end user
 */
class Template {
	/**
	 * Add required hooks
	 */
	public function __construct() {
		add_filter( 'newsletter_wp_plugin_print_frontend', [ $this, 'print_widget' ] );
		add_filter( 'newsletter_wp_plugin_add_css', [ $this, 'add_css' ] );
		add_filter( 'newsletter_wp_plugin_add_js', [ $this, 'add_js' ] );
	}

	/**
	 * Decide do we have to use the default template or the custom one
	 *
	 * @return string
	 */
	private function get_template_file(): string {
		$path = plugin_dir_path( __FILE__ ) . '/../../view/view.php';

		$file_name = 'newsletter-wp-plugin.php';
		if ( locate_template( $file_name ) ) {
			$path = locate_template( $file_name );
		}

		return $path;
	}

	/**
	 * Print the newsletter widget on the screen
	 *
	 * @param array $args Arguments passed to the widget to be printed.
	 */
	function print_widget( array $args ): string {
		apply_filters( 'newsletter_wp_plugin_add_css', null );
		apply_filters( 'newsletter_wp_plugin_add_js', null );

		$path = $this->get_template_file();

		ob_start();
		load_template( $path, false, $args );

		return ob_get_clean();
	}


	/**
	 * Add styles to the newsletter widget
	 *
	 * @return void
	 */
	function add_css(): void {
		wp_enqueue_style( 'newsletter-wp-plugin-style', plugins_url( '../../assets/css/style.css', __FILE__ ) );
	}

	/**
	 * Add scripts to the newsletter widget
	 *
	 * @return void
	 */
	function add_js(): void {
		wp_enqueue_script( 'newsletter-wp-plugin-script', plugins_url( '../../assets/js/main.min.js', __FILE__ ), [], false, true );
	}
}
