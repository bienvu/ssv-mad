<?php
  if(get_row_layout() == 'box_html'):

    $body = get_sub_field('body');
    $video = get_sub_field('video');
    $class = (is_page('thank-you')) ? 'thankyou-page' : "";

    if ($body):
?>
      <div class="box-html <?php echo $class; ?>">
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