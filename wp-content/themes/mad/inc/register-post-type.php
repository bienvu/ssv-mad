<?php 
  /* Registrer post menu */
  register_post_type( 'artistry',
    array(
      'labels' => array(
        'add_new_item'        => __('Add Artistry', 'ssvmad'),
        'name'                => __('Artistry', 'ssvmad'),
        'singular_name'       => __('Artistry', 'ssvmad'),
        'edit_item'           => __('Edit Artistry', 'ssvmad'),
        'view_item'           => __('View Artistry', 'ssvmad'),
        'view_items'          => __('View Artistry', 'ssvmad'),
        'search_items'        => __('Search Artistry', 'ssvmad'),
        'not_found'           => __('No Artistry Found', 'ssvmad'),
        'not_found_in_trash'  => __(' No Artistry found in Trash', 'ssvmad'),
        'all_items'            => __('All Artistry', 'ssvmad')
      ),
      'public' => true,
      'has_archive' => false,
      'show_in_menu' => true,
      'supports' => array('title','editor','custom-fields', 'revisions', 'thumbnail'),
      'show_in_nav_menus' => true,
      'exclude_from_search' => true,
      'publicly_queryable' => true,
      'hierarchical' => true,
      'rewrite' => array('slug' => 'artistry'),
    )
  );
?>