<?php
  if(get_row_layout() == 'grid_gallery'):
    $content_top = get_sub_field('content_top');
    $content_cener = get_sub_field('content_center');
    $item = get_sub_field('item');
    $artistry_title    = get_field('artistry_title', 'options');
    $total_animation = empty(get_sub_field('total_animation')) ? 3 : get_sub_field('total_animation');
    $delay = $total_animation;
?>
  <div class="grid-gallery <?php echo 'total-slide-'.$total_animation; ?>">
    <div class="grid-gallery__wrap">
      <div class="grid-gallery__top">
        <div class="grid-gallery__position">
          <?php
            $count = count($item[0]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            $i = 2;
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[0]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        
        <?php
          $count = count($item[1]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[1]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div class="grid-gallery__item">
          <div class="grid-gallery__content">
            <div class="grid-gallery__body">
              <?php if($content_top['title']): ?>
                <h1 class="grid-gallery__title"><?php echo $content_top['title']; ?></h1>
              <?php endif; ?>
              
              <div class="grid-gallery__description">
                <?php if($content_top['subtitle']): ?>
                  <h4 class="grid-gallery__subtitle">Artisan’s vision statement</h4>
                <?php endif; ?>
                
                <?php if($content_top['body']): ?>
                  <?php echo $content_top['body']; ?>
                <?php endif; ?>

                <div class="grid-gallery__logo logo-1">
                  <img src="<?php echo get_template_directory_uri(); ?>/assets/images/markalexander.svg" alt="">
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php
          $count = count($item[2]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[2]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>

          <div class="grid-gallery__logoimage">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/ma_logo_white.svg" alt="">
          </div>
        </div>

        <?php
          $count = count($item[3]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[3]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      
      <div class="grid-gallery__bottom">
        <div class="grid-gallery__position">
          <?php
            $count = count($item[4]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[4]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>

          <?php
            $count = count($item[5]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[5]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="grid-gallery__item">
          <div class="grid-gallery__quote">
            <?php if($content_cener ): ?>
              <q  class="hidden-on-mobile"><?php echo $content_cener; ?></q>
            <?php endif; ?>

            <div class="grid-gallery__logo hidden-on-mobile">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mad_logo.svg" alt="">
            </div>

            <div class="grid-gallery__logo logo-2 hidden-on-tablet">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mad_logo_2.svg" alt="">
            </div>
          </div>
        </div>

        <?php
          $count = count($item[6]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[6]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <?php
          $count = count($item[7]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[7]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
        
        <?php
          $count = count($item[8]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[8]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    
    <div class="grid-gallery--mobile">
      <div class="container">
        <?php if($content_cener ): ?>
          <div class="grid-gallery__quote hidden-on-tablet">
            <q><?php echo $content_cener; ?></q>
          </div>
        <?php endif; ?>

        <div class="grid-gallery__content">
          <div class="grid-gallery__body">
            <div class="grid-gallery__description">
              <?php if($content_top['subtitle']): ?>
                <h4 class="grid-gallery__subtitle">Artisan’s vision statement</h4>
              <?php endif; ?>

              <?php if($content_top['body']): ?>
                <?php echo $content_top['body']; ?>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <?php if($artistry_title): ?>
        <h4 class="grid-gallery__pagetitle"><?php echo $artistry_title; ?></h4>
      <?php endif; ?>
      <div class="grid-gallery__link">
        <?php
          $wpb_all_query = new WP_Query(array('post_type'=>'artistry', 'post_status'=>'publish', 'posts_per_page'=>-1));
          $all_posts = $wpb_all_query->get_posts();
          $prev_post = empty(get_next_post()) ? $all_posts[count($all_posts) - 1] : get_next_post();
          $next_post = empty(get_previous_post()) ? $all_posts[0] : get_previous_post();
          wp_reset_postdata();
        ?>
        
        <a href="<?php echo esc_url( get_permalink( $prev_post->ID ) ); ?>" class="btn btn--paged"><?php _e('PREVIOUS STYLE', 'ssvmad'); ?></a><a href="<?php echo esc_url( get_permalink( $next_post->ID ) ); ?>" class="btn btn--paged"><?php _e('NEXT STYLE', 'ssvmad'); ?></a>
      </div>
    </div>
  </div>
<?php endif; ?>
