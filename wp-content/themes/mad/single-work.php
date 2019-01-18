<?php get_header(); ?>
<main role="main" class="main">
  <?php
    $featured_image = get_field('featured_image');
    $gallery = get_field('gallery');
    $work_extra = get_field('work_extra', 'option');

    if(have_posts()):
      while(have_posts()): the_post();
  ?>
  <h1 class="page-title hidden-on-desktop"><?php the_title(); ?></h1>

  <div class="box-gallery box-gallery--image-right">
    <div class="container">
      <div class="box-gallery__wrap">
        <div class="box-gallery__left js-height">
          <div class="paginginfo text--bold"></div>
          <?php if(!empty($gallery)): ?>
          <div class="box-gallery__slider js-slide-product js-pagination js-lightbox-product">
            <?php
              foreach ($gallery as $key => $value):
                $class_modifier = ($value['height'] > $value['width']) ? 'height-large' : "";
            ?>
              <div class="box-gallery__item <?php if(!empty($class_modifier)) { echo $class_modifier; } ?>" data-src="<?php echo $value['url']; ?>">
                <div class="box-gallery__image">
                  <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
                </div>
              </div>
            <?php endforeach; ?>
          </div>

          <i class="icon-enlarge js-lightbox-product-icon">icon enlarge</i>
        <?php endif; ?>
        </div>

        <div class="box-gallery__right">
          <a href="<?php echo get_post_type_archive_link('work') ?>" class="back-to text--small">< Back to Work</a>
          <h2 class="box-gallery__title"><?php the_title(); ?></h2>

          <div class="box-gallery__content">
            <?php the_content(); ?>

            <?php echo $work_extra; ?>
          </div>
          
          <?php if(have_rows('work_link_extra', 'option')): ?>
            <div class="box-gallery__link">
              <?php
                while(have_rows('work_link_extra', 'option')): the_row();
                  $item = get_sub_field('item');
              ?>
                <a href="<?php echo $item['url']; ?>" class="btn btn--max" target="<?php echo $item['target']; ?>"><?php echo $item['title']; ?></a>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  <?php 
    endwhile;
  endif;
  ?>
</main>
<?php get_footer(); ?>
