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
    endwhile;
  endif;
?>