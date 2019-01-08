<?php 
  /* Registrer post menu */
  register_post_type( 'products',
    array(
      'labels' => array(
        'add_new_item'        => __('Add Product', 'products'),
        'name'                => __('Products', 'products'),
        'singular_name'       => __('Products', 'products'),
        'edit_item'           => __('Edit Products', 'products'),
        'view_item'           => __('View Product', 'products'),
        'view_items'          => __('View Products', 'products'),
        'search_items'        => __('Search Products', 'products'),
        'not_found'           => __('No Products Found', 'products'),
        'not_found_in_trash'  => __(' No Products found in Trash', 'products'),
        'all_items'            => __('All Products', 'products')
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_menu' => true,
      'supports' => array('title','editor','custom-fields', 'revisions'),
      'show_in_nav_menus' => true,
      'exclude_from_search' => true,
      'publicly_queryable' => true,
      'hierarchical' => true,
      'rewrite' => array('slug' => 'products'),
      'taxonomies'     => array('category')
    )
  );
?>