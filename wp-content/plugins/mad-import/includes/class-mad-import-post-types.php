<?php
/**
 * Post Types
 *
 * Registers post types and taxonomies.
 *
 * @package WooCommerce/Classes/Products
 * @version 2.5.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Post types Class.
 */
class Mad_Import_Post_Types {

	/**
	 * Hook in methods.
	 */
	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_taxonomies' ), 5 );
    add_action( 'init', array( __CLASS__, 'register_post_types' ), 5 );
		add_action( 'init', array( __CLASS__, 'support_jetpack_omnisearch' ) );
		add_filter( 'rest_api_allowed_post_types', array( __CLASS__, 'rest_api_allowed_post_types' ) );
	}

	/**
	 * Register core taxonomies.
	 */
	public static function register_taxonomies() {

		if ( ! is_blog_installed() ) {
			return;
		}

		if ( taxonomy_exists( 'product_filter' ) ) {
			return;
		}

		do_action( 'mad_import_register_taxonomy' );

		register_taxonomy(
			'product_filter',
			array( 'product' ),
			array(
				'hierarchical'      => false,
				'show_ui'           => false,
				'show_in_nav_menus' => false,
				'query_var'         => is_admin(),
				'rewrite'           => false,
				'public'            => false,
			)
		);

		do_action( 'mad_import_after_register_taxonomy' );
	}

	/**
	 * Register core post types.
	 */
	public static function register_post_types() {
		if ( ! is_blog_installed() || post_type_exists( 'product' ) ) {
			return;
		}

		do_action( 'mad_import_register_post_type' );

		$supports   = array( 'title', 'editor', 'excerpt', 'thumbnail', 'custom-fields' );
		
		$labels[] = array(
			'name'               => __( 'Products', 'ssvmad' ),
			'singular_name'      => __( 'product', 'ssvmad' ),
			'add_new'            => _x( 'Add New', 'ssvmad', 'ssvmad' ),
			'add_new_item'       => __( 'Add New', 'ssvmad' ),
			'edit_item'          => __( 'Edit product', 'ssvmad' ),
			'new_item'           => __( 'New product', 'ssvmad' ),
			'view_item'          => __( 'View product', 'ssvmad' ),
			'all_items'					 => __( 'View All', 'ssvmad' ),
			'search_items'       => __( 'Search Products', 'ssvmad' ),
			'not_found'          => __( 'No Products found', 'ssvmad' ),
			'not_found_in_trash' => __( 'No Products found in Trash', 'ssvmad' ),
			'parent_item_colon'  => __( 'Parent product:', 'ssvmad' ),
			'menu_name'          => __( 'Products', 'ssvmad' ),
		);
		
		$labels[] = array(
			'name'               => __( 'works', 'ssvmad' ),
			'singular_name'      => __( 'work', 'ssvmad' ),
			'add_new'            => _x( 'Add New', 'ssvmad', 'ssvmad' ),
			'add_new_item'       => __( 'Add New', 'ssvmad' ),
			'edit_item'          => __( 'Edit work', 'ssvmad' ),
			'new_item'           => __( 'New work', 'ssvmad' ),
			'view_item'          => __( 'View work', 'ssvmad' ),
			'all_items'					 => __( 'View All', 'ssvmad' ),
			'search_items'       => __( 'Search works', 'ssvmad' ),
			'not_found'          => __( 'No works found', 'ssvmad' ),
			'not_found_in_trash' => __( 'No works found in Trash', 'ssvmad' ),
			'parent_item_colon'  => __( 'Parent work:', 'ssvmad' ),
			'menu_name'          => __( 'Works', 'ssvmad' ),
		);
	
		$args[] = array(
			'labels'              => $labels[0],
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array('category', 'product_filter'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => $supports,
		);
	
		$args[] = array(
			'labels'              => $labels[1],
			'hierarchical'        => false,
			'description'         => 'description',
			'taxonomies'          => array('category'),
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => null,
			'menu_icon'           => null,
			'show_in_nav_menus'   => true,
			'publicly_queryable'  => true,
			'exclude_from_search' => false,
			'has_archive'         => true,
			'query_var'           => true,
			'can_export'          => true,
			'rewrite'             => true,
			'capability_type'     => 'post',
			'supports'            => $supports,
		);
	
		register_post_type( 'product', $args[0] );
		register_post_type( 'work', $args[1] );

		do_action( 'mad_import_after_register_post_type' );
	}

	/**
	 * Add Product Support to Jetpack Omnisearch.
	 */
	public static function support_jetpack_omnisearch() {
		if ( class_exists( 'Jetpack_Omnisearch_Posts' ) ) {
			new Jetpack_Omnisearch_Posts( 'product' );
		}
	}

	/**
	 * Added product for Jetpack related posts.
	 *
	 * @param  array $post_types Post types.
	 * @return array
	 */
	public static function rest_api_allowed_post_types( $post_types ) {
		$post_types[] = 'product';
		$post_types[] = 'work';

		return $post_types;
	}
}

Mad_Import_Post_types::init();
