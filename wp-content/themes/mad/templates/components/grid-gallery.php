<?php
  if(get_row_layout() == 'grid_gallery'):
    $content_top = get_sub_field('content_top');
    $content_cener = get_sub_field('content_center');
    $item = get_sub_field('item');
?>
  <div class="grid-gallery">
    <div class="grid-gallery__wrap">
      <div class="grid-gallery__top">
        <div class="grid-gallery__position">
          <?php
            $count = count($item[0]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            $i = 2;
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[0]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        
        <?php
          $count = count($item[1]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[1]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <div class="grid-gallery__item">
          <div class="grid-gallery__content">
            <?php if($content_top['title']): ?>
              <h1 class="grid-gallery__title"><?php echo $content_top['title']; ?></h1>
            <?php endif; ?>
            
            <div class="grid-gallery__description">
              <?php if($content_top['subtitle']): ?>
                <h4 class="grid-gallery__subtitle">Artisan’s vision statement</h4>
              <?php endif; ?>
              
              <?php if($content_top['body']): ?>
                <?php echo $content_top['body']; ?>
              <?php endif; ?>

              <div class="grid-gallery__logo logo-1">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/markalexander.svg" alt="">
              </div>
            </div>
          </div>
        </div>

        <?php
          $count = count($item[2]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[2]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <?php
          $count = count($item[3]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[3]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      
      <div class="grid-gallery__bottom">
        <div class="grid-gallery__position">
          <?php
            $count = count($item[4]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[4]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>

          <?php
            $count = count($item[5]['image']);
            $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
            if (!empty($class)) {
              $class .= ' delay-'.$i;
              $i += 2;
            }
          ?>

          <div class="grid-gallery__item <?php echo $class; ?>">
            <?php foreach ($item[5]['image'] as $key => $value): ?>
              <div class="grid-gallery__image">
                <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="grid-gallery__item">
          <div class="grid-gallery__quote hidden-on-mobile">
            <?php if($content_cener ): ?>
              <q><?php echo $content_cener; ?></q>
            <?php endif; ?>

            <div class="grid-gallery__logo">
              <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mad_logo.svg" alt="">
            </div>
          </div>
        </div>

        <?php
          $count = count($item[6]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[6]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>

        <?php
          $count = count($item[7]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item <?php echo $class; ?>">
          <?php foreach ($item[7]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
        
        <?php
          $count = count($item[8]['image']);
          $class = ($count > 1) ? 'grid-gallery__animation slide-'.$count : "";
          if (!empty($class)) {
            $class .= ' delay-'.$i;
            $i += 2;
          }
        ?>

        <div class="grid-gallery__item">
          <?php foreach ($item[8]['image'] as $key => $value): ?>
            <div class="grid-gallery__image">
              <img src="<?php echo $value['url']; ?>" alt="<?php echo $value['alt']; ?>">
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    
    <div class="grid-gallery--mobile">
      <div class="container">
        <?php if($content_cener ): ?>
          <div class="grid-gallery__quote hidden-on-desktop">
            <q><?php echo $content_cener; ?></q>
          </div>
        <?php endif; ?>

        <div class="grid-gallery__content">
          <div class="grid-gallery__description">
            <?php if($content_top['subtitle']): ?>
              <h4 class="grid-gallery__subtitle">Artisan’s vision statement</h4>
            <?php endif; ?>

            <?php if($content_top['body']): ?>
              <?php echo $content_top['body']; ?>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
