<?php
  if(get_row_layout() == 'box_html'):

    $body = get_sub_field('body');

    if ($body):
?>
      <div class="box-html">
        <div class="container">
          <?php echo $body; ?>
        </div>
      </div>
<?php
    endif;
  endif;
?>