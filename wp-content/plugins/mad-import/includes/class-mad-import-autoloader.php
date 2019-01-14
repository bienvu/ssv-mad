<?php
/**
 * Mad_Import Autoloader.
 */

defined( 'ABSPATH' ) || exit;

/**
 * Autoloader class.
 */
class Mad_Import_Autoloader {

  /**
   * Path to the includes directory.
   *
   * @var string
   */
  private $include_path = '';

  /**
   * The Constructor.
   */
  public function __construct() {
    if ( function_exists( '__autoload' ) ) {
      spl_autoload_register( '__autoload' );
    }

    spl_autoload_register( array( $this, 'autoload' ) );

    $this->include_path = dirname( MAD_PLUGIN_FILE ) . '/includes/';
  }

  /**
   * Take a class name and turn it into a file name.
   *
   * @param  string $class Class name.
   * @return string
   */
  private function get_file_name_from_class( $class ) {
    return 'class-' . str_replace( '_', '-', $class ) . '.php';
  }

  /**
   * Include a class file.
   *
   * @param  string $path File path.
   * @return bool Successful or not.
   */
  private function load_file( $path ) {
    if ( $path && is_readable( $path ) ) {
      include_once $path;
      return true;
    }
    return false;
  }

  /**
   * Auto-load Mad_Import classes on demand to reduce memory consumption.
   *
   * @param string $class Class name.
   */
  public function autoload( $class ) {
    $class = strtolower( $class );

    if ( 0 !== strpos( $class, 'mad_import' ) ) {
      return;
    }

    $file = $this->get_file_name_from_class( $class );
    $path = '';

    if ( 0 === strpos( $class, 'mad_import_admin' ) ) {
      $path = $this->include_path . 'admin/';
    } elseif ( 0 === strpos( $class, 'mad_import_product_csv_importer' ) ) {
      $path = $this->include_path . 'import/';
    }

    if ( empty( $path ) || ! $this->load_file( $path . $file ) ) {
      $this->load_file( $this->include_path . $file );
    }
  }
}

new Mad_Import_Autoloader();
