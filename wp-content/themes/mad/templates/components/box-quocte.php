<?php if(get_row_layout() == 'box_quocte'):
  $body = get_sub_field('body');
  $author = get_sub_field('author');
  $class_modifier = get_sub_field('class_modifier');
  $class_modifier = ($class_modifier) ? 'box-quocte-default--'.$class_modifier : "";
?>
<div class="box-quocte-default <?php if($class_modifier) { echo $class_modifier; } ?>">
    <div class="box-quocte-default__body">
    
      <?php if($body): ?>
        <div class="box-quocte-default__content">
          <blockquote>
            <?php echo $body; ?>
          </blockquote>
        </div>
      <?php endif; ?>

      <?php if($author): ?>
        <div class="box-quocte-default__author">
          <p><strong><?php echo $author; ?></strong></p>
        </div>
      <?php endif; ?>
    </div>
</div>
<?php endif; ?>