<?php
/**
 * WooCommerce Admin
 *
 * @class    Mad_Import_Admin
 * @author   WooThemes
 * @category Admin
 * @package  WooCommerce/Admin
 * @version  2.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * Mad_Import_Admin class.
 */
class Mad_Import_Admin {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'includes' ) );
		add_action( 'admin_init', array( $this, 'buffer' ), 1 );
	}

	/**
	 * Output buffering allows admin screens to make redirects later on.
	 */
	public function buffer() {
		ob_start();
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes() {
		include_once dirname( __FILE__ ) . '/class-mad-import-admin-importers.php';

		// Importers
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
			include_once dirname( __FILE__ ) . '/class-mad-import-admin-importers.php';
		}
	}
}

return new Mad_Import_Admin();
