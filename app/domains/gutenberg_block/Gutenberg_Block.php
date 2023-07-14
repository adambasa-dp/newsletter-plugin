<?php

namespace dp\app\domains\gutenberg_block;

/**
 * Gutenberg block for newsletter - make it easier to add newsletter form to the page
 */
class Gutenberg_Block {
	/**
	 * Gutenberg_Block constructor.
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'register_block' ] );
	}

	/**
	 * Register newsletter Gutenberg block
	 */
	function register_block() {
		wp_register_script(
			'newsletter_wp_plugin_block',
			plugins_url( '../../assets/js/block.min.js', __FILE__ ),
			[ 'wp-blocks', 'wp-element', 'wp-editor' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'block.js' )
		);

		register_block_type(
			'newsletter-wp-plugin/newsletter',
			[
				'editor_script'   => 'newsletter_wp_plugin_block',
				'render_callback' => [ $this, 'render_newsletter_block' ],
				'attributes'      => [
					'title'          => [
						'type'    => 'string',
						'default' => '',
					],
					'placeholder'    => [
						'type'    => 'string',
						'default' => '',
					],
					'button_title'   => [
						'type'    => 'string',
						'default' => '',
					],
					'agreement_text' => [
						'type'    => 'string',
						'default' => '',
					],
				],
			]
		);
	}

	/**
	 * Render newsletter block
	 *
	 * @param array $attributes Block attributes.
	 *
	 * @return string
	 */
	function render_newsletter_block( array $attributes ): string {
		$shortcode = sprintf(
			'[newsletter-wp-plugin title="%s" placeholder="%s" button_title="%s" agreement_text="%s"]',
			esc_attr( $attributes['title'] ),
			esc_attr( $attributes['placeholder'] ),
			esc_attr( $attributes['button_title'] ),
			esc_attr( $attributes['agreement_text'] )
		);

		return do_shortcode( $shortcode );
	}
}
