<?php
  if(get_row_layout() == 'box_contact'):
    $content_left = get_sub_field('content_left');
    $content_center = get_sub_field('content_center');
    $image = get_sub_field('image');
    $form = get_sub_field('form');
?>
  <div class="box-contact">
    <div class="container">
      <div class="box-contact__wrap">
        <?php  if($content_left): ?>
          <div class="box-contact__left">
            <?php
              echo $content_left;
              echo do_shortcode( '[contact-form-7 id="'.$form->ID.'" title="'.$form->post_title.'"]' ); ?>
          </div>
        <?php
          endif;

        if($content_center) {
          echo $content_center;
        }

        if(!empty($image)): ?>
          <div class="box-contact__right">
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>
