<?php
  // $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
  
  // $args = array(
  //         'post_type'       => 'product',
  //         'posts_per_page'  => '18',
  //         'meta_key'        => 'weight',
  //         'orderby'         => array('meta_value_num' => 'ASC', 'ID' => 'ASC'),
  //         'paged'           => $paged,
  // );

  // $style = get_query_var('style', '');
  // $term = get_queried_object();
  // // Taxonomy Parameters
  // if(!empty($style)) {
  //   $args['tax_query'] = array(
  //     'relation' => 'AND',
  //     array(
  //       'taxonomy'          => 'product_filter',
  //       'field'             => 'slug',
  //       'terms'             => array(get_query_var('style')),
  //       'operator'          => 'IN',
  //     ),
  //     array(
  //       'taxonomy'          => 'category',
  //       'field'             => 'slug',
  //       'terms'             => array($term->slug),
  //       'operator'          => 'IN',
  //     )
  //   );
  // } else {
  //   $args['tax_query'] = array(
  //     array(
  //       'taxonomy'          => 'category',
  //       'field'             => 'slug',
  //       'terms'             => array($term->slug),
  //       'operator'          => 'IN',
  //     )
  //   );
  // }

  // $wp_query = new WP_Query($args);
  if(have_posts()):
?>
    <div class="grid-image grid-image--has-paged">
      <div class="container">
        <div class="grid-image__list">
          <?php
            while(have_posts()): the_post();
              $gallery = get_field('gallery');
              $featured_image = $gallery[0];
              if(!empty($featured_image)):
          ?>
            <div class="grid-image__item">
              <a href="<?php echo get_post_permalink(); ?>">
                <div class="grid-image__image">
                  <img src="<?php echo $featured_image['url']; ?>" alt="<?php echo $featured_image['alt']; ?>">
                </div>

                <div class="grid-image__content">
                  <h2 class="grid-image__title text--white"><?php the_title(); ?></h2>
                  
                  <div class="grid-image__link">
                    <span class="btn btn--white btn--small"><?php _e( 'VIEW PRODUCT', 'ssvmad' ); ?></span>
                  </div>
                </div>
              </a>
            </div>
          <?php 
              endif;
            endwhile;
          ?>
        </div>
      </div>
    </div>
  <?php endif; ?>

<?php

  get_template_part('templates/pagination');

  // Reset main query object
  // wp_reset_query();
?>
