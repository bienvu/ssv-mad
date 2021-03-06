<?php
/**
 * Init WooCommerce data importers.
 *
 * @package WooCommerce/Admin
 */

defined( 'ABSPATH' ) || exit;

/**
 * WC_Admin_Importers Class.
 */
class Mad_Import_Admin_Importers {

	/**
	 * Array of importer IDs.
	 *
	 * @var string[]
	 */
	protected $importers = array();

	/**
	 * Constructor.
	 */
	public function __construct() {
		if ( ! $this->import_allowed() ) {
			return;
		}

		add_action( 'admin_menu', array( $this, 'add_to_menus' ) );
		add_action( 'admin_init', array( $this, 'register_importers' ) );
		add_action( 'admin_head', array( $this, 'hide_from_menus' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		add_action( 'wp_ajax_mad_import_do_ajax_product_import', array( $this, 'do_ajax_product_import' ) );

		// Register WooCommerce importers.
		$this->importers['product_importer'] = array(
			'menu'       => 'tools.php',
			'name'       => __( 'Product Import', 'ssvmad' ),
			'capability' => 'import',
			'callback'   => array( $this, 'product_importer' ),
		);
	}

	/**
	 * Return true if WooCommerce imports are allowed for current user, false otherwise.
	 *
	 * @return bool Whether current user can perform imports.
	 */
	protected function import_allowed() {
		return current_user_can( 'import' );
	}

	/**
	 * Add menu items for our custom importers.
	 */
	public function add_to_menus() {
		foreach ( $this->importers as $id => $importer ) {
			add_submenu_page( $importer['menu'], $importer['name'], $importer['name'], $importer['capability'], $id, $importer['callback'] );
		}
	}

	/**
	 * Hide menu items from view so the pages exist, but the menu items do not.
	 */
	public function hide_from_menus() {
		global $submenu;

		foreach ( $this->importers as $id => $importer ) {
			if ( isset( $submenu[ $importer['menu'] ] ) ) {
				foreach ( $submenu[ $importer['menu'] ] as $key => $menu ) {
					if ( $id === $menu[2] ) {
						unset( $submenu[ $importer['menu'] ][ $key ] );
					}
				}
			}
		}
	}

	/**
	 * Register importer scripts.
	 */
	public function admin_scripts() {
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script( 'mad-import-product-import', MAD_IMPORT_DIRNAME . 'assets/js/admin/mad-import-product-import.js', array( 'jquery' ) );
	}

	/**
	 * The product importer.
	 *
	 * This has a custom screen - the Tools > Import item is a placeholder.
	 * If we're on that screen, redirect to the custom one.
	 */
	public function product_importer() {
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
			wp_safe_redirect( admin_url( 'tools.php?page=product_importer' ) );
			exit;
		}
    
		include_once MAD_IMPORT_ABSPATH . 'includes/admin/importers/class-mad-import-product-csv-importer-controller.php';

		$importer = new Mad_Import_Product_CSV_Importer_Controller();
		$importer->dispatch();
	}

	/**
	 * Register WordPress based importers.
	 */
	public function register_importers() {
		if ( defined( 'WP_LOAD_IMPORTERS' ) ) {
			register_importer( 'mad_import_product_csv', __( 'Mad Import products (CSV)', 'ssvmad' ), __( 'Import <strong>products</strong> to your store via a csv file.', 'ssvmad' ), array( $this, 'product_importer' ) );
		}
	}

	/**
	 * Ajax callback for importing one batch of products from a CSV.
	 */
	public function do_ajax_product_import() {
		global $wpdb;

		check_ajax_referer( 'mad-import-product-import', 'security' );

		if ( ! $this->import_allowed() || ! isset( $_POST['file'] ) ) { // PHPCS: input var ok.
			wp_send_json_error( array( 'message' => __( 'Insufficient privileges to import products.', 'ssvmad' ) ) );
		}

		include_once MAD_IMPORT_ABSPATH . 'includes/admin/importers/class-mad-import-product-csv-importer-controller.php';
		include_once MAD_IMPORT_ABSPATH . 'includes/import/class-mad-import-product-csv-importer.php';

		$file   = wc_clean( wp_unslash( $_POST['file'] ) ); // PHPCS: input var ok.
		$params = array(
			'delimiter'       => ! empty( $_POST['delimiter'] ) ? wc_clean( wp_unslash( $_POST['delimiter'] ) ) : ',', // PHPCS: input var ok.
			'start_pos'       => isset( $_POST['position'] ) ? absint( $_POST['position'] ) : 0, // PHPCS: input var ok.
			'mapping'         => isset( $_POST['mapping'] ) ? (array) wc_clean( wp_unslash( $_POST['mapping'] ) ) : array(), // PHPCS: input var ok.
			'update_existing' => isset( $_POST['update_existing'] ) ? (bool) $_POST['update_existing'] : false, // PHPCS: input var ok.
			'lines'           => apply_filters( 'woocommerce_product_import_batch_size', 5 ),
			'parse'           => true,
      'post_type'       => isset( $_POST['post_type'] ) ? wc_clean( wp_unslash( $_POST['post_type'] ) ) : '',
		);

		// Log failures.
		if ( 0 !== $params['start_pos'] ) {
      $error_log = array_filter( (array) get_user_option( 'product_import_error_log' ) );
		} else {
      $error_log = array();
      update_user_option( get_current_user_id(), 'product_import_list_sku', array() );
      update_user_option( get_current_user_id(), 'product_import_related', array() );
      update_user_option( get_current_user_id(), 'product_import_related_row', 0 );
      update_user_option( get_current_user_id(), 'product_import_error_log', array() );
		}

		$importer         = Mad_Import_Product_CSV_Importer_Controller::get_importer( $file, $params );
		$results          = $importer->import();
		$percent_complete = $importer->get_percent_complete();

    if (!empty($results['failed'])) {
      $error_log        = array_merge( $error_log, $results['failed'] );
      update_user_option( get_current_user_id(), 'product_import_error_log', $error_log );
    }
    

		if ( 100 === $percent_complete ) {
      $status_related = $importer->import_related();

      if($status_related == 'done') {
        wp_send_json_success(
          array(
            'position'   => 'done',
            'percentage' => 100,
            'url'        => add_query_arg( array( 'nonce' => wp_create_nonce( 'product-csv' ) ), admin_url( 'tools.php?page=product_importer&step=done' ) ),
            'imported'   => count( $results['imported'] ),
            'failed'     => count( $results['failed'] ),
            'updated'    => count( $results['updated'] ),
            'skipped'    => count( $results['skipped'] ),
            'status_related' => $status_related,
          )
        );
      } else {
        wp_send_json_success(
          array(
            'position'   => $importer->get_file_position(),
            'percentage' => 100,
            'imported'   => count( $results['imported'] ),
            'failed'     => count( $results['failed'] ),
            'updated'    => count( $results['updated'] ),
            'skipped'    => count( $results['skipped'] ),
            'status_related' => $status_related,
          )
        );
      }
		} else {
			wp_send_json_success(
				array(
					'position'   => $importer->get_file_position(),
					'percentage' => $percent_complete,
					'imported'   => count( $results['imported'] ),
					'failed'     => count( $results['failed'] ),
					'updated'    => count( $results['updated'] ),
					'skipped'    => count( $results['skipped'] ),
				)
			);
		}
	}
}

new Mad_Import_Admin_Importers();
