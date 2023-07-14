<?php
/**
 * Functionality responsible for exporting data to external files - csv.
 */

namespace dp\app\domains\export_data;

/**
 * Define functionality for exporting data to external files
 */
class Export_Data {
	/**
	 * Filename of the exported CSV file
	 */
	const CSV_FILENAME = 'newsletter';


	/**
	 * Headers of the exported CSV file
	 */
	const CSV_HEADERS = [
		'id'          => 'ID',
		'email'       => 'E-mail',
		'ip'          => 'IP Address',
		'submit_date' => 'Submit date',
	];

	/**
	 * Export data to csv file.
	 *
	 * @param array $data Data to export.
	 */
	static function export_to_csv( array $data ): void {
		$delimiter      = ',';
		$final_filename = self::CSV_FILENAME . '-' . gmdate( 'd-m-Y' ) . '.csv';

		// Create a file pointer.
		$f = fopen( 'php://memory', 'w' );

		// Set column headers.
		fputcsv( $f, self::CSV_HEADERS, $delimiter );

		// Output each row of the data, format line as csv and write to file pointer.
		foreach ( $data as $row ) {
			fputcsv( $f, $row, $delimiter );
		}

		// Move back to beginning of file.
		fseek( $f, 0 );

		// Set headers to download file rather than displayed.
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment; filename="' . $final_filename . '";' );

		// output all remaining data on a file pointer.
		fpassthru( $f );
		exit;
	}
}
