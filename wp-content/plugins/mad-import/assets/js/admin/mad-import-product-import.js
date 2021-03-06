/*global ajaxurl, wc_product_import_params */

;(function ( $, window ) {

	/**
	 * productImportForm handles the import process.
	 */
	var productImportForm = function( $form ) {
		this.$form           = $form;
		this.xhr             = false;
		this.mapping         = mad_import_product_import_params.mapping;
		this.position        = 0;
		this.file            = mad_import_product_import_params.file;
		this.update_existing = mad_import_product_import_params.update_existing;
		this.delimiter       = mad_import_product_import_params.delimiter;
		this.security        = mad_import_product_import_params.import_nonce;
    this.post_type       = mad_import_product_import_params.post_type;
    // this.all_sku        = mad_import_product_import_params.all_sku;

		// Number of import successes/failures.
		this.imported = 0;
		this.failed   = 0;
		this.updated  = 0;
		this.skipped  = 0;

		// Initial state.
		this.$form.find('.woocommerce-importer-progress').val( 0 );

		this.run_import = this.run_import.bind( this );

		// Start importing.
		this.run_import();
	};

	/**
	 * Run the import in batches until finished.
	 */
	productImportForm.prototype.run_import = function() {
		var $this = this;

		$.ajax( {
			type: 'POST',
			url: ajaxurl,
			data: {
				action          : 'mad_import_do_ajax_product_import',
				position        : $this.position,
				mapping         : $this.mapping,
				file            : $this.file,
				update_existing : $this.update_existing,
				delimiter       : $this.delimiter,
				security        : $this.security,
        post_type       : $this.post_type,
        // all_sku				: $this.all_sku,
			},
			dataType: 'json',
			success: function( response ) {
        window.console.log( response );
				if ( response.success ) {
					$this.position  = response.data.position;
					$this.imported += response.data.imported;
					$this.failed   += response.data.failed;
					$this.updated  += response.data.updated;
					$this.skipped  += response.data.skipped;
					$this.$form.find('.woocommerce-importer-progress').val( response.data.percentage );

					if ( 'done' === response.data.position && response.data.status_related == 'done' ) {
						window.console.log ( response.data.status_related );
						window.location = response.data.url + '&products-imported=' + parseInt( $this.imported, 10 ) + '&products-failed=' + parseInt( $this.failed, 10 ) + '&products-updated=' + parseInt( $this.updated, 10 ) + '&products-skipped=' + parseInt( $this.skipped, 10 );
					} else {
            window.console.log( 1 );
						$this.run_import();
					}
				}
			}
		} ).fail( function( response ) {
			window.console.log( response );
		} );
	};

	/**
	 * Function to call productImportForm on jQuery selector.
	 */
	$.fn.mad_import_product_importer = function() {
		new productImportForm( this );
		return this;
	};

	$( '.woocommerce-importer' ).mad_import_product_importer();

})( jQuery, window );
