<?php 
  if(get_row_layout() == 'product_category'):
    $category = get_sub_field('category');

    if(!empty($category)): ?>
      <div class="grid-image">
        <div class="container">
          <div class="grid-image__list">
            <?php 
              foreach ($category as $term):
                $thumbnail = get_field('thumbnail','category_'.$term->term_id);  ?>

                <div class="grid-image__item">
                  <a href="<?php echo $term->slug; ?>">
                    <div class="grid-image__image">
                      <img src="<?php echo $thumbnail['url'] ?>" alt="">
                    </div>

                    <div class="grid-image__content">
                      <h2 class="grid-image__title text--white"><?php echo $term->name; ?></h2>

                      <div class="grid-image__link">
                        <span href="#" class="btn btn--white btn--small"><?php _e( 'explore', 'madtheme' ); ?></span>
                      </div>
                    </div>
                  </a>
                </div>
            <?php
              endforeach; ?>
          </div>
        </div>
      </div>
<?php 
  endif;
    endif; ?>