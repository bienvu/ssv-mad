<?php
  get_header();
  $object = get_queried_object();
  $termId = $object->term_id;
  $childrenData = get_terms('category', array( 'parent' => $termId, 'hide_empty' => false, 'orderby' => 'term_id', ));
?>
  <div class="page-title page-title--has-breadcrumb">
    <?php 
      if (!empty($object->parent)) {
        if (function_exists('mad_breadcrumb')) {
          mad_breadcrumb();
        }
      }
    ?>
    <h1><?php single_cat_title(); ?></h1>
  </div>

  <main role="main" class="<?php if(!empty($childrenData)):?>category-page<?php else: ?>sub-category-page<?php endif; ?>">
    <?php if(!empty($childrenData)): ?>
      <div class="grid-image grid-image--large">
        <div class="container">
          <div class="grid-image__list">
            <?php
              foreach( $childrenData as $term ):
                $thumbnail = get_field('thumbnail', $term);
                $term_slug[] = $term->slug;
                if(!empty($thumbnail)):
            ?>
              <div class="grid-image__item">
                <a href="<?php echo get_term_link($term, 'category'); ?>">
                  <div class="grid-image__image">
                    <img src="<?php echo $thumbnail['url']; ?>" alt="<?php echo $thumbnail['alt']; ?>">
                  </div>

                  <div class="grid-image__content">
                    <h2 class="grid-image__title text--white"><?php echo $term->name; ?></h2>
                    
                    <div class="grid-image__link">
                      <span class="btn btn--white btn--small"><?php _e( 'Explore', 'ssvmad' ); ?></span>
                    </div>
                  </div>
                </a>
              </div>
            <?php 
                endif;
              endforeach;
            ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if(!empty($object->parent)): ?>
      <div class="grid-image grid-image--large grid-image--border-hidden">
        <div class="container">
          <h2 class="main-title"><?php _e( 'View Latest Styles', 'ssvmad' );  ?></h2>
          <div class="grid-image__list">
            <?php
              $args = array(
                'post_type'       => 'product',
                'posts_per_page'  => 6,
                'meta_key'        => 'weight',
                'orderby'         => array('meta_value_num' => 'ASC', 'ID' => 'ASC'),
                'meta_query'      => array(
                  array(
                    'key' => 'gallery',
                    'compare' => 'EXISTS',
                  )
                ),
              );

              if(!empty($term_slug)) {
                $args['tax_query'] = array(
                  array(
                    'taxonomy' => 'category',
                    'field' => 'slug',
                    'terms' => $term_slug,
                    'operator' => 'IN',
                  )
                );
              }

              $wp_query = new WP_Query($args);
              if($wp_query->have_posts()):
                while($wp_query->have_posts()): $wp_query->the_post();
                  $image = get_field('gallery');
                  $image = $image[0];
                  if(!empty($image)):
            ?>
              <div class="grid-image__item">
                <a href="<?php echo get_post_permalink(); ?>">
                  <div class="grid-image__image">
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                  </div>

                  <div class="grid-image__content">
                    <h2 class="grid-image__title text--white"><?php the_title(); ?></h2>
                    
                    <div class="grid-image__link">
                      <span class="btn btn--white btn--small"><?php _e( 'Explore', 'ssvmad' ); ?></span>
                    </div>
                  </div>
                </a>
              </div>

            <?php
                  endif; 
                endwhile;wp_reset_postdata();
              endif;wp_reset_query();
            ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
    <?php if(have_rows('seo', $object)): the_row();
        $title = get_sub_field('title');
        $body  = get_sub_field('body');
    ?>
        <div class="box-text">
        <div class="container">
          <div class="box-text__body">
            <?php if($title): ?>
              <h4 class="box-text__title"><?php echo $title; ?></h4>
            <?php endif; ?>
            
            <?php if($body): ?>
              <div class="box-text__content">
                <?php echo $body; ?>
              </div>
            <?php endif; ?>
            
            <div class="box-text__link">
              <a href="/contact/" class="btn btn--large hidden-on-desktoponly" blank="">Book a Consultation</a><a href="/services/" class="btn btn--large " blank="">Our Services</a>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
<?php get_footer(); ?>
