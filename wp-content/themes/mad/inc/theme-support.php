<?php
// Add theme options.
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Theme General Settings',
    'menu_title'  => 'Theme Settings',
    'menu_slug'   => 'theme-general-settings',
    'capability'  => 'edit_posts',
    'redirect'    => false
  ));
}

// Theme support
if (function_exists('add_theme_support')) {
    // Woocommerce support theme.
    // add_theme_support( 'woocommerce' );

    // Add Menu Support
    add_theme_support('menus');

    // Add Thumbnail Theme Support
    add_theme_support('post-thumbnails');
    // add_image_size('large', 700, '', true); // Large Thumbnail
    // add_image_size('medium', 250, '', true); // Medium Thumbnail
    // add_image_size('small', 120, '', true); // Small Thumbnail
}

// Allow SVG through WordPress Media Uploader
function ssv_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'ssv_mime_types');

// Register sentius Blank Navigation
function ssv_register_menu()
{
  register_nav_menus(array( // Using array to specify more menus if needed
    'header-menu' => __('Header Menu', 'ssvtheme'), // Main Navigation
    'sidebar-menu' => __('Sidebar Menu', 'ssvtheme'), // Sidebar Navigation
    'extra-menu' => __('Extra Menu', 'ssvtheme') // Extra Navigation if needed (duplicate as many as you need!)
  ));
}
add_action('init', 'ssv_register_menu');

?>
