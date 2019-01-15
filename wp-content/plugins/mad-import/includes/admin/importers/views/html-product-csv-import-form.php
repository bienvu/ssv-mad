<?php
/**
 * Admin View: Product import form
 *
 * @package WooCommerce/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<form class="wc-progress-form-content woocommerce-importer" enctype="multipart/form-data" method="post">
	<header>
		<h2><?php esc_html_e( 'Import products from a CSV file', 'ssvmad' ); ?></h2>
		<p><?php esc_html_e( 'This tool allows you to import (or merge) product data to your store from a CSV file.', 'ssvmad' ); ?></p>
	</header>
	<section>
		<table class="form-table woocommerce-importer-options">
			<tbody>
				<tr>
					<th scope="row">
						<label for="upload">
							<?php esc_html_e( 'Choose a CSV file from your computer:', 'ssvmad' ); ?>
						</label>
					</th>
					<td>
						<?php
						if ( ! empty( $upload_dir['error'] ) ) {
							?>
							<div class="inline error">
								<p><?php esc_html_e( 'Before you can upload your import file, you will need to fix the following error:', 'ssvmad' ); ?></p>
								<p><strong><?php echo esc_html( $upload_dir['error'] ); ?></strong></p>
							</div>
							<?php
						} else {
							?>
							<input type="file" id="upload" name="import" size="25" />
							<input type="hidden" name="action" value="save" />
							<input type="hidden" name="max_file_size" value="<?php echo esc_attr( $bytes ); ?>" />
							<br>
							<small>
								<?php
								printf(
									/* translators: %s: maximum upload size */
									esc_html__( 'Maximum size: %s', 'ssvmad' ),
									esc_html( $size )
								);
								?>
							</small>
							<?php
						}
					?>
					</td>
				</tr>
			</tbody>
		</table>
	</section>

  <input type="radio" name="type" value="product" checked="checked">Product
  <input type="radio" name="type" value="work">Work

	<div class="wc-actions">
		<button type="submit" class="button button-primary button-next" value="<?php esc_attr_e( 'Continue', 'ssvmad' ); ?>" name="save_step"><?php esc_html_e( 'Continue', 'ssvmad' ); ?></button>
		<?php wp_nonce_field( 'mad-import-csv-importer' ); ?>
	</div>
</form>
