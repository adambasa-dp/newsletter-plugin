<?php

namespace dp\app\domains\shortcode;

/**
 * Add shortcode
 */
class Shortcode {
	/**
	 * Shortcode name
	 */
	const SHORTCODE_NAME = 'newsletter-wp-plugin';

	/**
	 * Add shortcode
	 */
	public function __construct() {
		add_shortcode( self::SHORTCODE_NAME, [ $this, 'render_shortcode' ] );
	}

	/**
	 * Render the shortcode.
	 *
	 * @param array $atts User defined attributes in shortcode tag.
	 *
	 * @return string
	 */
	function render_shortcode( $atts ): string {
		$atts = shortcode_atts(
			[
				'title'          => __( 'Newsletter', 'dp' ),
				'placeholder'    => __( 'E-mail', 'dp' ),
				'button_title'   => __( 'Subscribe', 'dp' ),
				'agreement_text' => __( 'You must accept the terms and conditions to subscribe to the newsletter', 'dp' ),
			],
			$atts,
			self::SHORTCODE_NAME
		);

		return apply_filters( 'newsletter_wp_plugin_print_frontend', $atts );
	}
}

