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
                <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_desktop['sizes']['banner']; ?>" alt="" class="hidden-on-mobile"></a>
                <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_mobile['url']; ?>" alt="" class="hidden-on-tablet"></a>
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
                  <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_desktop['sizes']['banner']; ?>" alt="" class="hidden-on-mobile"></a>
                  <a href="<?php echo $link['url']; ?>" target="<?php $link['target']; ?>"><img src="<?php echo $image_mobile['url']; ?>" alt="" class="hidden-on-tablet"></a>
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
              <q><?php echo $description; ?></q>
            </div>

            <div class="author">
              <a href="<?php echo $link_outer['url']; ?>" target="<?php $link_outer['target']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/markalexander.svg" alt=""></a>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="scroll-down js-scroll-down">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" width="15px" height="9px" class="icon icon-chevron " viewBox="0 0 15 9">
          <path fill="#FFFFFF" d="M7.5 5.7L2.2 0 .5 1.5l6.2 6.6.8.9.8-.9 6.1-6.6L12.8 0z"></path>
        </svg>
      </span>
    </div>
  </div>
<?php endif; ?>
