<?php get_header(); ?>
<?php if(is_page('thank-you')): ?>
<?php
  elseif(!is_front_page()):
?>
  <h1 class="page-title"><?php the_title(); ?></h1>
<?php endif; ?>
<main role="main" class="main">
  <?php get_template_part('templates/components'); ?>
</main>
<?php get_footer(); ?>
