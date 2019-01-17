<?php 
/*
  Template Name: Work Product
 */
get_header();
?>
<main class="archive-work">
  <h1 class="page-title"><?php post_type_archive_title(); ?></h1>

  <section>
    <?php
      get_template_part('templates/components/box-filter');
      get_template_part('templates/content-work');
    ?>

    <?php get_template_part('templates/pagination'); ?>
    <?php echo do_shortcode( '[block id="box-text-with-link"]' ); ?>
  </section>
</main>
<?php get_footer(); ?>
