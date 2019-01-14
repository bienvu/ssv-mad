<?php
  if(get_row_layout() == 'box_video'):
    $url = get_sub_field('url'); ?>

    <div class="box-video">
      <video autoplay="autoplay" loop="loop" >
        <source src="<?php echo $url; ?>" type="video/mp4">
      </video>
    </div>
<?php endif;?>
