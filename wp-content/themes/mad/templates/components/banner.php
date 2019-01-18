<?php if(get_row_layout() == 'banner'):
  $class_modifier = get_sub_field('class_modifier');
  $description = get_sub_field('description');
  $link_outer = get_sub_field('link_outer');
?>
  <div class="banner <?php if($class_modifier) { echo $class_modifier;} ?> ">
    <div class="banner__wrap">
      <div class="banner__list js-slide">
        <?php
          if(have_rows('banner_item')): the_row();
            $image_desktop = get_sub_field('image_desktop');
            $image_mobile = (get_sub_field('image_mobile')) ? get_sub_field('image_mobile') : $image_desktop ;
            $link = get_sub_field('link');
        ?>
            <div class="banner__item">
              <div class="banner__image">
                <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_desktop['url']; ?>" alt="" class="hidden-on-mobile"></a>
                <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_mobile['url']; ?>" alt="" class="hidden-on-desktop"></a>
              </div>

              <?php if($description): ?>
                <div class="banner__description">
                  <div class="container">
                    <div class="banner__content">
                      <q><?php echo $description; ?></q>
                    </div>

                    <div class="author">
                      <a href="<?php echo $link_outer['url']; ?>" target="<?php $link_outer['target']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/markalexander.svg" alt=""></a>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php   
            while (have_rows('banner_item')):  the_row();
              $image_desktop = get_sub_field('image_desktop');
              $image_mobile = (get_sub_field('image_mobile')) ? get_sub_field('image_mobile') : $image_desktop ;
              $link = get_sub_field('link');
          ?>
              <div class="banner__item">
                <div class="banner__image">
                  <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_desktop['url']; ?>" alt="" class="hidden-on-mobile"></a>
                  <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_mobile['url']; ?>" alt="" class="hidden-on-desktop"></a>
                </div>
              </div>
          <?php
            endwhile;
          endif;
        ?>
      </div>
      
      <?php if($description): ?>
        <div class="banner__description">
          <div class="container">
            <div class="banner__content">
              <?php echo $description; ?>
            </div>

            <div class="author">
              <a href="<?php echo $link_outer['url']; ?>" target="<?php $link_outer['target']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/markalexander.svg" alt=""></a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="scroll-down js-scroll-down">
      <span><i class="icon-arrow-down">arrow down</i></span>
    </div>
  </div>
<?php endif; ?>
