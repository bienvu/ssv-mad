<?php
  /*
 Template Name: Work-Template
 */ 
  get_header();
  ?>
<h1 class="page-title"><?php the_title(); ?></h1>
<main role="main">
  <?php get_template_part('templates/components/box-filter'); ?>
  <?php get_template_part('templates/content-work'); ?>
  <?php get_template_part('templates/components'); ?>
</main>
<?php get_footer(); ?>
