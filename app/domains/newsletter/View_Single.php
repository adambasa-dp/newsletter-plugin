<?php
/**
 * Displaying single element
 */

namespace dp\app\domains\newsletter;

/**
 * Class Single for single element
 */
class View_Single {
	/**
	 * Item details
	 *
	 * @var array
	 */
	private array $item;

	/**
	 * Gen single element to display.
	 *
	 * @param array $data Item details.
	 */
	public function __construct( array $data ) {
		$this->item = $data;
	}

	/**
	 * Render table content
	 *
	 * @return void
	 */
	function render(): void {
		echo wp_kses_post(
			'<div class="wrap"><h2>' . __( 'Newsletter details', 'dp' ) . '</h2>
			<div class="wrap"><h3>' . __( 'E-mail', 'dp' ) . '</h3>
			<p><a href="mailto:' . $this->item['email'] . '">' . $this->item['email'] . '</a></p>
			<div class="wrap"><h3>' . __( 'Submit date', 'dp' ) . '</h3>
			<p>' . $this->item['submit_date'] . '</p>
			<div class="wrap"><h3>' . __( 'IP address', 'dp' ) . '</h3>
			<p>' . $this->item['ip'] . '</p>
			</div>'
		);
	}
}
