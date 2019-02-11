<?php
  // Navigation
  function mad_navigation($menuclass, $name, $themelocation='', $walker='') {
      wp_nav_menu(
      array(
    'theme_location'  => $themelocation,
    'menu'            => $name,
    'container'       => '',
    'container_class' => '$menuclass',
    'container_id'    => '',
    'menu_class'      => $menuclass,
    'menu_id'         => '',
    'echo'            => true,
    'fallback_cb'     => 'wp_page_menu',
    'before'          => '',
    'after'           => '',
    'link_before'     => '',
    'link_after'      => '',
    'items_wrap'      => '<ul>%3$s</ul>',
    'depth'           => 0,
    'walker'          => $walker
    )
      );
  }

  // Add i tag after a in navigation
  function mad_add_arrow( $item_output, $item, $depth, $args ){
    //Only add class to 'top level' items on the 'header' menu.
    $hasChildren = (in_array('menu-item-has-children', $item->classes));

    if('header-menu' == $args->theme_location ){
      if ($hasChildren) {
        $item_output = '<span>'.$item_output.'<i class="icon-arrow-right"></i></span>';
      } else {
        $item_output = '<span>'.$item_output.'</span>';
      }

      if (!$hasChildren && $depth == 1) {
        $item_output = '<span>'.$item_output.'<i class="icon-arrow-right hidden-on-mobile"></i></span>';
      }
    }

    return $item_output;
  }

  //custom menu item has children
  function custom_menu_item($item_output, $item, $depth, $args) {
    //Only add class to 'top level' items on the 'primary' menu.
    $hasChildren = (in_array('menu-item-has-children', $item->classes));

    if('header-menu' == $args->theme_location && $hasChildren ) {
        if($depth == 0) {
          $item_output .= '<div class="main-menu__wrap">
                            <div class="container">
                              <div class="main-menu__body">
                                <div class="main-menu__top">
                                  <div class="main-menu__back js-back">
                                    <span><span> &lt; </span> BACK</span>
                                  </div>

                                  <h3 class="main-menu__title">'.$item->title.'</h3>
                                </div>';
        } elseif($depth == 1) {
          $item_output .= '<div class="sub-menu__wrap">
                            <div class="container">
                              <div class="sub-menu__body">
                                <div class="main-menu__top">
                                  <div class="main-menu__back js-back">
                                    <span><span> &lt; </span> BACK</span>
                                  </div>

                                  <h3 class="main-menu__title">'.$item->title.'</h3>
                                </div>';
        }
    }

    return $item_output;
  }

  /**
   * class header nav walker menu
   */
  class header_nav_walker extends Walker_Nav_Menu
  {
    public function end_el( &$output, $item, $depth = 0, $args = array() ) {
      //Only add class to 'top level' items on the 'header' menu.
      $hasChildren = (in_array('menu-item-has-children', $item->classes));

      //get field image menu item
      $image = get_field('image', $item);

      if('header-menu' == $args->theme_location && $hasChildren ) {
        if($depth == 0) {
          // search form data
          $searchform = mad_string_termplate_part();

          //sitewide option
          $sitewidedata = get_field('sitewide', 'option');

          $output .= '<div class="header__top">
                        <ul>
                          <li class="form-header">
                            '.$searchform.'
                          </li>
                          <li class="text"><a href="">'.$sitewidedata['header_text'].'</a></li>
                          <li><a target="'.$sitewidedata['header_link_button']['target'].'" href="'.$sitewidedata['header_link_button']['url'].'" class="btn btn--large btn--no-change">Book a Consultation</a></li>
                        </ul>
                      </div>';
          if(!empty($image)) {
            $output .= '<div class="image-custom"><img src="'.$image['sizes']['menu-first'].'" alt="'.$image['alt'].'"></div>';
          }
          
          $output .= '</div>
                  </div>
                </div>
              </li>';
        } elseif($depth == 1) {
          // search form data
          $searchform = mad_string_termplate_part();

          //sitewide option
          $sitewidedata = get_field('sitewide', 'option');

          $output .= '<div class="header__top">
                        <ul>
                          <li class="form-header">
                            '.$searchform.'
                          </li>
                          <li class="text"><a href="" class="">'.$sitewidedata['header_text'].'</a></li>
                          <li><a target="'.$sitewidedata['header_link_button']['target'].'" href="'.$sitewidedata['header_link_button']['url'].'" class="btn btn--large btn--no-change">Book a Consultation</a></li>
                        </ul>
                      </div>';
          if(!empty($image)) {
            $output .= '<div class="image-custom"><img src="'.$image['sizes']['menu-second'].'" alt="'.$image['alt'].'"></div>';
          }

          $output .=  '</div>
              </div>
            </div>';
        }
      }

      if($depth > 0 ) {
        if (!empty($image)) {
          if($depth == 1) {
            $output .= '<div class="main-menu__image">
                <a href=""><img src="'.$image['sizes']['menu-first'].'" alt="'.$image['alt'].'"></a>
                  </div></li>';
          } else {
            $output .= '<div class="main-menu__image">
                <a href=""><img src="'.$image['sizes']['menu-second'].'" alt="'.$image['alt'].'"></a>
                  </div></li>';
          }
        }
      }
    }
  }

  add_filter( 'walker_nav_menu_start_el', 'mad_add_arrow',10,4);
  add_filter( 'walker_nav_menu_start_el', 'custom_menu_item',10,4);
?>