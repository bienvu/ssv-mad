<?php
  /*
 Template Name: Basic
 */ 
  get_header();
?>
<div class="page-title">
  <h1><?php the_title(); ?></h1>
</div>
<main role="main" class="reset-base">
  <div class="container">
    <?php if(have_posts()): ?>
      <?php while(have_posts()): the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>
<?php get_footer(); ?>
