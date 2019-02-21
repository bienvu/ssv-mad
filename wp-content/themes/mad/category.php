<?php
  get_header();
  $object = get_queried_object();
  $termId = $object->term_id;
  $childrenData = get_terms('category', array( 'parent' => $termId, 'hide_empty' => false, 'orderby' => 'term_id', ));
  $class = $object->parent ? 'page-title--has-breadcrumb' : '';
?>
  <div class="page-title <?php echo $class; ?>">
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
    <?php if(!empty($object->parent) && !empty($childrenData)): ?>
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
                    <h3 class="grid-image__title text--white"><?php the_title(); ?></h3>
                    
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
    <?php if(empty($childrenData)): ?>
      <?php get_template_part('templates/components/box-filter'); ?>
      <?php get_template_part('templates/content-product'); ?>
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
            
            <?php if(have_rows('category_link_extra', 'options')): ?>
              <div class="box-text__link">
                <?php while(have_rows('category_link_extra', 'options')): the_row();
                  if(have_rows('item', 'options')):
                    while(have_rows('item', 'options')): the_row();
                  $link = get_sub_field('link');
                  $class = get_sub_field('class');
                ?>
                  <a href="<?php if($link['url']) { echo $link['url']; } ?>" class="btn btn--large <?php if($class) { echo $class; } ?>" target="<?php if($link['target']) { echo $link['target']; } ?>"><?php if($link['title']) { echo $link['title']; } ?></a>
                <?php 
                      endwhile;
                    endif;
                  endwhile; ?>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </main>
<?php get_footer(); ?>
