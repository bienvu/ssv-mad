<?php 
  /* Registrer post menu */
  register_post_type( 'artistry',
    array(
      'labels' => array(
        'add_new_item'        => __('Add Artistry', 'ssvmad'),
        'name'                => __('Artistrys', 'ssvmad'),
        'singular_name'       => __('Artistrys', 'ssvmad'),
        'edit_item'           => __('Edit Artistrys', 'ssvmad'),
        'view_item'           => __('View Artistry', 'ssvmad'),
        'view_items'          => __('View Artistrys', 'ssvmad'),
        'search_items'        => __('Search Artistrys', 'ssvmad'),
        'not_found'           => __('No Artistrys Found', 'ssvmad'),
        'not_found_in_trash'  => __(' No Artistrys found in Trash', 'ssvmad'),
        'all_items'            => __('All Artistrys', 'ssvmad')
      ),
      'public' => true,
      'has_archive' => true,
      'show_in_menu' => true,
      'supports' => array('title','editor','custom-fields', 'revisions'),
      'show_in_nav_menus' => true,
      'exclude_from_search' => true,
      'publicly_queryable' => true,
      'hierarchical' => true,
      'rewrite' => array('slug' => 'artistry'),
    )
  );
?>