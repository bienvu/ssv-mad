<?php
/**
 * Mad setup
 */

defined( 'ABSPATH' ) || exit;

/**
 * Main Mad_Import Class.
 *
 * @class Mad_Import
 */
final class Mad_Import {

  /**
   * WooCommerce version.
   *
   * @var string
   */
  public $version = '1.0.0';

  /**
   * The single instance of the class.
   *
   * @var WooCommerce
   * @since 2.1
   */
  protected static $_instance = null;

  /**
   * Session instance.
   *
   * @var WC_Session|WC_Session_Handler
   */
  public $session = null;

  /**
   * Query instance.
   *
   * @var WC_Query
   */
  public $query = null;

  /**
   * Product factory instance.
   *
   * @var WC_Product_Factory
   */
  public $product_factory = null;

  /**
   * Countries instance.
   *
   * @var WC_Countries
   */
  public $countries = null;

  /**
   * Integrations instance.
   *
   * @var WC_Integrations
   */
  public $integrations = null;

  /**
   * Cart instance.
   *
   * @var WC_Cart
   */
  public $cart = null;

  /**
   * Customer instance.
   *
   * @var WC_Customer
   */
  public $customer = null;

  /**
   * Order factory instance.
   *
   * @var WC_Order_Factory
   */
  public $order_factory = null;

  /**
   * Structured data instance.
   *
   * @var WC_Structured_Data
   */
  public $structured_data = null;

  /**
   * Array of deprecated hook handlers.
   *
   * @var array of WC_Deprecated_Hooks
   */
  public $deprecated_hook_handlers = array();

  /**
   * Cloning is forbidden.
   *
   * @since 2.1
   */
  public function __clone() {
    wc_doing_it_wrong( __FUNCTION__, __( 'Cloning is forbidden.', 'ssvmad' ), '2.1' );
  }

  /**
   * Unserializing instances of this class is forbidden.
   *
   * @since 2.1
   */
  public function __wakeup() {
    wc_doing_it_wrong( __FUNCTION__, __( 'Unserializing instances of this class is forbidden.', 'ssvmad' ), '2.1' );
  }

  /**
   * Mad_Import Constructor.
   */
  public function __construct() {
    $this->define_constants();
    $this->includes();
    add_action('admin_enqueue_scripts', array($this, 'mad_import_admin_style' ));

    do_action( 'mad_import_loaded' );
  }

  /**
   * Define MAD_IMPORT Constants.
   */
  private function define_constants() {
    $upload_dir = wp_upload_dir( null, false );

    $this->define( 'MAD_IMPORT_ABSPATH', dirname( MAD_PLUGIN_FILE ) . '/' );
    $this->define( 'MAD_IMPORT_PLUGIN_BASENAME', plugin_basename( MAD_PLUGIN_FILE ) );
    $this->define( 'MAD_IMPORT_DIRNAME', plugins_url().'/mad-import/' );
    $this->define( 'MAD_IMPORT_VERSION', $this->version );
  }

  /**
   * Define constant if not already set.
   *
   * @param string      $name  Constant name.
   * @param string|bool $value Constant value.
   */
  private function define( $name, $value ) {
    if ( ! defined( $name ) ) {
      define( $name, $value );
    }
  }

  /**
   * What type of request is this?
   *
   * @param  string $type admin, ajax, cron or frontend.
   * @return bool
   */
  private function is_request( $type ) {
    switch ( $type ) {
      case 'admin':
        return is_admin();
    }
  }

  /**
   * Include required core files used in admin and on the frontend.
   */
  public function includes() {
    /**
     * Class autoloader.
     */
    include_once MAD_IMPORT_ABSPATH . 'includes/class-mad-import-autoloader.php';

    /**
     * Interfaces.
     */
    include_once MAD_IMPORT_ABSPATH . 'includes/interfaces/class-mad-import-importer-interface.php';

    /**
     * Core classes.
     */
    include_once MAD_IMPORT_ABSPATH . 'includes/mad-import-core-functions.php';
    include_once MAD_IMPORT_ABSPATH . 'includes/class-mad-import-post-types.php';

    if ( $this->is_request( 'admin' ) ) {
      include_once MAD_IMPORT_ABSPATH . 'includes/admin/class-mad-import-admin.php';
    }
  }

  /**
   * Ensure post thumbnail support is turned on.
   */
  private function add_thumbnail_support() {
    if ( ! current_theme_supports( 'post-thumbnails' ) ) {
      add_theme_support( 'post-thumbnails' );
    }
    add_post_type_support( 'product', 'thumbnail' );
  }

  public function mad_import_admin_style()
  {
    wp_register_style('mad_import_admin_styles', MAD_IMPORT_DIRNAME . 'assets/css/main.css', array(), '1.0', 'all');
    wp_enqueue_style('mad_import_admin_styles');
  }
}
