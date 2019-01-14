<?php
  // loop through the rows of data
  if(have_rows('components')):
    while ( have_rows('components') ): the_row(); 

      // Banner
      get_template_part('templates/components/banner');

      // Box Quocte
      get_template_part( 'templates/components/box-quocte' );

      // Block Reference
      get_template_part( 'templates/components/block-reference' );

      // Box Image Video
      get_template_part( 'templates/components/box-image-video' );

      // Product Category
      get_template_part( 'templates/components/product-category' );

      // Box Contact
      get_template_part( 'templates/components/box-contact' );

      // Box Html
      get_template_part( 'templates/components/box-html' );

      // Box Image Text
      get_template_part( 'templates/components/box-image-text' );

      // Box Image Text
      get_template_part( 'templates/components/box-text' );

      // Grid Image
      get_template_part( 'templates/components/grid-image' );
    endwhile;
  endif;
?>