<?php
/**
 * Abstract Product importer
 *
 * @package  WooCommerce/Import
 * @version  3.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Include dependencies.
 */
if ( ! class_exists( 'Mad_Import_Importer_Interface', false ) ) {
	include_once MAD_IMPORT_ABSPATH . 'includes/interfaces/class-mad-import-importer-interface.php';
}

/**
 * WC_Product_Importer Class.
 */
abstract class Mad_Import_Product_Importer implements Mad_Import_Importer_Interface {

	/**
	 * CSV file.
	 *
	 * @var string
	 */
	protected $file = '';

	/**
	 * The file position after the last read.
	 *
	 * @var int
	 */
	protected $file_position = 0;

	/**
	 * Importer parameters.
	 *
	 * @var array
	 */
	protected $params = array();

	/**
	 * Raw keys - CSV raw headers.
	 *
	 * @var array
	 */
	protected $raw_keys = array();

	/**
	 * Mapped keys - CSV headers.
	 *
	 * @var array
	 */
	protected $mapped_keys = array();

	/**
	 * Raw data.
	 *
	 * @var array
	 */
	protected $raw_data = array();

	/**
	 * Raw data.
	 *
	 * @var array
	 */
	protected $file_positions = array();

	/**
	 * Parsed data.
	 *
	 * @var array
	 */
	protected $parsed_data = array();

	/**
	 * Start time of current import.
	 *
	 * (default value: 0)
	 *
	 * @var int
	 * @access protected
	 */
	protected $start_time = 0;

	/**
	 * Get file raw headers.
	 *
	 * @return array
	 */
	public function get_raw_keys() {
		return $this->raw_keys;
	}

	/**
	 * Get file mapped headers.
	 *
	 * @return array
	 */
	public function get_mapped_keys() {
		return ! empty( $this->mapped_keys ) ? $this->mapped_keys : $this->raw_keys;
	}

	/**
	 * Get raw data.
	 *
	 * @return array
	 */
	public function get_raw_data() {
		return $this->raw_data;
	}

	/**
	 * Get parsed data.
	 *
	 * @return array
	 */
	public function get_parsed_data() {
		return apply_filters( 'woocommerce_product_importer_parsed_data', $this->parsed_data, $this->get_raw_data() );
	}

	/**
	 * Get importer parameters.
	 *
	 * @return array
	 */
	public function get_params() {
		return $this->params;
	}

	/**
	 * Get file pointer position from the last read.
	 *
	 * @return int
	 */
	public function get_file_position() {
		return $this->file_position;
	}

	/**
	 * Get file pointer position as a percentage of file size.
	 *
	 * @return int
	 */
	public function get_percent_complete() {
		$size = filesize( $this->file );
		if ( ! $size ) {
			return 0;
		}

		return absint( min( round( ( $this->file_position / $size ) * 100 ), 100 ) );
	}

	/**
	 * Process a single item and save.
	 *
	 * @throws Exception If item cannot be processed.
	 * @param  array $data Raw CSV data.
	 * @return array|WC_Error
	 */
	protected function process_item( $data, $post_type ) {
		global $wpdb;
    if($post_type == 'work') {
      $id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s AND meta_key = 'weight' ", $data['weight']));
    }
    elseif ($post_type == 'product') {
      $id = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s AND meta_key = 'sku' ", $data['sku']));
    }

    if ($data['category']) {
      foreach ($data['category'] as $key => $value) {
        $category_name = "";
        $category_slug = "";
        $category_name = explode('_', $value);
        $category_name = ucwords(implode($category_name, " "));
        $category_slug = explode('&', $value);
        $category_slug = implode($category_slug, "");
        if($post_type == 'product') {
          $term_id = term_exists($category_slug, 'category');

          if(empty($term_id)) {
            $term_id_parent = !empty(term_exists($data['category'][$key-1])) ? term_exists($data['category'][$key-1]) : 0;
            $term_id = wp_insert_term(
              $category_name,
              'category',
              array(
                'parent' => $term_id_parent['term_id'],
                'slug'   => $category_slug,
              )
            );
          } else {
            $term_id_parent = !empty(term_exists($data['category'][$key-1], 'category')) ? term_exists($data['category'][$key-1], 'category') : 0;
            $term_id = wp_update_term(
              $term_id['term_id'],
              'category',
              array(
                'parent' => $term_id_parent['term_id'],
                'slug'   => $category_slug,
              )
            );
          }
        } elseif ($post_type == 'work') {
          $term_id = term_exists($category_slug, 'product_filter');

          if(empty($term_id)) {
            $term_id_parent = !empty(term_exists($data['category'][$key-1], 'product_filter')) ? term_exists($data['category'][$key-1], 'product_filter') : 0;
            $term_id = wp_insert_term(
              $category_name,
              'product_filter',
              array(
                'parent' => $term_id_parent['term_id'],
                'slug'   => $category_slug,
              )
            );
          } else {
            $term_id_parent = !empty(term_exists($data['category'][$key-1], 'product_filter')) ? term_exists($data['category'][$key-1], 'product_filter') : 0;
            $term_id = wp_update_term(
              $term_id['term_id'],
              'product_filter',
              array(
                'parent' => $term_id_parent['term_id'],
                'slug'   => $category_slug,
              )
            );
          }
        }
      }
    }

    unset($term_parent);
    unset($category_name);
    unset($category_slug);

    if(empty($id)) {
      $id = wp_insert_post(array(
        'post_title' => $data['title'],
        'post_content' => $data['description'],
        'post_type' => $post_type,
        'post_status'  => 'publish'
      ));
    } else {
      $id = wp_update_post(array(
        'ID' => $id,
        'post_title' => $data['title'],
        'post_content' => $data['description'],
        'post_type' => $post_type,
      ));

      $updated = 'updated';
    }

    // instert term last to post
    if($post_type == 'product') {
      wp_set_post_terms( $id, $term_id['term_id'], 'category' );
    } elseif($post_type == 'work') {
      wp_set_post_terms( $id, $term_id['term_id'], 'product_filter' );
    }
    

    // update weight
    if(!empty($data['weight'])) {
      if($post_type == 'product') {
        update_field( 'mad_import_product_weight_123', $data['weight'], $id );
      } elseif ($post_type == 'work') {
        update_field( 'mad_import_work_weight_123', $data['weight'], $id );
      }
    } else {
      if($post_type == 'work') {
        return new WP_Error( 'mad_import_weight',  __( 'Weight not found in post type work.', 'ssvmad' ) . ' ' . sprintf( __( 'Error: %s.', 'ssvmad' ), $response->get_error_message() ), array( 'status' => 400 ) );
      }
    }

    // update SKU
    if(!empty($data['sku'])) {
      if($post_type == 'product') {
        update_field( 'mad_import_product_sku_123', $data['sku'], $id );
      }
    } else {
      if($post_type == 'product') {
        return new WP_Error( 'mad_import_sku',  __( 'SKU not found in post type product.', 'ssvmad' ) . ' ' . sprintf( __( 'Error: %s.', 'ssvmad' ), $response->get_error_message() ), array( 'status' => 400 ) );
      }
    }
    // update Featured image
    if(!empty($data['featured_image'])) {

    	$upload = $this->set_image_data($data['featured_image']);
      // checl featured image exit or error
      if(!($upload[0] instanceof WP_Error)) {
        $images = $this->set_field_image(array($upload), $id);

        if($post_type == 'product') {
          update_field( 'mad_import_product_featured_image_123', $images[0], $id );
        } elseif ($post_type == 'work') {
          update_field( 'mad_import_work_featured_image_123', $images[0], $id );
        }
      }
    }
    // update gallery
    if(!empty($data['gallery'])) {
    	foreach ($data['gallery'] as $image) {
    		if($image) {
		    	$gallery[] = $this->set_image_data($image);
		    }
    	}
      // check gallery exits or error
      $i = 1;
      foreach ($gallery as $value) {
        if ($value instanceof WP_Error) {
          $i = 0;
        }
      }
      // check $i = 1 => gallery processing success
      if($i) {
        $images = $this->set_field_image($gallery, $id);

        if($post_type == 'product') {
          update_field( 'mad_import_product_gallery_123', $images, $id );
        } elseif ($post_type == 'work') {
          update_field( 'mad_import_work_gallery_123', $images, $id );
        }
      }

      unset($i);
    }
    // update you may also like
    if(!empty($data['related'])) {
      if($post_type == 'product') {
        foreach ($data['related'] as $image) {
          if($image) {
            $related[$id] = $data['related'];
          }
        }
      }
    }
    // update filter post type product
    if(!empty($data['filter'])) {
      if($post_type == 'product') {
        $term_id = term_exists($data['filter'], 'product_filter');

        if(empty($term_id)) {
          $term_id = wp_insert_term($data['filter'], 'product_filter');
        }

        // insert term for post
        wp_set_post_terms( $id, $term_id, 'product_filter' );
      }
    }
    // save sku by id
    $list_sku[$data['sku']] = $id;

		return array(
			'id'      => $id,
      'updated' => $updated,
      'related' => $related,
      'list_sku'     => $list_sku
		);
	}

	/**
	 * Convert raw image URLs to IDs and set.
	 *
	 * @param WC_Product $product Product instance.
	 * @param array      $data    Item data.
	 */
	protected function set_image_data( $image_name = '' ) {
    global $wpdb;
		$upload_arr = wp_upload_dir();
		$image_url = $upload_arr['url'].'/import/'.$image_name;

		// return if file exits
		if(file_exists($upload_arr['path'].'/'.$image_name)) {
      $image_uri = '%/'.$image_name;
      $image_id = $wpdb->get_var($wpdb->prepare("SELECT ID from $wpdb->posts WHERE guid LIKE %s", $image_uri));

      if($image_id) {
        wp_delete_attachment($image_id);
      }
		}

    if (empty(file_exists($upload_arr['path'].'/import/'.$image_name))) {
      return new WP_Error( 'mad_import_image_not_found', sprintf( __( 'Image Not Found: %s.', 'ssvmad' ), $image_url ), array( 'status' => 400 ) );
    }

		$response = wp_safe_remote_get(
	    $image_url, array(
	      'timeout' => 10,
	    )
	  );

		if ( is_wp_error( $response ) ) {
        return new WP_Error( 'mad_import_rest_invalid_remote_image_url', sprintf( __( 'Error getting remote image %s.', 'ssvmad' ), $image_url ) . ' ' . sprintf( __( 'Error: %s.', 'ssvmad' ), $response->get_error_message() ), array( 'status' => 400 ) );
    } elseif ( 200 !== wp_remote_retrieve_response_code( $response ) ) {
        return new WP_Error( 'mad_import_rest_invalid_remote_image_url', sprintf( __( 'Error getting remote image %s.', 'ssvmad' ), $image_url ), array( 'status' => 400 ) );
    }

		$upload = wp_upload_bits( $image_name, '', wp_remote_retrieve_body( $response ) );

		// Get filesize.
    $filesize = filesize( $upload['file'] );

    if ( 0 == $filesize ) {
        @unlink( $upload['file'] );
        unset( $upload );

        return new WP_Error( 'mad_import_rest_image_upload_file_error', __( 'Zero size file downloaded.', 'ssvmad' ), array( 'status' => 400 ) );
    }

    return $upload;
	}

	protected function set_field_image($gallery, $id) {
		global $wpdb;
    $images = array();

		foreach ($gallery as $key => $value) {
      $file_name = current(explode('.',basename( $value['file'] )));
      $extension = end(explode('.',basename( $value['file'])));
      if($this->type == 'work') {
        $file_arr = explode('-', $file_name);
      } elseif ($this->type == 'product') {
        $file_arr = explode('_', $file_name);
      }
      
      $position = end($file_arr);
      if($this->type == 'work') {
        if (preg_match('~[0-9]+~', $position)) {
          if (prev($file_arr) == 'Featured') {
            array_pop($file_arr);
          }
        }
      }
      
			unset($position);

      if($this->type == 'work') {
        $file_name  = implode($file_arr, '-');
      } elseif ($this->type == 'product') {
        $file_name  = implode($file_arr, '_');
      }
			
			$file_query = dirname($value['url']).'/'.$file_name.'.'.$extension;

      $image_id = $wpdb->get_var($wpdb->prepare("SELECT ID from $wpdb->posts WHERE guid = %s", $file_query));

      if(empty($image_id)) {
        $wp_upload_dir = wp_upload_dir();

        // Prepare an array of post data for the attachment.
        $attach_id = wp_insert_attachment( array(
          'guid'           => $wp_upload_dir['url'] . '/' . basename( $value['file'] ), 
          'post_mime_type' => $value['type'],
          'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $value['file'] ) ),
          'post_content'   => '',
          'post_status'    => 'inherit',
        ), $value['file'], $id );
        // Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
        require_once( ABSPATH . 'wp-admin/includes/image.php' );
        // Generate the metadata for the attachment, and update the database record.
        $attach_data = wp_generate_attachment_metadata( $attach_id, $value['url'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );

        // sava gallery ids
        $images[] = $attach_id;
        unset($attach_id);
      } else {
        $images[] = $image_id;
      }
    }
    unset($image_id);

    return $images;
	}

	/**
	 * Memory exceeded
	 *
	 * Ensures the batch process never exceeds 90%
	 * of the maximum WordPress memory.
	 *
	 * @return bool
	 */
	protected function memory_exceeded() {
		$memory_limit   = $this->get_memory_limit() * 0.9; // 90% of max memory
		$current_memory = memory_get_usage( true );
		$return         = false;
		if ( $current_memory >= $memory_limit ) {
			$return = true;
		}
		return apply_filters( 'mad_import_product_importer_memory_exceeded', $return );
	}

	/**
	 * Get memory limit
	 *
	 * @return int
	 */
	protected function get_memory_limit() {
		if ( function_exists( 'ini_get' ) ) {
			$memory_limit = ini_get( 'memory_limit' );
		} else {
			// Sensible default.
			$memory_limit = '128M';
		}

		if ( ! $memory_limit || -1 === intval( $memory_limit ) ) {
			// Unlimited, set to 32GB.
			$memory_limit = '32000M';
		}
		return intval( $memory_limit ) * 1024 * 1024;
	}

	/**
	 * Time exceeded.
	 *
	 * Ensures the batch never exceeds a sensible time limit.
	 * A timeout limit of 30s is common on shared hosting.
	 *
	 * @return bool
	 */
	protected function time_exceeded() {
		$finish = $this->start_time + apply_filters( 'mad_import_product_importer_default_time_limit', 20 ); // 20 seconds
		$return = false;
		if ( time() >= $finish ) {
			$return = true;
		}
		return apply_filters( 'mad_import_product_importer_time_exceeded', $return );
	}

	/**
	 * Explode CSV cell values using commas by default, and handling escaped
	 * separators.
	 *
	 * @since  3.2.0
	 * @param  string $value Value to explode.
	 * @return array
	 */
	protected function explode_values( $value ) {
		$value  = str_replace( '\\,', '::separator::', $value );
		$values = explode( ',', $value );
		$values = array_map( array( $this, 'explode_values_formatter' ), $values );

		return $values;
	}

	/**
	 * Remove formatting and trim each value.
	 *
	 * @since  3.2.0
	 * @param  string $value Value to format.
	 * @return string
	 */
	protected function explode_values_formatter( $value ) {
		return trim( str_replace( '::separator::', ',', $value ) );
	}
}
