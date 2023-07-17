<?php

namespace dp\app\domains\newsletter;

use dp\app\domains\export_data\Export_Data;

/**
 * This is the main controller for the newsletter domain
 */
class Newsletter {
	/**
	 * Main logic for the newsletter
	 */
	public function __construct() {
		$args         = Arguments::get_arguments();
		$current_page = ! empty( $args['page'] ) ? $args['page'] : '';
		if ( 'newsletter-wp-plugin' === $current_page ) {
			$this->before_render();
		}
	}

	/**
	 * Render single element
	 *
	 * @param array $args Arguments of single element.
	 *
	 * @return void
	 */
	static function render_single_element( array $args ): void {
		$model   = new Model();
		$data    = $model->get_single( $args['id'] );
		$element = new View_Single( $data );
		$element->render();
	}

	/**
	 * Render table with all newsletter emails
	 *
	 * @param array $args Arguments of list.
	 *
	 * @return void
	 */
	static function render_table( array $args ): void {
		$model = new Model();
		$data  = $model->get_list( $args );
		$table = new View_Table( $data );
		$table->render();
	}

	/**
	 * Decide which view should be displayed
	 *
	 * @return void
	 */
	static function view_controller(): void {
		$args = Arguments::get_arguments();

		if ( 'edit' === $args['action'] && ! empty( $args['id'] ) ) {
			self::render_single_element( $args );
		} else {
			self::render_table( $args );
		}
	}

	/**
	 * Before render action trigger
	 * Sometimes we need to redirect page before any header is sent
	 */
	private function before_render(): void {
		$args = Arguments::get_arguments();

		if ( current_user_can( 'manage_options' ) && ! empty( $args['action'] ) ) {

			// export data.
			if ( ! empty( $args['export'] ) && true === $args['export'] ) {
				$model = new Model();
				$data  = $model->get_all_data();
				Export_Data::export_to_csv( $data );
			}

			// delete elements.
			if ( 'delete' === $args['action'] ) {
				$model   = new Model( $args );
				$message = '';

				if ( ! empty( $args['id'] ) ) {
					$model->delete();
					$message = '&message=element_deleted';
				} elseif ( ! empty( $args['ids'] ) ) {
					$model->bulk_delete();
					$message = '&message=elements_deleted';
				}

				$http_referer = ! empty( $_SERVER['HTTP_REFERER'] ) ? sanitize_url( $_SERVER['HTTP_REFERER'] ) : '';
				$new_url      = $http_referer . $message;
				wp_redirect( $new_url );
				exit;
			}
		}
	}

	/**
	 * Save data to database on AJAX request
	 *
	 * @param array $args Data to save.
	 *
	 * @return false|int
	 */
	function save_data( array $args ): bool|int {
		$model = new Model( $args );

		return $model->save();
	}
}
