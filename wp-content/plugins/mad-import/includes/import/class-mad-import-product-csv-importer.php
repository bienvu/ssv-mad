<?php
/**
 * WooCommerce Product CSV importer
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
if ( ! class_exists( 'Mad_Import_Product_Importer', false ) ) {
	include_once dirname( __FILE__ ) . '/abstract-mad-import-product-importer.php';
}

/**
 * WC_Product_CSV_Importer Class.
 */
class Mad_Import_Product_CSV_Importer extends Mad_Import_Product_Importer {

	/**
	 * Tracks current row being parsed.
	 *
	 * @var integer
	 */
	protected $parsing_raw_data_index = 0;

	/**
	 * Initialize importer.
	 *
	 * @param string $file   File to read.
	 * @param array  $params Arguments for the parser.
	 */
	public function __construct( $file, $params = array() ) {
		$default_args = array(
			'start_pos'        => 0, // File pointer start.
			'end_pos'          => -1, // File pointer end.
			'lines'            => -1, // Max lines to read.
			'mapping'          => array(), // Column mapping. csv_heading => schema_heading.
			'parse'            => false, // Whether to sanitize and format data.
			'update_existing'  => false, // Whether to update existing items.
			'delimiter'        => ',', // CSV delimiter.
			'prevent_timeouts' => true, // Check memory and time usage and abort if reaching limit.
			'enclosure'        => '"', // The character used to wrap text in the CSV.
			'escape'           => "\0", // PHP uses '\' as the default escape character. This is not RFC-4180 compliant. This disables the escape character.
		);

		$this->params    = wp_parse_args( $params, $default_args );
		$this->file      = $file;
    $this->type      = $this->params['post_type'];
    $this->all_sku  = $this->params['all_sku'];
    $this->related   = $this->params['related'];

		if ( isset( $this->params['mapping']['from'], $this->params['mapping']['to'] ) ) {
			$this->params['mapping'] = array_combine( $this->params['mapping']['from'], $this->params['mapping']['to'] );
		}

		$this->read_file();
	}

	/**
	 * Read file.
	 */
	protected function read_file() {
		if ( ! Mad_Import_Product_CSV_Importer_Controller::is_file_valid_csv( $this->file ) ) {
			wp_die( __( 'Invalid file type. The importer supports CSV and TXT file formats.', 'ssvmad' ) );
		}

		$handle = fopen( $this->file, 'r' ); // @codingStandardsIgnoreLine.

		if ( false !== $handle ) {
			$this->raw_keys = version_compare( PHP_VERSION, '5.3', '>=' ) ? array_map( 'trim', fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'], $this->params['escape'] ) ) : array_map( 'trim', fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'] ) ); // @codingStandardsIgnoreLine

			// Remove BOM signature from the first item.
			if ( isset( $this->raw_keys[0] ) ) {
				$this->raw_keys[0] = $this->remove_utf8_bom( $this->raw_keys[0] );
			}

			if ( 0 !== $this->params['start_pos'] ) {
				fseek( $handle, (int) $this->params['start_pos'] );
			}

			while ( 1 ) {
				$row = version_compare( PHP_VERSION, '5.3', '>=' ) ? fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'], $this->params['escape'] ) : fgetcsv( $handle, 0, $this->params['delimiter'], $this->params['enclosure'] ); // @codingStandardsIgnoreLine

				if ( false !== $row ) {
					$this->raw_data[]                                 = $row;
					$this->file_positions[ count( $this->raw_data ) ] = ftell( $handle );

					if ( ( $this->params['end_pos'] > 0 && ftell( $handle ) >= $this->params['end_pos'] ) || 0 === --$this->params['lines'] ) {
						break;
					}
				} else {
					break;
				}
			}

			$this->file_position = ftell( $handle );
		}

		if ( ! empty( $this->params['mapping'] ) ) {
			$this->set_mapped_keys();
		}

    if ( $this->params['parse'] ) {
      $this->set_parsed_data();
    }
	}

	/**
	 * Remove UTF-8 BOM signature.
	 *
	 * @param  string $string String to handle.
	 * @return string
	 */
	protected function remove_utf8_bom( $string ) {
		if ( 'efbbbf' === substr( bin2hex( $string ), 0, 6 ) ) {
			$string = substr( $string, 3 );
		}

		return $string;
	}

  /**
   * Get formatting callback.
   *
   * @return array
   */
  protected function get_formating_callback() {

    /**
     * Columns not mentioned here will get parsed with 'wc_clean'.
     * column_name => callback.
     */
    $data_formatting = array(
      'gallery'            => array( $this, 'parse_images_field' ),
      'category'           => array( $this, 'parse_category_field' ),
      'related'           => array( $this, 'parse_images_field' ),
      'featured_image'    => array( $this, 'parse_skip_field' ),
    );

    $callbacks = array();

    // Figure out the parse function for each column.
    foreach ( $this->get_mapped_keys() as $index => $heading ) {
      $callback = 'wc_clean';

      if ( isset( $data_formatting[ $heading ] ) ) {
        $callback = $data_formatting[ $heading ];
      }

      $callbacks[] = $callback;
    }

    return $callbacks;
  }
  /**
   * Just skip current field.
   *
   * By default is applied wc_clean() to all not listed fields
   * in self::get_formating_callback(), use this method to skip any formating.
   *
   * @param  string $value Field value.
   * @return string
   */
  public function parse_skip_field( $value ) {
    return $value;
  }

  /**
   * Parse images list from a CSV. Images can be filenames or URLs.
   *
   * @param  string $value Field value.
   * @return array
   */
  public function parse_images_field( $value ) {
    if ( empty( $value ) ) {
      return array();
    }

    $images = array();
    $value = explode(',', $value);

    foreach ( $value as $image ) {
      if ( stristr( $image, '://' ) ) {
        $images[] = esc_url_raw( $image );
      } else {
        $images[] = sanitize_file_name( $image );
      }
    }

    return $images;
  }

  /**
   * Parse category list from a CSV. return array
   *
   * @param  string $value Field value.
   * @return array
   */
  public function parse_category_field( $value ) {
    if ( empty( $value ) ) {
      return array();
    }

    $categorys = array();
    $value = explode('>', $value);

    foreach ( $value as $category ) {
      $category = wc_clean( wp_unslash( strtolower(trim($category)) ) );
      $category_arr = explode(" ", $category);

      foreach ($category_arr as $key => $value_child) {
        $category_arr[$key] = trim($value_child);
      }
      $categorys[] = implode('_', $category_arr);
    }

    return $categorys;
  }

	/**
	 * Set file mapped keys.
	 */
	protected function set_mapped_keys() {
		$mapping = $this->params['mapping'];

		foreach ( $this->raw_keys as $key ) {
			$this->mapped_keys[] = isset( $mapping[ $key ] ) ? $mapping[ $key ] : $key;
		}
	}

  /**
   * Map and format raw data to known fields.
   */
  protected function set_parsed_data() {
    $parse_functions = $this->get_formating_callback();
    $mapped_keys     = $this->get_mapped_keys();
    $use_mb          = function_exists( 'mb_convert_encoding' );

    // Parse the data.
    foreach ( $this->raw_data as $row_index => $row ) {
      // Skip empty rows.
      if ( ! count( array_filter( $row ) ) ) {
        continue;
      }

      $this->parsing_raw_data_index = $row_index;

      $data = array();

      do_action( 'woocommerce_product_importer_before_set_parsed_data', $row, $mapped_keys );

      foreach ( $row as $id => $value ) {
        // Skip ignored columns.
        if ( empty( $mapped_keys[ $id ] ) ) {
          continue;
        }

        // Convert UTF8.
        if ( $use_mb ) {
          $encoding = mb_detect_encoding( $value, mb_detect_order(), true );
          if ( $encoding ) {
            $value = mb_convert_encoding( $value, 'UTF-8', $encoding );
          } else {
            $value = mb_convert_encoding( $value, 'UTF-8', 'UTF-8' );
          }
        } else {
          $value = wp_check_invalid_utf8( $value, true );
        }

        $data[ $mapped_keys[ $id ] ] = call_user_func( $parse_functions[ $id ], $value );
      }

      $this->parsed_data[] = $data;
    }
  }

  public function import() {
    
    $this->start_time = time();
    $post_type = $this->type;
    $index            = 0;

    foreach ( $this->parsed_data as $parsed_data_key => $parsed_data ) {
      do_action( 'mad_import_product_import_before_import', $parsed_data );

      $result = $this->process_item( $parsed_data, $post_type );

      if ( is_wp_error( $result ) ) {
        $data['failed'][] = $result;
      } elseif ( $result['updated'] ) {
        $data['updated'][] = $result['id'];
      } else {
        $data['imported'][] = $result['id'];
      }

      $index++;

      if ( $this->params['prevent_timeouts'] && ( $this->time_exceeded() || $this->memory_exceeded() ) ) {
        $this->file_position = $this->file_positions[ $index ];
        break;
      }
    }

    return $data;
  }

  public function import_related()
  {
    global $wpdb;
    $this->start_time = time();
    $index = 0;

    $related = array_filter( (array) get_user_option( 'product_import_related' ) );
    $related_row =  get_user_option( 'product_import_related_row' );
    foreach ($related as $id => $sku_by_id) {
      $index++;
      if(!empty($related_row)) {
        if($index <= (int) $related_row) {
          continue;
        }
      }

      foreach ($sku_by_id as $value) {
        $list_id_by_sku[] = $wpdb->get_var($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_value = %s AND meta_key = 'sku' ", $value));
      }
      update_field('mad_import_product_related_123',$list_id_by_sku, $id);
      unset($list_id_by_sku);

      if ( $this->params['prevent_timeouts'] && ( $this->time_exceeded() || $this->memory_exceeded() ) ) {
        update_user_option( get_current_user_id(), 'product_import_related_row', $index );
        return "process2";
      }
    }
    return "done";
  }
}
