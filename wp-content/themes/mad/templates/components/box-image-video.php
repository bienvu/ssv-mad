<?php if(get_row_layout() == 'box_image_video'):
  $title            = get_sub_field('title');
  $description      = get_sub_field('description');
  $link             = get_sub_field('link');
?>
<div class="box-image-video">
  <div class="box-image-video__content">
    <div>
      <div class="container">
        <?php if($title ): ?>
          <h1 class="box-image-video__title"><?php echo $title; ?></h1>
        <?php endif; ?>
        
        <?php if($description): ?>
          <div class="box-image-video__description">
            <?php echo $description; ?>
          </div>
        <?php endif; ?>
        
        <?php if($link): ?>
          <div class="box-image-video__link">
            <a href="<?php echo $link['url']; ?>" class="btn" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="box-image-video__list">
    <?php if(have_rows('item')): $i = 0; $count = 0; ?>
      <?php while(have_rows('item')): the_row(); $i++; ?>
        <?php $image = get_sub_field('image');
              $image_mobile = get_sub_field('image_mobile');
              $class_mobile = $image_mobile ? 'hidden-on-desktopLarge' : '';
              $class_desktop = $image_mobile ? 'hidden-on-desktopLargeOnly' : ''; ?>
        <div class="box-image-video__item"><?php $count++; ?>
          <div class="box-image-video__image <?php echo $class_desktop; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"></div>
          <?php if($image_mobile): ?>
            <div class="box-image-video__image <?php echo $class_mobile; ?>"><img src="<?php echo $image_mobile['url']; ?>" alt="<?php echo $image_mobile['alt']; ?>"></div>
          <?php endif; ?>
          <?php if($count == 3): ?>
            <div class="box-image-video__logo">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ma_logo_white.svg" alt="">
            </div>
          <?php endif; ?>
        </div>

        <?php if($i === 2): ?>
          </div>
          <div class="box-image-video__list">
        <?php endif; ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>