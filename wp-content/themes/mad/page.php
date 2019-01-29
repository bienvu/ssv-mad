<?php get_header(); ?>
<?php if(is_page('thank-you-contact') || is_page('thank-you-subscribe')): ?>
<?php
  elseif(!is_front_page()):
?>
  <div class="page-title">
    <h1><?php the_title(); ?></h1>
  </div>
<?php endif; ?>
<main role="main" class="main">
  <?php get_template_part('templates/components'); ?>
</main>
<?php get_footer(); ?>
