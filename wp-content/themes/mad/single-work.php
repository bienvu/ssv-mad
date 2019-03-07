<?php get_header(); ?>
<main role="main" class="main">
  <?php
    $featured_image = get_field('featured_image');
    $gallery = get_field('gallery');
    $work_extra = get_field('work_extra', 'option');

    if(have_posts()):
      while(have_posts()): the_post();
  ?>
  <h1 class="page-title hidden-on-desktopLarge"><?php the_title(); ?></h1>

  <div class="box-gallery box-gallery--image-right">
    <div class="container">
      <div class="box-gallery__wrap">
        <div class="box-gallery__left js-height">
          <div class="paginginfo text--bold"></div>
          <?php if(!empty($gallery)): ?>
          <div class="box-gallery__slider js-slide-product-paged js-pagination js-lightbox-product">
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
          <?php
            $link = "javascript:history.go(-1)";
            if(isset($_SERVER['HTTP_REFERER'])) {
                $link = $_SERVER['HTTP_REFERER'];
            } else {
              $link = '/work/';
            }
          ?>
          <a href="<?php echo $link; ?>" class="back-to text--small">< Back to Work</a>
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

          <div class="box-gallery__pagination">
            <?php
              $wpb_all_query = new WP_Query(array('post_type'=>'work', 'post_status'=>'publish', 'posts_per_page'=>-1, 'meta_key' => 'weight', 'orderby'=>array('meta_value_num' => 'ASC', 'ID' => 'ASC')));
              $all_posts = $wpb_all_query->get_posts();
              $prev_post = empty(get_previous_post()) ? $all_posts[count($all_posts) - 1] : get_previous_post();
              $next_post = empty(get_next_post()) ? $all_posts[0] : get_next_post();
              wp_reset_postdata();
            ?>
            <div class="box-gallery__previous">
              <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>">< View Previous Interior </a>
            </div>
            <div class="box-gallery__next">
              <a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>">View Next Interior ></a>
            </div>
          </div>
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
