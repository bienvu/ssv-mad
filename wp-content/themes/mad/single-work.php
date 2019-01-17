<?php get_header(); ?>
<main role="main" class="main">
  <?php
    $featured_image = get_field('featured_image');
    $gallery = get_field('gallery');
    $product_extra = get_field('product_extra', 'option');
  ?>
  <div class="box-gallery box-gallery--image-right">
    <div class="container">
      <div class="box-gallery__wrap">
        <div class="box-gallery__left js-height">
          <div class="paginginfo"></div>
          <?php if(!empty($gallery)): ?>
          <div class="box-gallery__slider js-slide js-pagination js-lightbox-product">
            <?php foreach ($gallery as $value): ?>
              <div class="box-gallery__item" data-src="<?php echo $value['url']; ?>">
                <div class="box-gallery__image">
                  <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
                </div>

                <i class="icon-enlarge">icon enlarge</i>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
        </div>

        <div class="box-gallery__right">
          <a href="#">back to work</a>
          <h4 class="box-gallery__title">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</h4>

          <div class="box-gallery__content">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

            <p><strong>At Mark Alexander Design Artistry we combine style, creativity and functionality to deliver highly customised and sophisticated living spaces, that precisely reflect and enhance your lifestyle and home. Contact us on 1300 133 326 | 0499 458 033 or enquire below to find out how we can customise an interior or stand-out furniture piece for your home.</strong></p>
          </div>

          <div class="box-gallery__link">
            <a href="" class="btn js-lightbox-form">ENQUIRE NOW</a>
            <a href="" class="btn btn--icon icon-share">share</a>
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
                <div class="lightbox-form__image">
                  <img src="/pattern-lab/source/images/MA-light-box.jpg" alt="">
                </div>

                <div class="lightbox-form__content">
                  <h4 class="lightbox-form__subtitle">Product title dolor sit amet sugatur<br> consectetur adipiscing elit</h4>

                  <p><strong>Product Code</strong>: SOFA1234</p>
                </div>
              </div>

              <div class="lightbox-form__right">
                <form action="">
                  <div class="form-list">
                    <div class="form-item">
                      <input type="text" placeholder="Name*">
                    </div>
                    <div class="form-item">
                      <input type="email" placeholder="Email*">
                    </div>

                    <div class="form-item">
                      <input type="tel" placeholder="Phone">
                    </div>
                    <div class="form-item">
                      <textarea type="text" placeholder="message"></textarea>
                    </div>
                    <div class="form-item">
                      <input type="text" placeholder="To help prevent spam, please type the word ‘artistry’."></input>
                    </div>
                  </div>

                  <div class="form-list">
                    <div class="form-item form-type-checkbox">
                      <input type="checkbox" id="checkbox" class="form-checkbox">
                      <label for="checkbox" class="option">Subscribe to news</label>
                    </div>
                    <div class="form-actions">
                      <button type="submit">submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</main>
<?php get_footer(); ?>
