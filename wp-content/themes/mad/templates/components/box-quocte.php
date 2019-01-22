<?php if(get_row_layout() == 'box_quocte'):
  $body = get_sub_field('body');
  $author = get_sub_field('author');
  $class_modifier = get_sub_field('class_modifier');
?>
<div class="box-quocte-default-default <?php if($class_modifier) { echo $class_modifier; } ?>">
  <div class="box-quocte-default__body">
    <div class="container">
      <?php if($body): ?>
        <div class="box-quocte-default__content">
          <?php echo $body; ?>
        </div>
      <?php endif; ?>

      <?php if($author): ?>
        <div class="box-quocte-default__author">
          <?php echo $author; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php endif; ?>