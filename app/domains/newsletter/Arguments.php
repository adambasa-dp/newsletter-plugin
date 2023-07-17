<?php
/**
 * Helper for validation and sanitization of all arguments passed to the plugin.
 */

namespace dp\app\domains\newsletter;

/**
 * Helper class for getting all arguments from the request
 * Sanitize all arguments
 */
class Arguments {
	/**
	 * Authorize user and action
	 *
	 * @return bool|int
	 */
	static function authorize(): bool|int {
		// if nonce exists, verify it.
		if ( isset( $_GET['_wpnonce'] ) ) {
			$nonce = sanitize_text_field( $_GET['_wpnonce'] );
		} elseif ( isset( $_POST['_wpnonce'] ) ) {
			$nonce = sanitize_text_field( $_POST['_wpnonce'] );
		} else {
			return false;
		}

		if ( ! empty( $_GET['id'] ) ) {
			$id = sanitize_text_field( $_GET['id'] );

			return wp_verify_nonce( $nonce, 'delete-' . $id ) || wp_verify_nonce( $nonce, 'edit-' . $id );
		}

		// if bulk action exists, verify it.
		if ( ! empty( $_POST['bulk_action'] ) && ! empty( $_POST['ids'] ) ) {
			$action = sanitize_text_field( $_POST['bulk_action'] );

			return wp_verify_nonce( $nonce, $action );
		}

		// if bulk action is called, but we don't have any IDs to work with, there is no risk - return true.
		if ( ! empty( $_POST['bulk_action'] ) && empty( $_POST['ids'] ) ) {
			return true;
		}

		return false;
	}

	/**
	 * Get all arguments from the request
	 *
	 * @return bool|array
	 */
	static function get_arguments(): bool|array {
		if ( ! current_user_can( 'manage_options' ) ) {
			return false;
		}

		$args = [];

		// actions.
		if ( isset( $_GET['action'] ) ) {
			$args['action'] = sanitize_text_field( $_GET['action'] );
		} elseif ( isset( $_POST['action'] ) && '-1' !== $_POST['action'] ) {
			$args['action'] = sanitize_text_field( $_POST['action'] );
		} else {
			$args['action'] = 'list';
		}

		if ( 'list' !== $args['action'] ) {
			if ( self::authorize() === false ) {
				return false;
			}
		}

		// table view arguments.
		if ( isset( $_GET['paged'] ) ) {
			$args['offset'] = sanitize_text_field( $_GET['paged'] );
		}

		if ( isset( $_GET['orderby'] ) ) {
			$args['order_by'] = sanitize_text_field( $_GET['orderby'] );
		}

		if ( isset( $_GET['order'] ) ) {
			$args['order'] = sanitize_text_field( $_GET['order'] );
		}

		if ( isset( $_POST['s'] ) ) {
			$args['search'] = sanitize_text_field( $_POST['s'] );
		}

		if ( isset( $_GET['id'] ) ) {
			$args['id'] = sanitize_text_field( $_GET['id'] );
		} else {
			$args['id'] = 0;
		}

		if ( isset( $_POST['ids'] ) ) {
			$args['ids'] = [];

			foreach ( $_POST['ids'] as $id ) {
				$args['ids'][] = sanitize_text_field( $id );
			}
		}

		// messages to display.
		if ( isset( $_GET['message'] ) ) {
			$args['message'] = sanitize_text_field( $_GET['message'] );
		}

		// export data.
		if ( isset( $_POST['export'] ) ) {
			$args['export'] = true;
		}

		// pagination.
		if ( isset( $_GET['page'] ) ) {
			$args['page'] = $_GET['page'];
		}

		return $args;
	}
}
