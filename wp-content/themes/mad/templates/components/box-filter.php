<div class="box-filter">
  <div id="style" class="anchor"></div>
  <div class="container">
    <ul class="box-filter__list js-filter">
      <?php
        // Get list term of style taxonomy.
        $style_terms = get_terms( array(
            'taxonomy' => 'product_filter',
            'hide_empty' => false
        ));
      ?>
      <?php foreach ($style_terms as $key => $style_term): ?>
        <?php if (get_query_var('style', 'all') == $style_term->slug): ?>
          <li class="box-filter__item"><a href="<?php print add_query_arg('style', $style_term->slug); ?>#style_position" class="btn is-active"><?php print $style_term->name; ?></a></li>
        <?php else: ?>
          <li class="box-filter__item"><a href="<?php print add_query_arg('style', $style_term->slug); ?>#style_position" class="btn"><?php print $style_term->name; ?></a></li>
        <?php endif ?>
      <?php endforeach ?>
        <?php if (get_query_var('style', 'all') == 'all'): ?>
          <li class="box-filter__item"><a href="<?php print remove_query_arg('style'); ?>#style_position" class="btn is-active">VIEW ALL</a></li>
        <?php else: ?>
          <li class="box-filter__item"><a href="<?php print remove_query_arg('style'); ?>#style_position" class="btn">VIEW ALL</a></li>
        <?php endif ?>
    </ul>
  </div>
</div>
