<?php if(get_row_layout() == 'block_reference'):
  $block = get_sub_field('block');
  
  if($block) {
    echo $block->post_content;
  }
  endif;
?>