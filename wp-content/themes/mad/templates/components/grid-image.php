<?php
  if(get_row_layout() == 'grid_image'):
    $modifier = get_sub_field('modifier'); ?>

    <div class="grid-image <?php if($modifier) { echo 'grid-image--'.$modifier; } ?>">
      <div class="container">
        <?php if(have_rows('item')): ?>
    
        <div class="grid-image__list">
          <?php  while(have_rows('item')): the_row();
              $label  = get_sub_field('label');
              $link   = get_sub_field('link');
              $image  = get_sub_field('image'); ?>

              <div class="grid-image__item">
                <?php if(!empty($link)): ?>
                  <a href="<?php echo $link['url'] ?>">
                <?php endif; ?>

                    <?php if(!empty($image)): ?>
                      <div class="grid-image__image">
                        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                      </div>
                    <?php endif; ?>
                    
                    <?php if($label): ?>
                      <div class="grid-image__content">
                        <h2 class="grid-image__title text--white"><?php echo $label; ?></h2>
                        
                        <?php if(!empty($link)): ?>
                          <div class="grid-image__link">
                            <span  class="btn btn--white btn--small" blank="<?php echo $link['blank'] ?>"><?php echo $link['title'] ?></span>
                          </div>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>
                <?php if(!empty($link)): ?>
                  </a>
                <?php endif; ?>
              </div>

          <?php endwhile; ?>
        </div> 

        <?php  endif; ?>
  
      </div>
    </div>
<?php endif;?>
