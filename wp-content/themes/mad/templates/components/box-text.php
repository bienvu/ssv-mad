<?php
  if(get_row_layout() == 'box_text'):
    $title = get_sub_field('title');
    $body  = get_sub_field('body');
    $class = get_sub_field('class_modifier');
    $class = ($class) ? 'box-text--'.$class : "";
?>
  <div class="box-text <?php if($class) { echo $class; } ?>">
    <div class="container">
      <div class="box-text__body">
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
            <?php while(have_rows('multilink')): the_row(); $item = get_sub_field('item'); if($item): ?>
              <a href="<?php echo $item['link']['url']; ?>" class="btn btn--large <?php if($item['class']) { echo $item['class']; } ?>" blank="<?php echo $item['link']['blank'] ?>"><?php echo $item['link']['title']; ?></a>
            <?php
                endif;
              endwhile; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

<?php endif; ?>
