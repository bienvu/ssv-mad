<?php if(get_row_layout() == 'grid_content'): ?>
  <div class="grid-content">
    <div class="container">
      <div class="grid-content__wrap">
        <?php 
          if(have_rows('item')):
            while(have_rows('item')): the_row();
              $title = get_sub_field('title');
              $summary = get_sub_field('summary');
              $extend = get_sub_field('extend');
              $image = get_sub_field('image');
              $author = get_sub_field('author'); ?>
        <div class="grid-content__list">
          <?php if($image): ?>
            <div class="grid-content__image">
              <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
            </div>
          <?php endif; ?>

          <div class="grid-content__body">
            <?php if($title): ?>
              <h3 class="grid-content__title"><?php echo $title; ?></h3>
            <?php endif; ?>
            
            <?php if($summary): ?>
              <div class="grid-content__content">
                <p><?php echo $summary; ?></p>
                
                <?php if($extend): ?>
                  <p class="read-more"><?php echo $extend; ?></p>
                  <p><a href="" class="js-read-more"><?php echo __e('read more ...', 'ssvmad'); ?></a></p>
                <?php endif; ?>
              </div>
            <?php endif; ?>
            
            <?php if($author): ?>
            <div class="grid-content__name">
              <p><?php echo $author; ?></p>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <?php 
            endwhile;
          endif; ?>
      </div>
    </div>
  </div>
<?php endif; ?>