<?php
/**
 * Displaying data in table
 */

namespace dp\app\domains\newsletter;

if ( ! class_exists( 'WP_List_Table' ) ) {
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

use WP_List_Table;

/**
 * Display table with data and the whole functionality
 */
class View_Table extends WP_List_Table {
	/**
	 * Constructor
	 *
	 * @param array $data Data to display.
	 */
	public function __construct( $data ) {
		$this->items = $data['items'];

		$this->set_pagination_args(
			[
				'total_items' => $data['total_items'],
				'per_page'    => $data['per_page'],
				'total_pages' => ceil( $data['total_items'] / $data['per_page'] ),
			]
		);

		parent::__construct();
	}

	/**
	 * Add actions to the specific element.
	 *
	 * @param array $item Item being shown.
	 *
	 * @return string
	 */
	function column_email( array $item ): string {
		$actions = [
			'edit'   => sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s">' . __( 'Details', 'dp' ) . '</a>', $_REQUEST['page'], 'edit', $item['id'], wp_create_nonce( 'edit-' . $item['id'] ) ),
			'delete' => sprintf( '<a href="?page=%s&action=%s&id=%s&_wpnonce=%s">' . __( 'Delete', 'dp' ) . '</a>', $_REQUEST['page'], 'delete', $item['id'], wp_create_nonce( 'delete-' . $item['id'] ) ),
		];

		return sprintf( '%1$s %2$s', $item['email'], $this->row_actions( $actions ) );
	}

	/**
	 * Configure sortable columns
	 *
	 * @return array
	 */
	function get_sortable_columns(): array {
		return [
			'email'       => [ 'email', false ],
			'submit_date' => [ 'submit_date', false ],
		];
	}

	/**
	 * Configure bulk actions
	 *
	 * @return array
	 */
	function get_bulk_actions(): array {
		return [
			'delete' => __( 'Delete', 'dp' ),
		];
	}

	/**
	 * Render checkbox column
	 *
	 * @param array $item Item being shown.
	 *
	 * @return string
	 */
	function column_cb( $item ): string {
		return sprintf(
			'<input type="checkbox" name="ids[]" value="%s" />',
			$item['id']
		);
	}

	/**
	 * Decide how to display data in the admin panel
	 *
	 * @param object|array $item Item being shown.
	 * @param string       $column_name Column name.
	 */
	function column_default( $item, $column_name ) {
		switch ( $column_name ) {
			case 'email':
			case 'ip':
			case 'submit_date':
				return $item[ $column_name ];
		}
	}

	/**
	 * Set which columns are displayed
	 *
	 * @return array
	 */
	function get_columns(): array {
		return [
			'cb'          => '<input type="checkbox" />',
			'email'       => __( 'E-mail', 'dp' ),
			'ip'          => __( 'IP address', 'dp' ),
			'submit_date' => __( 'Submit date', 'dp' ),
		];
	}

	/**
	 * Configure table before display
	 *
	 * @return void
	 */
	function prepare_items(): void {
		$columns               = $this->get_columns();
		$hidden                = [];
		$sortable              = $this->get_sortable_columns();
		$this->_column_headers = [ $columns, $hidden, $sortable ];
	}

	/**
	 * Add extra markup in the toolbars before or after the list
	 *
	 * @param string $which , helps you decide if you add the markup after (bottom) or before (top) the list.
	 */
	function extra_tablenav( $which ): void {
		if ( 'top' === $which ) {
			submit_button(
				__( 'Export all to CSV', 'dp' ),
				$type = 'primary',
				$name = 'export',
				$wrap = false,
			);
		}
	}

	/**
	 * Display message on the top of page
	 *
	 * @return void
	 */
	function display_messages(): void {
		$arguments = Arguments::get_arguments();

		if ( isset( $arguments['message'] ) ) {
			echo '<div class="notice notice-success inline"><p>';

			if ( 'element_deleted' === $arguments['message'] ) {
				_e( 'Element deleted', 'dp' );
			}

			if ( 'elements_deleted' === $arguments['message'] ) {
				_e( 'Selected elements deleted', 'dp' );
			}

			echo '</p></div>';
		}
	}

	/**
	 * Render table content
	 *
	 * @return void
	 */
	function render(): void {
		echo wp_kses_post(
			'<div class="wrap">
			<h2>' . __( 'Newsletter', 'dp' ) . '</h2>'
		);

		$this->display_messages();

		echo '<form method="post"><input type="hidden" name="bulk_action" value="bulk-' . $this->_args['plural'] . '">';

		$this->search_box( __( 'Search', 'dp' ), 'newsletter_id' );
		$this->prepare_items();
		$this->display();

		echo '</form></div>';
	}
}
