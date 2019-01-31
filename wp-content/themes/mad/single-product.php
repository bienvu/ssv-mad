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
    $product_realted = get_field('product_realted');
    $product_extra = get_field('product_extra', 'option');
    $product_seo_extra = get_field('product_seo_extra', 'option');
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
    
      <div class="box-gallery__lightbox-form is-lightbox-form">
        <div class="container">
          <div class="lightbox-form">
            <div class="lightbox-form__wrap">
              <h2 class="lightbox-form__title text--center">Enquire Now</h2>

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
  </div>
  
  <?php if(!empty($product_realted)): ?>
    <div class="grid-image grid-image--with-bg bg--light-gray ?>">
      <div class="container">
        <h2 class="grid-image__title">You May Also Like</h2>
        <div class="grid-image__list">
          <?php  foreach($product_realted as $produc_id):
              $post_object = get_post( $produc_id );
              $gallery  = get_field('gallery', $post_object);
              $post_url = get_permalink( $post_object );
              $gallery = $gallery[0]; ?>

              <div class="grid-image__item">
                <?php if(!empty($post_url)): ?>
                  <a href="<?php echo $post_url; ?>">
                <?php endif; ?>

                    <?php if(!empty($gallery)): ?>
                      <div class="grid-image__image">
                        <img src="<?php echo $gallery['url']; ?>" alt="<?php echo $gallery['alt']; ?>">
                      </div>
                    <?php endif; ?>
                <?php if(!empty($post_url)): ?>
                  </a>
                <?php endif; ?>
              </div>

          <?php endforeach; ?>
        </div> 
      </div>
    </div>
  <?php endif; ?>

  <?php 
    endwhile;
  endif;
  ?>

  <?php if($product_seo_extra): ?>
    <div class="box-text">
    <div class="container">
      <div class="box-text__body">
        <?php echo $product_seo_extra; ?>
      </div>
    </div>
  </div>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
