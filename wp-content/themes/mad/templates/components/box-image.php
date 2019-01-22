<?php if(get_row_layout() == 'box_image'):
  $image = get_sub_field('image');
  $title = get_sub_field('title');
  $class_modifier = get_sub_field('class_modifier');
?>
<div class="box-image <?php if($class_modifier) { echo $class_modifier; } ?>">
  <div class="container">
    <?php if($title): ?>
      <h2 class="box-image__title"><?php echo $title; ?></h2>
    <?php endif; ?>

    <?php if($image): ?>
      <div class="box-image__body">
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
      </div>
    <?php endif; ?>
  </div>
</div>
<?php endif; ?>