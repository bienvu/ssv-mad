<?php
/**
 * Get permalink settings for things like products and taxonomies.
 *
 * As of 3.3.0, the permalink settings are stored to the option instead of
 * being blank and inheritting from the locale. This speeds up page loading
 * times by negating the need to switch locales on each page load.
 *
 * This is more inline with WP core behavior which does not localize slugs.
 *
 * @since  3.0.0
 * @return array
 */

  function wc_clean( $var ) {
      if ( is_array( $var ) ) {
          return array_map( 'wc_clean', $var );
      } else {
          return is_scalar( $var ) ? sanitize_text_field( $var ) : $var;
      }
  }

  function mad_import_get_product_id_by_sku( $sku ) {
    $data_store = Mad_Import_Data_Store::load( 'product' );
    return $data_store->get_product_id_by_sku( $sku );
  }
