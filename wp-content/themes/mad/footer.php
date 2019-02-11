      <?php
        if(have_rows('sitewide', 'options')):
          while (have_rows('sitewide', 'options')): the_row();
            $footer_form      = get_sub_field('footer_form', 'options');
            $socialData       = get_sub_field('social', 'options');
            $footer_bottom    = get_sub_field('footer_bottom', 'options');
            $footer_contact    = get_sub_field('footer_contact', 'options');
      ?>
        <footer class="footer">
          <div class="container">
            <div class="footer__wrap">
              <div class="footer__contact">
                <div class="container">
                  <h4 class="footer__title"><?php _e('Contact', 'madtheme'); ?></h4>

                  <div class="footer__description">
                    <?php echo $footer_contact['body']; ?>
                  </div>

                  <div class="footer__image">
                    <p><a href="<?php echo $footer_contact['link_image']['url']; ?>" target="<?php echo $footer_contact['link_image']['target']; ?>"><?php _e('Click through to', 'madtheme') ?></a></p>
                    <p><a href="<?php echo $footer_contact['link_image']['url']; ?>" target="<?php echo $footer_contact['link_image']['target']; ?>"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/frenchtables_logo.svg" alt=""></a></p>
                  </div>
                </div>
              </div>
              
              <?php if($footer_form): ?>
                <div class="footer__subscribe">
                  <div class="container">
                    <div class="fsubs">
                      <?php echo do_shortcode( '[contact-form-7 id="' . $footer_form->ID . '" title="' . $footer_form->post_title . '"]' ); ?>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
              
              <?php 
                if(have_rows('social')):
                  while(have_rows('social')): the_row();
                    $body = get_sub_field('body');
              ?>
                    <div class="footer__social">
                      <div class="container">
                        <div class="soc">
                          <h4 class="soc__title footer__title"><?php _e('Follow', 'madtheme'); ?></h4>
                          
                          <?php if($body): ?>
                            <div class="soc__des">
                              <?php echo $body; ?>
                            </div>
                          <?php endif; ?>
                          
                          <?php
                            if(have_rows('item')):
                              echo '<ul class="soc__list">';
                              while(have_rows('item')): the_row();
                                $link   = get_sub_field('link');
                                $class  = get_sub_field('class');
                                if($class):
                          ?>
                                <li><a href="<?php echo $link['url']; ?>" class="<?php echo $class; ?>" target="<?php echo $link['target']; ?>"><?php echo $link['title']; ?></a></li>
                          <?php
                                endif;
                              endwhile;
                              echo '</ul>';
                            endif;
                          ?>
                        </div>
                      </div>
                    </div>
              <?php 
                  endwhile;
                endif; 
              ?>
              <div class="footer__menu">
                <div class="container">
                  <h4 class="footer__title"><?php _e('Home', 'madtheme'); ?></h4>
                  <div class="menu-second">
                    <?php mad_navigation('', 'menu basic', 'footer-menu'); ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <?php if($footer_bottom): ?>
            <?php echo $footer_bottom; ?>
          <?php endif; ?>
        </footer>
      <?php 
          endwhile;
        endif;
      ?>
    </div>
    <!-- /wrapper -->

    <?php wp_footer(); ?>
  </body>
</html>
