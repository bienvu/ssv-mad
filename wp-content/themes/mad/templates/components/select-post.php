<?php 
  if(get_row_layout() == 'select_post'):
    if(have_rows('item')):
?>
    <div class="grid-image <?php if($modifier) { echo 'grid-image--'.$modifier; } ?>">
      <div class="container">
        <div class="grid-image__list">
    <?php
      while(have_rows('item')): the_row();
        $page = get_sub_field('page');
        $title = ($page->post_type != 'page') ? "$page->post_type" : "Designer Interiors";
        $taxonomy = get_sub_field('taxonomy');

        if(!empty($page)) {
          if (has_post_thumbnail( $page->ID ) ) {
            $page_thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $page->ID ), 'single-post-thumbnail' );
            $page_link = get_page_link($page->ID);
          }

          if($page->post_type == 'artistry') {
            $page_link = get_post_permalink( $page->ID );
          }
        }

        if(!empty($taxonomy)) {
          $tem_object = get_term($taxonomy);
          $term_link = get_term_link($tem_object);
          $image = get_field('thumbnail',$tem_object);
        }
    ?>
          <div class="grid-image__item">
            <a href="<?php if(!empty($page)) { echo $page_link; } elseif(!empty($taxonomy)) { echo $term_link; } ?>">
              <div class="grid-image__image">
                <img src="<?php if(!empty($page)) { echo $page_thumbnail[0]; } elseif(!empty($taxonomy)) { echo $image['url']; } ?>" alt="<?php echo $image['alt']; ?>">
              </div>

              <div class="grid-image__content">
                <h2 class="grid-image__title text--white"><?php if(!empty($page)) { if($title) { echo $title; } } elseif(!empty($taxonomy)) { echo $tem_object->name; } ?></h2>

                <div class="grid-image__link">
                  <span class="btn btn--white btn--small"><?php echo _e( 'Explore', 'ssvmad' ); ?></span>
                </div>
              </div>
            </a>
          </div>
  <?php endwhile; ?>
        </div>
      </div>
    </div>
<?php endif;
  endif; ?>