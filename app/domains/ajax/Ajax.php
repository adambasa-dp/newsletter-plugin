<?php

namespace dp\app\domains\ajax;

use dp\app\domains\newsletter\Newsletter;

/**
 * Handle ajax requests
 */
class Ajax {
	/**
	 * Initialize ajax requests
	 */
	public function __construct() {
		$this->ajax_requests();
	}

	/**
	 * Handle AJAX request - for adding new email to newsletter from website
	 */
	private function ajax_requests(): void {
		add_action( 'wp_ajax_newsletter_wp_plugin_subscribe', [ $this, 'sender_handler' ] );
		add_action( 'wp_ajax_nopriv_newsletter_wp_plugin_subscribe', [ $this, 'sender_handler' ] );
	}

	/**
	 * Sender handler
	 */
	function sender_handler(): void {
		if (
			! isset( $_POST['nonce'] )
			|| ! wp_verify_nonce( sanitize_text_field( $_POST['nonce'] ), 'newsletter_wp_plugin_subscribe' )
		) {
			wp_send_json_error( __( 'Something fishy is going on...', 'dp' ) );
		}

		$args = [];

		if ( isset( $_POST['email'] ) ) {
			$args['email'] = sanitize_email( $_POST['email'] );
		}

		if ( ! empty( $args ) ) {
			// If we cannot add user to DB it means that user already exists. We don't want to send error in this case.
			$newsletter = new Newsletter();
			$newsletter->save_data( $args );
			wp_send_json_success();
		} else {
			wp_send_json_error();
		}
	}
}
