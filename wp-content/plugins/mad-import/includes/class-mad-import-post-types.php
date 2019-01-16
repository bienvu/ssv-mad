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
    add_action( 'init', array( __CLASS__, 'register_custom_field' ), 5 );
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
			array( 'product', 'work' ),
			array(
				'hierarchical'      => true,
				'show_ui'           => true,
				'query_var'         => is_admin(),
				'label'        => __( 'Product Filter', 'ssvmad' ),
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

		$supports   = array( 'title', 'editor', 'custom-fields' );
		
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
			'name'               => __( 'Work', 'ssvmad' ),
			'singular_name'      => __( 'Work', 'ssvmad' ),
			'add_new'            => _x( 'Add New', 'ssvmad', 'ssvmad' ),
			'add_new_item'       => __( 'Add New', 'ssvmad' ),
			'edit_item'          => __( 'Edit Work', 'ssvmad' ),
			'new_item'           => __( 'New Work', 'ssvmad' ),
			'view_item'          => __( 'View work', 'ssvmad' ),
			'all_items'					 => __( 'View All', 'ssvmad' ),
			'search_items'       => __( 'Search Works', 'ssvmad' ),
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
			'taxonomies'          => array('product_filter'),
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
  /*
    register custom field
   */
  public static function register_custom_field()
  {
    if( function_exists('acf_add_local_field_group') ) {
      /*
      custom field post type work
       */
      if(empty(acf_get_fields('mad_import_work_123'))) {
        acf_add_local_field_group(
          array(
            'key' => 'mad_import_work_123',
            'title' => 'Work Field',
            'location' => array (
              array (
                array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'work',
                ),
              ),
            ),
          )
        );
        /*add field weight if empty*/
        if(empty(acf_get_fields('mad_import_work_weight_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_work_weight_123',
            'label' => 'Weight',
            'name' => 'work_weight',
            'type' => 'text',
            'parent' => 'mad_import_work_123'
          ));
        }
        /*add field featured image if empty*/
        if(empty(acf_get_fields('mad_import_work_featured_image_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_work_featured_image_123',
            'label' => 'Featured Image',
            'name' => 'work_featured_image',
            'type' => 'image',
            'parent' => 'mad_import_work_123'
          ));
        }
        /*add field gallery if empty*/
        if(empty(acf_get_fields('mad_import_work_gallery_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_work_gallery_123',
            'label' => 'Gallery',
            'name' => 'work_gallery',
            'type' => 'gallery',
            'parent' => 'mad_import_work_123'
          ));
        }
      }

      /*
      custom field post type product
       */
      if(empty(acf_get_fields('mad_import_product_123'))) {
        acf_add_local_field_group(
          array(
            'key' => 'mad_import_product_123',
            'title' => 'Product Field',
            'location' => array (
              array (
                array (
                  'param' => 'post_type',
                  'operator' => '==',
                  'value' => 'product',
                ),
              ),
            ),
          )
        );
        /*add field weight if empty*/
        if(empty(acf_get_fields('mad_import_product_weight_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_weight_123',
            'label' => 'Weight',
            'name' => 'product_weight',
            'type' => 'text',
            'parent' => 'mad_import_product_123'
          ));
        }
        /*add field featured image if empty*/
        if(empty(acf_get_fields('mad_import_product_featured_image_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_featured_image_123',
            'label' => 'Featured Image',
            'name' => 'product_featured_image',
            'type' => 'image',
            'parent' => 'mad_import_product_123'
          ));
        }
        /*add field gallery if empty*/
        if(empty(acf_get_fields('mad_import_product_gallery_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_gallery_123',
            'label' => 'Gallery',
            'name' => 'product_gallery',
            'type' => 'gallery',
            'parent' => 'mad_import_product_123'
          ));
        }
        /*add field Sku if empty*/
        if(empty(acf_get_fields('mad_import_product_sku_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_sku_123',
            'label' => 'Sku',
            'name' => 'product_sku',
            'type' => 'text',
            'parent' => 'mad_import_product_123'
          ));
        }
        /*add field Sku if empty*/
        if(empty(acf_get_fields('mad_import_product_sku_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_sku_123',
            'label' => 'Sku',
            'name' => 'product_sku',
            'type' => 'text',
            'parent' => 'mad_import_product_123'
          ));
        }
        /*add field You may also like if empty*/
        if(empty(acf_get_fields('mad_import_product_related_123'))) {
          acf_add_local_field(array(
            'key' => 'mad_import_product_related_123',
            'label' => 'You may also like',
            'name' => 'product_realted',
            'type' => 'post_object',
            'parent' => 'mad_import_product_123',
            'post_type' => 'product',
            'multiple' => true,
            'return_format' => 'id'
          ));
        }
      }
    }
  }
}

Mad_Import_Post_types::init();
