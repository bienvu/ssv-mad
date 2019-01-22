<?php
  if(get_row_layout() == 'box_video'):
    $url = get_sub_field('url');
    $body = get_sub_field('body'); ?>

    <div class="box-video">
      <?php if($url): ?>
        <div class="container">
          <div class="box-video__video">
            <video autoplay="autoplay" loop="loop" muted="muted">
              <source src="<?php echo $url; ?>" type="video/mp4">
            </video>
          </div>
        </div>
      <?php endif; ?>

      <?php if($body): ?>
      <div class="box-video__body">
        <div class="container">
          <?php echo $body; ?>
        </div>
      </div>
      <?php endif; ?>
    </div>
<?php endif;?>
