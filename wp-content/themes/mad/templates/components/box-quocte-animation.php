<?php if(get_row_layout() == 'box_quocte_animation'):
  $video = get_sub_field('video');
  $total = count(get_sub_field('item'));
  $link = get_sub_field('link');
?>
<div class="box-quocte">
  <div class="box-quocte__video">
    <video autoplay="autoplay" loop="loop" muted="muted">
        <source src="<?php echo $video; ?>" type="video/mp4">
    </video>
  </div>
  
  <div class="box-quocte__body">
    <div class="container">
      <div class="box-quocte__animation slide-<?php echo $total; ?>">
        <?php if(have_rows('item')): $i = 0; ?>
          <?php while(have_rows('item')): the_row(); $i++; ?>
            <?php
              $comment = get_sub_field('comment');
              $author  = get_sub_field('author');
            ?>

            <div class="quocte">
              <div class="container">
                <?php if($comment): ?>
                  <div class="quocte__content"><?php echo $comment; ?></div>
                <?php endif; ?>
                
                <?php if($author): ?>
                  <div class="quocte__author"><strong><?php echo $author; ?></strong></div>

                <?php else: ?>
                  <div class="box-quocte__image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/mad_logo.svg" alt="">
                  </div>
                <?php endif; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <?php if($link): ?>
    <a href="<?php echo $link['url']; ?>" target="<?php echo $link['target']; ?>" class="box-quocte__link">link to page</a>
  <?php endif; ?>
</div>
<?php endif; ?>