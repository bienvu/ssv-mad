<div class="box-filter">
  <div id="style-position" class="anchor"></div>
  <div class="container">
    <ul class="box-filter__list js-filter">
      <?php
        // Get list term of style taxonomy.
        $style_terms = get_terms( array(
            'taxonomy' => 'product_filter',
            'hide_empty' => false
        ));

        // get url current no pagination
        global $wp;

        // get current url with query string.
        $current_url =  home_url( $wp->request ); 

        // get the position where '/page.. ' text start.
        $pos = strpos($current_url , '/page/');

        // remove string from the specific postion
        $finalurl = substr($current_url,0,$pos);
      ?>
      <?php foreach ($style_terms as $key => $style_term): ?>
        <?php if (get_query_var('style', 'all') == $style_term->slug): ?>
          <li class="box-filter__item"><a href="<?php echo add_query_arg('style', $style_term->slug, $finalurl); ?>#style-position" class="btn is-active"><?php echo $style_term->name; ?></a></li>
        <?php else: ?>
          <li class="box-filter__item"><a href="<?php echo add_query_arg('style', $style_term->slug, $finalurl); ?>#style-position" class="btn"><?php echo $style_term->name; ?></a></li>
        <?php endif ?>
      <?php endforeach ?>
        <?php if (get_query_var('style', 'all') == 'all'): ?>
          <li class="box-filter__item"><a href="<?php echo remove_query_arg('style'); ?>#style-position" class="btn is-active">VIEW ALL</a></li>
        <?php else: ?>
          <li class="box-filter__item"><a href="<?php echo remove_query_arg('style'); ?>#style-position" class="btn">VIEW ALL</a></li>
        <?php endif ?>
    </ul>
  </div>
</div>
