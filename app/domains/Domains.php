<?php
/**
 * Register all domains
 */

namespace dp\app\domains;

use dp\app\domains\admin_panel\Admin_Panel;
use dp\app\domains\gutenberg_block\Gutenberg_Block;
use dp\app\domains\newsletter\Newsletter;
use dp\app\domains\shortcode\Shortcode;
use dp\app\domains\template\Template;
use dp\app\domains\translate_newsletter\Translate_Newsletter;

/**
 * Load required domains
 */
class Domains {
	/**
	 * Load required domains on plugin init
	 */
	public function __construct() {
		new Translate_Newsletter();
		new Template();
		new Newsletter();
		new Shortcode();
		new Gutenberg_Block();
		new Admin_Panel();
	}
}
