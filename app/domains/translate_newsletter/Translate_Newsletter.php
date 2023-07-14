<?php
/**
 * Define how to deal with translations in the plugin
 */

namespace dp\app\domains\translate_newsletter;

/**
 * Class for translate
 */
class Translate_Newsletter {
	/**
	 * Init plugin and theme translations
	 */
	public function __construct() {
		add_action( 'init', [ $this, 'translate_plugin' ] );
	}

	/**
	 * Translate plugin
	 */
	function translate_plugin(): void {
		load_plugin_textdomain( 'dp', false, dirname( plugin_basename( __FILE__ ) ) . '/../../assets/i18n' );
	}
}
