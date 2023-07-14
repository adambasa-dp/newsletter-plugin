<?php

namespace dp\app\domains\database;

/**
 * Database management
 */
class Database {
	/**
	 * Name of the table
	 */
	const TABLE_NAME = 'newsletter';

	/**
	 * Get the name of the table
	 */
	static function get_table_name(): string {
		global $wpdb;

		return $wpdb->prefix . self::TABLE_NAME;
	}

	/**
	 * In case if the table already exist, we can compare the structure of the table.
	 * If the structure is different, we will know that another plugin or theme already use the same table name.
	 *
	 * @return bool True if the structure is the same, false otherwise
	 */
	static function is_structure_the_same(): bool {
		global $wpdb;
		$table_name = self::get_table_name();

		$columns          = $wpdb->get_results( "SHOW COLUMNS FROM {$table_name}" );
		$existing_columns = array_map(
			function ( $column ) {
				return $column->field . ':' . $column->type;
			},
			$columns
		);

		$required_columns = [
			'id:int(11)',
			'email:varchar(120)',
			'ip:varchar(90)',
			'submit_date:timestamp',
		];

		$missing_columns = array_diff( $required_columns, $existing_columns );
		$extra_columns   = array_diff( $existing_columns, $required_columns );

		if ( ! empty( $missing_columns ) || ! empty( $extra_columns ) ) {
			return false;
		}

		return true;
	}


	/**
	 * Create the table for the newsletter
	 */
	static function create_table(): bool {
		global $wpdb;
		$table_name = self::get_table_name();

		if ( $wpdb->get_var( "SHOW TABLES LIKE {$table_name}" ) !== $table_name ) {
			$charset_collate = $wpdb->get_charset_collate();

			$sql = "
				CREATE TABLE IF NOT EXISTS {$table_name} (
					`id` INT NOT NULL AUTO_INCREMENT,
					`email` VARCHAR(120) NOT NULL,
					`ip` VARCHAR(90) NOT NULL,
					`submit_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
				PRIMARY KEY (`id`),
				UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE)
				ENGINE = InnoDB
				{$charset_collate}";

			require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
			dbDelta( $sql );
		} else {
			if ( ! self::is_structure_the_same() ) {
				return false;
			}
		}

		return true;
	}
}
