<?php get_header(); ?>
<main role="main" class="main">
  <div class="page-title page-title--has-breadcrumb">
    <?php 
      if (function_exists('mad_breadcrumb')) {
        mad_breadcrumb();
      }
    ?>
    <h1><?php the_title(); ?></h1>
  </div>

  <?php
    $featured_image = get_field('featured_image');
    $sku = get_field('sku');
    $gallery = get_field('gallery');
    $related = get_field('related');
    $product_extra = get_field('product_extra', 'option');
    $product_button = get_field('product_button', 'option');
    $sitewide = get_field('sitewide', 'option');
    $link_fb = $sitewide['social']['item'][0]['link']["url"];

    if(empty($gallery)) {
      $gallery[]['url'] = '/wp-content/themes/mad/assets/images/placeholder.jpg';;
    }

    if(have_posts()):
      while(have_posts()): the_post();
  ?>
  <div class="box-gallery">
    <div class="container">
      <div class="box-gallery__wrap">
        <div class="box-gallery__left js-height">
          <div class="paginginfo text--bold"></div>
          <?php if(!empty($gallery)): ?>
          <div class="box-gallery__slider js-slide-product js-lightbox-product">
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
          <div class="box-gallery__content">
            <?php the_content(); ?>
            <p><strong>Product Code:</strong> <?php echo $sku; ?></p>
            <?php echo $product_extra; ?>
          </div>
          
            <div class="box-gallery__link">
                <a href="" class="btn js-lightbox-form"><?php _e( 'Enquire Now', 'ssvmad' ); ?></a>  <a href="<?php echo 'https://www.facebook.com/sharer/sharer.php?u='.$link_fb; ?>" class="btn btn--icon icon-share"><?php echo _e( 'SHARE', 'ssvmad' ); ?></a>
            </div>
        </div>
      </div>
    </div>
    
    <?php if(!empty($product_button)): ?>
      <div class="box-gallery__lightbox-form is-lightbox-form">
        <div class="container">
          <div class="lightbox-form">
            <div class="lightbox-form__wrap">
              <?php if(!empty($product_button[0])): ?>
                <h2 class="lightbox-form__title text--center"><?php echo $product_button[0]['button_text']; ?></h2>
              <?php endif; ?>

              <div class="lightbox-form__body">
                <div class="lightbox-form__left">
                  <?php if(!empty($gallery[0])): ?>
                    <div class="lightbox-form__image">
                      <img src="<?php echo $gallery[0]['url']; ?>" alt="">
                    </div>
                  <?php endif; ?>

                  <div class="lightbox-form__content">
                    <h4 class="lightbox-form__subtitle"><?php the_title(); ?></h4>

                    <p><strong>Product Code:</strong> <?php echo $sku; ?></p>
                  </div>
                </div>

                <div class="lightbox-form__right">
                  <div class="enquire-now">
                    <?php echo do_shortcode( '[contact-form-7 id="85" title="Enquiry form"]' ); ?>                
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
  <?php 
    endwhile;
  endif;
  ?>
</main>
<?php get_footer(); ?>
