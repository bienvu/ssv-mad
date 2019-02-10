<?php
// Add theme options.
if( function_exists('acf_add_options_page') ) {
  acf_add_options_page(array(
    'page_title'  => 'Theme General Options',
    'menu_title'  => 'Theme Options',
    'menu_slug'   => 'theme-general-options',
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
    add_image_size('menu-first', 750, 350, true); // menu first
    add_image_size('menu-second', 750, 500, true); // menu second
    add_image_size('banner', 2732, 1600, true); // image for banner
}

// Allow SVG through WordPress Media Uploader
function mad_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'mad_mime_types');

// Register sentius Blank Navigation
function mad_register_menu()
{
  register_nav_menus(array( // Using array to specify more menus if needed
    'header-menu' => __('Header Menu', 'madtheme'), // Main Navigation
    'sidebar-menu' => __('Sidebar Menu', 'madtheme'), // Sidebar Navigation
    'footer-menu' => __('Footer Menu', 'madtheme') // Extra Navigation if needed (duplicate as many as you need!)
  ));
}
add_action('init', 'mad_register_menu');

?>
