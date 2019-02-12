<?php
  $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  
  $args = array(
          'post_type'       => 'work',
          'posts_per_page'  => '15',
          'meta_key'        => 'weight',
          'orderby'         => array('meta_value_num' => 'ASC', 'ID' => 'ASC'),
          'paged'           => $paged,
  );

  $style = get_query_var('style', '');
  // Taxonomy Parameters
  if(!empty($style)) {
    $args['tax_query'] = array(
      array(
        'taxonomy'          => 'product_filter',
        'field'             => 'slug',
        'terms'             => array(get_query_var('style')),
        'operator'          => 'IN',
      )
    );
  }

  $wp_query = new WP_Query($args);
?>
<div class="masonry-wrap">
  <div class="container">
    <ul class="masonry js-mas">
      <?php if ($wp_query->have_posts()): while ($wp_query->have_posts()) : $wp_query->the_post(); 
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
      <?php endwhile; wp_reset_postdata(); ?>

      <?php else: ?>

        <!-- article -->
        <article>
          <h3><?php _e( 'Sorry, nothing to display.', 'ssvtheme' ); ?></h3>
        </article>
        <!-- /article -->

      <?php endif; ?>
    </ul>
    
    <?php get_template_part('templates/pagination'); ?>
  </div>
</div>

<?php
  // Reset main query object
  wp_reset_query();
?>
