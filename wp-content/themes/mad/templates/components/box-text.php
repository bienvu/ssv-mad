<?php
  if(get_row_layout() == 'box_text'):
    $title = get_sub_field('title');
    $body  = get_sub_field('body');
?>
  <div class="box-text">
    <div class="container">
      <?php if($title): ?>
        <h4 class="box-text__title"><?php echo $title; ?></h4>
      <?php endif; ?>
      
      <?php if($body): ?>
        <div class="box-text__content">
          <?php echo $body; ?>
        </div>
      <?php endif; ?>
      
      <?php if(have_rows('multilink')): ?>
        <div class="box-text__link">
          <?php while(have_rows('multilink')): the_row(); $link = get_sub_field('link'); ?>
            <a href="<?php echo $link['url']; ?>" class="btn btn--large" blank="<?php echo $link['blank'] ?>"><?php echo $link['title']; ?></a>
          <?php endwhile; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

<?php endif; ?>
