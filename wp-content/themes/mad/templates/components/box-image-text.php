<?php
  if(get_row_layout() == 'box_image_text'):
    $modifier = get_sub_field('modifier');
?>
    <div class="box-image-text <?php echo $modifier; ?>">
      <div class="container">
        <?php
          if(have_rows('item')):
            while(have_rows('item')): the_row();
              $title    = get_sub_field('title');
              $body     = get_sub_field('body');
              $images    = get_sub_field('image');
              $modifier = get_sub_field('modifier');
        ?>
          <div class="box-image-text__item">
            <?php if($title): ?>
              <h4 class="box-image-text__title"><?php echo $title; ?></h4>
            <?php endif; ?>
            
            <?php if($body): ?>
              <div class="box-image-text__content">
                <?php echo $body; ?>
              </div>
            <?php endif; ?>
            
            <?php if(!empty($images)): ?>
              <div class="box-image-text__list">
                <div class="box-image-text__image">
                  <?php foreach($images as $image): ?>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                  <?php endforeach; ?>
                </div> 
              </div>
            <?php endif; ?>
          </div>
        <?php
            endwhile;
          endif;
        ?>
      </div>
    </div>

<?php endif; ?>