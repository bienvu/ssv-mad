<?php
/*
 *  Author: Sentius Group
 *  URL: sentiustdigital.com | @ssvtheme
 *  Custom functions, support, custom post types and more.
 */

require get_template_directory() . '/inc/init.php';

/*------------------------------------*\
  Functions
\*------------------------------------*/
// Navigation
function ssv_navigation($menuclass, $name, $themelocaltion='') {
  wp_nav_menu(
  array(
    'theme_location'  => $themelocaltion,
    'menu'            => $name,
    'container'       => '',
    'container_class' => '$menuclass',
    'container_id'    => '',
    'menu_class'      => $menuclass,
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul>%3$s</ul>',
    'depth'           => 0,
    'walker'          => ''
    )
  );
}

// Add i tag after a in navigation
function ssv_add_arrow( $item_output, $item, $depth, $args ){
    //Only add class to 'top level' items on the 'primary' menu.
    $hasChildren = (in_array('menu-item-has-children', $item->classes));

    if('has-icon' == $args->theme_location && $hasChildren && $depth == 0 ){
        $item_output .='<i class="js-show-menu icon-arrow-right"></i>';
    }
    return $item_output;
}

// Set class for menu dropdown
function ssv_ssv_menu_set_dropdown( $sorted_menu_items, $args ) {
    $last_top = 0;
    foreach ( $sorted_menu_items as $key => $obj ) {
        // it is a top lv item?
        if ( 0 == $obj->menu_item_parent ) {
            // set the key of the parent
            $last_top = $key;
        } else {
            $sorted_menu_items[$last_top]->classes['dropdown'] = 'menu-expend';
        }
    }
    return $sorted_menu_items;
}

// Add style to header.
function ssv_add_styles() {
    wp_register_style('styles', get_template_directory_uri() . '/assets/css/styles.css', array(), '1.0', 'all');
    wp_enqueue_style('styles');
}

// Add script to footer.
function ssv_add_scripts() {
    global $wp_query;
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
      // Script.
      wp_register_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0'); // Custom scripts
      wp_enqueue_script('script');
    }
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function ssv_css_attributes_filter( $var ) {
    return is_array($var) ? array() : '';
}

// Remove invalid rel attribute values in the categorylist
function remove_category_rel_from_category_list( $thelist ) {
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

// Add page slug to body class, love this - Credit: Starkers Wordpress Theme
function add_slug_to_body_class($classes) {
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}

// Pagination for paged posts, Page 1, Page 2, Page 3, with Next and Previous Links, No plugin
function ssv_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages
    ));
}

// Custom Excerpts
function ssv_index($length) // Create 20 Word Callback for Index page Excerpts, call using ssv_excerpt('ssv_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using ssv_excerpt('ssv_custom_post');
function ssv_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function ssv_excerpt($length_callback = '', $more_callback = '')
{
    global $post;
    if (function_exists($length_callback)) {
        add_filter('excerpt_length', $length_callback);
    }
    if (function_exists($more_callback)) {
        add_filter('excerpt_more', $more_callback);
    }
    $output = get_the_excerpt();
    $output = apply_filters('wptexturize', $output);
    $output = apply_filters('convert_chars', $output);
    $output = '<p>' . $output . '</p>';
    echo $output;
}

// Remove 'text/css' from our enqueued stylesheet
function ssv_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function ssv_remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

/*------------*\
    Actions
\*------------*/
add_action('wp_enqueue_scripts', 'ssv_add_styles'); // Add Theme Stylesheet
add_action('init', 'ssv_pagination'); // Add our sentius Pagination
add_action('wp_footer', 'ssv_add_scripts'); // Add Custom Scripts to wp_head

// Remove Actions
remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
remove_action('wp_head', 'rsd_link'); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action('wp_head', 'wlwmanifest_link'); // Display the link to the Windows Live Writer manifest file.
remove_action('wp_head', 'index_rel_link'); // Index link
remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0); // Display relational links for the posts adjacent to the current post.
remove_action('wp_head', 'wp_generator'); // Display the XHTML generator that is generated on the wp_head hook, WP version
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'rel_canonical');
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);

/*----------*\
    Filters
\*----------*/
add_filter('body_class', 'add_slug_to_body_class'); // Add slug to body class (Starkers build)
add_filter('widget_text', 'do_shortcode'); // Allow shortcodes in Dynamic Sidebar
add_filter('widget_text', 'shortcode_unautop'); // Remove <p> tags in Dynamic Sidebars (better!)
add_filter('nav_menu_item_id', 'ssv_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
add_filter('page_css_class', 'ssv_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
add_filter( 'wp_nav_menu_objects', 'ssv_menu_set_dropdown', 10, 2 );
add_filter( 'walker_nav_menu_start_el', 'ssv_add_arrow',10,4);
// add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('style_loader_tag', 'ssv_style_remove'); // Remove 'text/css' from enqueued stylesheet
// add_filter('post_thumbnail_html', 'ssv_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
// add_filter('image_send_to_editor', 'ssv_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

?>
