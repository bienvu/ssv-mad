<?php 
  if(get_row_layout() == 'product_category'):
    $category = get_sub_field('category');
    $no_category = get_sub_field('not_category');

    if(!empty($category) || !empty($no_category)): ?>
      <div class="grid-image">
        <div class="container">
          <div class="grid-image__list">
            <?php if(!empty($no_category)): ?>
              <div class="grid-image__item">
                <a href="<?php if($no_category['link']) { echo $no_category['link']['url']; }  ?>">
                  <?php if($no_category['image']): ?>
                    <div class="grid-image__image">
                      <img src="<?php echo $no_category['image']['url']; ?>" alt="">
                    </div>
                  <?php endif; ?>

                  <div class="grid-image__content">
                    <?php if($no_category['title']): ?>
                      <h2 class="grid-image__title text--white"><?php echo $no_category['title']; ?></h2>
                    <?php endif; ?>
                    
                    <?php if($no_category['link']): ?>
                      <div class="grid-image__link">
                        <span href="#" class="btn btn--white btn--small"><?php echo $no_category['link']['title']; ?></span>
                      </div>
                    <?php endif; ?>
                  </div>
                </a>
              </div>
            <?php
              endif;
              if(!empty($category)):
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
                endforeach;
              endif; ?>
          </div>
        </div>
      </div>
<?php 
    endif;
  endif; ?>