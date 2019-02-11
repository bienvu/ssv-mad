<?php

  add_filter( 'wpcf7_special_mail_tags', 'mad_wpcf7_special_mail_tags', 10, 3 );

  function mad_wpcf7_special_mail_tags($output, $name, $html)
  {
    $submission = WPCF7_Submission::get_instance();

    $post_id = (int) $submission->get_meta( 'container_post_id' );

    if ( ! $post_id || ! $post = get_post( $post_id ) ) {
      return '';
    }

    $output = '';

    if ( 'product_info' == $name ) {
      $product_code    = get_field('sku', $post) ? get_field('sku', $post) : '';
      $product_name    = $post->post_title ? $post->post_title : '';
      $gallery         = get_field('gallery', $post) ? get_field('gallery', $post) : '';
      $product_image   = wp_get_attachment_image($gallery[0]['ID']) ? wp_get_attachment_image($gallery[0]['ID']) : '';
      $product_url     = get_permalink($post) ? get_permalink($post) : '';
    }

    $output .= '<p><b>Product name: </b>'. $product_name.'</p>';
    $output .= '<p><b>Product code: </b>'. $product_code.'</p>';
    $output .= '<p><b>Product URL: </b><a href="'.$product_url.'">'. $product_url.'</a></p>';
    $output .= '<p><b>Product image: </b>'. $product_image.'</p>';

    return (string) $output;
  }
?>