<?php
  if(get_row_layout() == 'box_video'):
    $url = get_sub_field('url');
    $body = get_sub_field('body'); ?>
    <div class="box-video__wrap">
      <?php if($body): ?>
        <div class="box-html">
          <div class="container">
            <?php echo $body; ?>
          </div>
        </div>
      <?php endif; ?>
      <div class="box-video">
        <?php if($url): ?>
          <div class="container">
            <div class="box-video__video js-video">
              <video autoplay="autoplay" loop="loop" muted="muted">
                <source src="<?php echo $url; ?>" type="video/mp4">
              </video>

              <div class="box-video__icon">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/play.svg">
              </div>
            </div>
          </div>
        <?php endif; ?>
      </div>
    </div>
<?php endif;?>
