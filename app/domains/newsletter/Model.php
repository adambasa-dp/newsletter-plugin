<?php

namespace dp\app\domains\newsletter;

use dp\app\domains\database\Database;

/**
 * Data structure for the newsletter
 */
class Model {
	/**
	 * Newsletter ID.
	 *
	 * @var int
	 */
	private int $id;

	/**
	 * Newsletter list IDs.
	 *
	 * @var array
	 */
	private array $ids;

	/**
	 * Newsletter email address.
	 *
	 * @var string
	 */
	private string $email;

	/**
	 * IP address.
	 *
	 * @var string
	 */
	private string $ip;

	/**
	 * Submit date.
	 *
	 * @var string
	 */
	private string $submit_date;

	/**
	 * Constructor
	 *
	 * @param array $args Arguments.
	 */
	function __construct( array $args = [] ) {
		$this->id          = $args['id'] ?? 0;
		$this->ids         = $args['ids'] ?? [];
		$this->email       = $args['email'] ?? '';
		$this->ip          = $args['ip'] ?? '';
		$this->submit_date = $args['submit_date'] ?? '';
	}

	/**
	 * Get all newsletters from database, to export it to CSV
	 *
	 * @return array
	 */
	function get_all_data(): array {
		global $wpdb;

		$db_name = Database::get_table_name();

		return $wpdb->get_results( "SELECT * FROM {$db_name}", ARRAY_N );
	}

	/**
	 * Save email address in the database
	 *
	 * @return int ID of the inserted row. Return 0 if no row was inserted.
	 */
	function save(): int {
		global $wpdb;

		$number_of_inserted_rows = $wpdb->insert(
			Database::get_table_name(),
			[
				'email' => $this->email,
				'ip'    => $_SERVER['REMOTE_ADDR'],
			]
		);

		if ( 0 === $number_of_inserted_rows ) {
			return 0;
		}

		return $wpdb->insert_id;
	}

	/**
	 * Delete newsletter from the database
	 *
	 * @return void
	 */
	function delete(): void {
		global $wpdb;

		$wpdb->delete(
			Database::get_table_name(),
			[
				'id' => $this->id,
			]
		);
	}

	/**
	 * Delete multiple newsletter subscribers from the database
	 *
	 * @return void
	 */
	function bulk_delete(): void {
		global $wpdb;

		$db_name = Database::get_table_name();
		$ids     = implode(
			', ',
			$this->ids
		);

		$wpdb->query(
			"DELETE FROM {$db_name} WHERE id IN ({$ids})",
		);
	}

	/**
	 * Get single newsletter subscriber from the database.
	 *
	 * @param int $id Newsletter ID.
	 *
	 * @return array|object|null
	 */
	function get_single( int $id ): object|array|null {
		global $wpdb;

		$db_name = Database::get_table_name();

		$result = $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$db_name} WHERE id = %d",
				$id
			),
			ARRAY_A
		);

		$this->id          = $result['id'] ?? '';
		$this->email       = $result['email'] ?? '';
		$this->ip          = $result['ip'] ?? '';
		$this->submit_date = $result['submit_date'] ?? '';

		return $result;
	}

	/**
	 * Get emails list subscribed to the newsletter from the database. For the list view.
	 *
	 * @param array $args Arguments for the query.
	 *
	 * @return array
	 */
	function get_list( array $args = [] ): array {
		global $wpdb;

		$arguments = wp_parse_args(
			$args,
			[
				'offset'   => 0,
				'limit'    => 10,
				'order'    => 'ASC',
				'order_by' => 'id',
			]
		);

		$arguments['offset'] = 0 !== $arguments['offset'] ? ( $arguments['offset'] - 1 ) * $arguments['limit'] : 0;

		$db_name = Database::get_table_name();

		$search_query = '';
		if ( ! empty( $arguments['search'] ) ) {
			$search_query = $wpdb->prepare( ' WHERE email LIKE %s', '%' . $wpdb->esc_like( $arguments['search'] ) . '%' );
		}

		$result = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT
				            *
				        FROM
				            {$db_name}
				            {$search_query}
				        ORDER BY
				            {$arguments['order_by']} {$arguments['order']}
				        LIMIT
				            %d, %d",
				$arguments['offset'],
				$arguments['limit']
			),
			ARRAY_A
		);

		$count = $wpdb->get_var(
			$wpdb->prepare(
				"
            SELECT
                COUNT(*)
            FROM
                {$db_name}
            {$search_query}",
			)
		);

		return [
			'items'       => $result,
			'per_page'    => $arguments['limit'],
			'total_items' => $count,
		];
	}
}
