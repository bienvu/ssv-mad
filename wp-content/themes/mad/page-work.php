<?php
  /*
 Template Name: Work-Template
 */ 
  get_header();
  ?>
<div class="page-title">
  <h1><?php the_title(); ?></h1>
</div>
<main role="main">
  <?php get_template_part('templates/components/box-filter'); ?>
  <?php get_template_part('templates/content-work'); ?>
  <?php get_template_part('templates/components'); ?>
</main>
<?php get_footer(); ?>
