<?php
  if(get_row_layout() == 'box_html'):

    $body = get_sub_field('body');
    $video = get_sub_field('video');

    if ($body):
?>
      <div class="box-html">
        <div class="container">
          <?php echo $body; ?>
        </div>
      </div>
      <?php if($video): ?>
        <video autoplay="autoplay" loop="loop" >
            <source src="<?php echo $video; ?>" type="video/mp4">
        </video>
      <?php endif; ?>
<?php
    endif;
  endif;
?>