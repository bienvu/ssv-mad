<?php
/*
 *  Author: Sentius Group
 *  URL: sentiustdigital.com | @madtheme
 *  Custom functions, support, custom post types and more.
 */

require get_template_directory() . '/inc/init.php';

/*------------------------------------*\
  Functions
\*------------------------------------*/

// cover template part to string
function mad_string_termplate_part()
{
  ob_start();
  get_template_part('templates/searchform');
  $return = ob_get_contents();
  ob_end_clean();

  return $return;
}

// Add style to header.
function mad_add_styles() {
    wp_register_style('styles', get_template_directory_uri() . '/assets/css/styles.css', array(), '1.0', 'all');
    wp_enqueue_style('styles');
}

/**
 * Function alter main query of category page.
 */
function alter_main_query_category_page($query) {
    //gets the global query var object
    global $wp_query;
    if ($query->is_main_query() && is_category()) {
        $query->set('post_type', 'product');
        $query->set('posts_per_page', 18);
        $query->set('meta_key', 'weight');
        $query->set('orderby', array('meta_value_num' => 'ASC', 'ID' => 'ASC'));
        $style = isset($_GET['style']) ? $_GET['style'] : array();
        $term = get_queried_object();

        if(empty($term)) {
          return "";
        }
        
        $tax_query[] = array(
          'taxonomy' => 'category',
          'field' => 'slug',
          'terms' => $term->slug,
        );

        if (!empty($style)) {
          $style_tax_query = array(
              'taxonomy' => 'product_filter',
              'field' => 'slug',
              'terms' => $style,
          );
          $tax_query[] = $style_tax_query;
        }

        if (!empty($tax_query)) {
          $query->set('tax_query', $tax_query);
        }
    }
}

/**
 * Override OG image.
 */
function mad_add_opengraph_images(WPSEO_OpenGraph_Image $wpseo_og_image) {
    if ($wpseo_og_image->has_images()) {
       return;
    }
    if (is_singular('product') || is_singular('work')) {
       $queried_object = get_queried_object();
       $images = get_field('gallery', $queried_object->ID);
       if (!empty($images)) {
           $wpseo_og_image->add_image( array( 'url' => $images[0]['url']));
       }
    }
}

// get year current
function mad_get_year()
{
  return date('Y');
}

add_shortcode( 'year', 'mad_get_year' );

// Add script to footer.
function mad_add_scripts() {
    global $wp_query;
    if ($GLOBALS['pagenow'] != 'wp-login.php' && !is_admin()) {
      // Image loader
      wp_register_script('image-loader', get_template_directory_uri() . '/assets/js/lib/imagesloaded.pkgd.min.js', array(), '4.1.4'); 
      wp_enqueue_script('image-loader');
      // slick
      wp_register_script('slick', get_template_directory_uri() . '/assets/js/lib/slick.min.js', array(), '1.0.0'); 
      wp_enqueue_script('slick');
      // masonry
      wp_register_script('masonry222', get_template_directory_uri() . '/assets/js/lib/masonry.pkgd.min.js', array(), '4.2.1');
      wp_enqueue_script('masonry222');
      // light gallery
      wp_register_script('lightgallery', get_template_directory_uri() . '/assets/js/lib/lightgallery/jquery.lightgallery.min.js', array(), '1.0.0'); 
      wp_enqueue_script('lightgallery');
      // lightgallery share
      wp_register_script('lightgallery-share', get_template_directory_uri() . '/assets/js/lib/lightgallery/lg-share.min.js', array(), '1.0.0'); 
      wp_enqueue_script('lightgallery-share');
      // light gallery zoom
      wp_register_script('lightgallery-zoom', get_template_directory_uri() . '/assets/js/lib/lightgallery/lg-zoom.min.js', array(), '1.0.0'); 
      wp_enqueue_script('lightgallery-zoom');

      // Script.
      wp_register_script('script', get_template_directory_uri() . '/assets/js/script.js', array(), '1.0.0'); // Custom scripts
      wp_enqueue_script('script');
    }
}

// Remove Injected classes, ID's and Page ID's from Navigation <li> items
function mad_css_attributes_filter( $var ) {
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
function mad_pagination() {
    global $wp_query;
    $big = 999999999;
    echo paginate_links(array(
        'base' => str_replace($big, '%#%', get_pagenum_link($big)),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<span class="icon-arrow-left"></span>',
        'next_text' => '<span class="icon-arrow-right"></span>',
        'type' => 'list'
    ));
}

// Custom Excerpts
function mad_index($length) // Create 20 Word Callback for Index page Excerpts, call using mad_excerpt('mad_index');
{
    return 20;
}

// Create 40 Word Callback for Custom Post Excerpts, call using mad_excerpt('mad_custom_post');
function mad_custom_post($length)
{
    return 40;
}

// Create the Custom Excerpts callback
function mad_excerpt($length_callback = '', $more_callback = '')
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
function mad_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function mad_remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Add this to the functions.php file of your WordPress theme
// It filters the mime types using the upload_mimes filter hook
// Add as many keys/values to the $mimes Array as needed

function my_custom_upload_mimes($mimes = array()) {

  // Add a key and value for the CSV file type
  $mimes['csv'] = "text/csv";

  return $mimes;
}

// add breadcrumb
function mad_breadcrumb()
{
  $delimiter = '/';
  $name = 'Home'; //text for the 'Home' link;
  
  // dont change info below
  global $post;
  $home = get_bloginfo('url');

  echo '<div class="breadcum"><a class="home" href="' . $home . '">' . $name . '</a> '.$delimiter. ' ';

  // show on category page
  if ( is_category() ) {
    global $wp_query;
    // get term on category page
    $cat_obj = $wp_query->get_queried_object();
    $thisCat = $cat_obj->term_id;
    // get category
    $thisCat = get_category($thisCat);
    // get parent category
    $parentCat = get_category($thisCat->parent);
    // if parent category exist
    if ($thisCat->parent != 0) {
      $parent_string = get_category_parents($parentCat, TRUE, ' '.$delimiter. ' ');
      $parent_array = explode($delimiter, $parent_string);
      array_pop($parent_array);
      $parent_string = implode($delimiter, $parent_array);

      echo $parent_string;
    }
  } elseif(is_single()) { // shown on single page
    // get array category post
    $thisCat = get_the_category();
    // get category post
    if(!is_wp_error( $$thisCat )) {
      $thisCat = $thisCat[0];
    }

    // check if parent category exits
    if(!empty($thisCat)) {
      $category_string = get_category_parents($thisCat, TRUE, ' '.$delimiter. ' ');
      $category_array = explode($delimiter, $category_string);
      array_pop($category_array);
      $category_string = implode($delimiter, $category_array);

      echo $category_string;
    }
  }

  echo '</div>';
}

add_filter('query_vars', function( $vars ){
    //!!SUPER IMPORTANT!! - always *APPEND* $vars array (NOT re-assign)
    $vars[] = 'page';
    $vars[] = 'paged';
    $vars[] = 'style';

    //!!SUPER IMPORTANT!! - always return $vars
    return $vars;
});
/*------------------------------------*\
    Actions + Filters + ShortCodes
\*------------------------------------*/

/*------------*\
    Actions
\*------------*/
add_action('wp_enqueue_scripts', 'mad_add_styles'); // Add Theme Stylesheet
add_action('wpseo_add_opengraph_additional_images', 'mad_add_opengraph_images');
add_action('init', 'mad_pagination'); // Add our sentius Pagination
add_action('wp_footer', 'mad_add_scripts'); // Add Custom Scripts to wp_head
add_action('upload_mimes', 'my_custom_upload_mimes'); // add csv file upload
add_action('pre_get_posts','alter_main_query_category_page');
// add_filter('request', 'mad_remove_page_from_query_string');

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
add_filter('nav_menu_item_id', 'mad_css_attributes_filter', 100, 1); // Remove Navigation <li> injected ID (Commented out by default)
add_filter('page_css_class', 'mad_css_attributes_filter', 100, 1); // Remove Navigation <li> Page ID's (Commented out by default)
// add_filter('the_category', 'remove_category_rel_from_category_list'); // Remove invalid rel attribute
add_filter('the_excerpt', 'shortcode_unautop'); // Remove auto <p> tags in Excerpt (Manual Excerpts only)
add_filter('the_excerpt', 'do_shortcode'); // Allows Shortcodes to be executed in Excerpt (Manual Excerpts only)
add_filter('style_loader_tag', 'mad_style_remove'); // Remove 'text/css' from enqueued stylesheet
// add_filter('post_thumbnail_html', 'mad_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to thumbnails
// add_filter('image_send_to_editor', 'mad_remove_thumbnail_dimensions', 10); // Remove width and height dynamic attributes to post images
// Remove Filters
remove_filter('the_excerpt', 'wpautop'); // Remove <p> tags from Excerpt altogether

?>
