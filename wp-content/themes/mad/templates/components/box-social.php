<?php
  if(get_row_layout() == 'box_social'):
    $title = get_sub_field('title');
?>
  <div class="box-social">
    <div class="container">
      <?php if($title): ?>
        <h4 class="box-social__title text--center text--black"><?php echo $title; ?></h4>
      <?php endif; ?>
      <?php if(have_rows('sitewide', 'options')): ?>
        <div class="box-social__list">
         <?php while (have_rows('sitewide', 'options')): the_row();
            if(have_rows('social')):
              while(have_rows('social')): the_row();
                if(have_rows('item')):
                  while(have_rows('item')): the_row();
                    $title = get_sub_field('title');
                    $link = get_sub_field('link');
                    $class = get_sub_field('class');
                    $image = get_sub_field('image');
                    if(!empty($image)):
      ?>
      
        <div class="box-social__item">
          <div class="box-social__image">
            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" /> 
          </div>
          
          <?php if($class): ?>
            <div class="box-social__icon">
              <a href="<?php if(!empty($link)) { echo $link['url']; } ?>" class="<?php echo $class; ?>"></a>
            </div>
          <?php endif; ?>
        </div>
      <?php
                    endif;
                  endwhile;
                endif;
              endwhile;
            endif;
          endwhile;
      ?>
      </div>
      <?php endif; ?>
    </div>
  </div>

<?php endif; ?>
