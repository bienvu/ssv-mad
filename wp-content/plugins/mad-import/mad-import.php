<?php
/**
 * Plugin Name: Mad Import
 * Plugin URI: none
 * Description: An eCommerce toolkit that helps you sell anything. Beautifully.
 * Version: 1.0.0
 * Author: Automattic
 * Author URI: none
 */

if ( ! defined( 'ABSPATH' ) ) {
  exit; // Exit if accessed directly.
}

// Define MAD_PLUGIN_FILE.
if ( ! defined( 'MAD_PLUGIN_FILE' ) ) {
  define( 'MAD_PLUGIN_FILE', __FILE__ );
}

// Include the main WooCommerce class.
if ( ! class_exists( 'Mad_Import' ) ) {
  include_once dirname( __FILE__ ) . '/includes/class-mad-import.php';
}

$GLOBALS['mad_import'] = new Mad_Import();
