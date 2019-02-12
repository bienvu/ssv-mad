<?php
  if(have_posts()):
?>
    <div class="grid-image grid-image--has-paged">
      <div class="container">
        <div class="grid-image__list">
          <?php
            while(have_posts()): the_post();
              $gallery = get_field('gallery');
              $featured_image = $gallery[0];
              if(empty($featured_image)) {
                $featured_image['sizes']['product-image'] = '/wp-content/themes/mad/assets/images/placeholder.jpg';
              }

              if(!empty($featured_image)):
          ?>
            <div class="grid-image__item">
              <a href="<?php echo get_post_permalink(); ?>">
                <div class="grid-image__image">
                  <img src="<?php echo $featured_image['sizes']['product-image']; ?>" alt="<?php echo $featured_image['alt']; ?>">
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
      <?php
        get_template_part('templates/pagination');
      ?>
      </div>
    </div>
  <?php endif; ?>
