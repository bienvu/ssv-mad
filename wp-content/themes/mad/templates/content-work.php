<div class="masonry-wrap">
  <div class="container">
    <ul class="masonry js-mas">
      <?php if (have_posts()): while (have_posts()) : the_post(); 
        $image = get_field('featured_image');
        $custom_mansonry_class = $image['sizes']['large-height'] > $image['sizes']['large-width'] ? 'masonry__item--2rows' : '';
      ?>
      <li class="masonry__item <?php echo $custom_mansonry_class; ?>">
        <div>
          <div class="masonry__image">
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
          </div>
          <div class="masonry__bg">
            <h2 class="masonry__title"><a href="<?php echo get_post_permalink(); ?>"><?php the_title(); ?></a></h2>

            <div class="masonry__link"><a href="<?php echo get_post_permalink(); ?>" class="btn btn--small"><?php _e( 'View Project', 'default' ); ?> </a></div>
          </div>
        </div>
      </li>
      <?php endwhile; ?>

      <?php else: ?>

        <!-- article -->
        <article>
          <h3><?php _e( 'Sorry, nothing to display.', 'ssvtheme' ); ?></h3>
        </article>
        <!-- /article -->

      <?php endif; ?>
    </ul>
  </div>
</div>
