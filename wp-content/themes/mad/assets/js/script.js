/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire*/
(function (window, document, $) {
  var $html = $('html'),
    mobileOnly = "screen and (max-width:47.9375em)", // 767px.
    mobileLandscape = "(min-width:30em)", // 480px.
    tablet = "(min-width:48em)"; // 768px.
  // Contact form 7 redirect after submit.
  document.addEventListener( 'wpcf7mailsent', function( event ) { console.log(1);
    if ( '85' == event.detail.contactFormId ) {
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you-contact/';
    }else if('98' == event.detail.contactFormId){
        window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you-subscribe/';
    }
  }, false );

  // Function here.
  // $('.box-faq__question').each(function() {
  //   $(this).on('click', function (e) {
  //     if ($(this).hasClass('is-show')) {
  //       $('.box-faq__question').removeClass('is-show');
  //       $('.box-faq__answer').slideUp();
  //       $(this).next().slideUp();
  //     } else {
  //       $('.box-faq__question').removeClass('is-show');
  //       $(this).addClass('is-show');
  //       $('.box-faq__answer').slideUp();
  //       $(this).next().slideDown();
  //     }
  //   });
  // });

  // Js code.
  $( document ).ready(function() {
    // Remove attr title.
    $('a, img').removeAttr('title');

    // Add placeholder to quiz validate form.
    $('.wpcf7-quiz').attr('placeholder', 'text-here');

    // Table responsive
    var $table = $('table');
    if ($table.length && !$table.parent().hasClass('table-responsive')) {
      $table.not($table.find('table')).wrap('<div class="table-responsive"></div>');
    }

    // Anchor scroll
    // $("a.anchor").click(function(e) {
    //   e.preventDefault();
    //   var aid = $(this).attr("href");
    //   $('html,body').animate({scrollTop: $(aid).offset().top - 20 },'slow');
    // });

    // js light box product icon
    if($('.js-lightbox-product-icon').length) {
      $('.js-lightbox-product-icon').click(function(event) {
        $('.js-lightbox-product .slick-active').trigger('click');
      });
    }

    //scroll to next section
    $('.js-scroll-down').click(function() {
      var $next = $(this).parent().next().offset().top - 86;console.log($next);
      $('html, body').animate({
        scrollTop: $next
      }, 'slow');
    });

    $(document).scroll(function(event) {
      setTimeout(function () {
        if($(this).scrollTop() >= 40) {
          $('.js-header').addClass('is-sticky');
        } else {
          $('.js-header').removeClass('is-sticky');
        }
      }, 100)
    });

    // js menu mobile
    $('li > span > i').click(function(event) {
      $(this).parent().next().addClass('is-show');
    });

    //js read more
    if($('.js-read-more').length) {
      $('.js-read-more').click(function(e) {
        e.preventDefault();
        if($(this).parent().parent().parent().parent().hasClass('is-show')) {
          $(this).parent().parent().parent().parent().removeClass('is-show');
          $(this).text('Read More...');
        }else {
          $(this).parent().parent().parent().parent().addClass('is-show');
          $(this).text('Read Less');
        }
      });
    }

      // js back on menu
    if($('.js-back').length) {
      $('.js-back').children().click(function(event) {
        $(this).parents('.is-show').first().removeClass('is-show');
      });
    }

    // js menu bar
    $('.menu-bars').click(function(event) {
      $(this).toggleClass('is-change');
      $('body').toggleClass('no-scroll');

      if($('.header__menu').hasClass('is-show')) {
        $('.header__menu').slideUp('slow');
        $('.header__menu').removeClass('is-show');
      } else {
        $('.header__menu').slideDown('slow');
        $('.header__menu').addClass('is-show');
      }
    });

    // js footer
    setTimeout(function() {
      var $lastScrollTop = 0;
      $(window).on('scroll',function(event) {
        $st = $(this).scrollTop();
        if($st > 240) {
          if($st >= $lastScrollTop ) {
            $('.js-footer').addClass('is-show');
          } else {
            $('.js-footer').removeClass('is-show');
          }

          $lastScrollTop = $st;
        }
      });
    }, 1000);

    // js gallery
    if($('.js-lightbox-product').length) {
      $('.js-lightbox-product').lightGallery({
        mode: 'lg-fade',
        download: false,
      });
    }

    // js pagingInfo for js-slider
    var $status = $('.paginginfo');
    var $slickElement = $('.js-pagination');

    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.html( i + '<span> / ' + slick.slideCount + '</span>');
    });

    // js slide
    if($('.js-slide').length) {
      $('.js-slide').slick({
        prevArrow: '<span class="slick-prev">Previous</span>',
        nextArrow: '<span class="slick-next">Next</span>',
        adaptiveHeight: true,
        autoplay: true,
        speed: 2000,
        autoplaySpeed: 2000,
        fade: true,
        infinite: true, 
      });
    }

    // js masonry
    var $grid = $('.js-mas').imagesLoaded( function() {
      // init Masonry after all images have loaded
      $grid.masonry({
        itemSelector: '.masonry__item',
      });
    });

    //js form
    $('.wpcf7-quiz').attr('placeholder','To help prevent spam, please type the word ‘artistry’.');

    // js lightbox form
    if($('.js-lightbox-form').length) {
      $('.js-lightbox-form').click(function(event) {
        event.preventDefault();
        $('.is-lightbox-form').toggleClass('active');
        $('body').toggleClass('no-scroll');
      });
    }
    
    if($('.is-lightbox-form').length) {
      $('.is-lightbox-form').click(function(event) {
        if($(this).is(event.target)) {
          $(this).toggleClass('active');
          $('body').toggleClass('no-scroll');
        }
      });

      $('.lightbox-form__icon').click(function (event) {
        $(this).parents('.is-lightbox-form').toggleClass('active');
        $('body').toggleClass('no-scroll');
      });
    }

    // add class to li element in menu wordpress
    $('.menu-item').mouseenter(function(event) {
      $(this).parent().addClass('active');
    });

    $('.menu-item-has-children').mouseleave(function(event) {
      $(this).parent().removeClass('active');
    });

    $('.menu-item').mouseleave(function(event) {
      $(this).parent().removeClass('active');
    });

    if($('.js-video').length) {
      $('.js-video').click(function(event) {
        if ($(this).children()[0].paused) {
          $(this).removeClass('paused');
          $(this).children()[0].play();
          
        } else {
          $(this).addClass('paused');
          $(this).children()[0].pause();
        }
      });
    }

    // js slide product paged
    if($('.js-slide-product-paged').length) {
      $('.js-slide-product-paged').slick({
        prevArrow: '<span class="slick-prev">Previous</span>',
        nextArrow: '<span class="slick-next">Next</span>',
        adaptiveHeight: true,
      }).on('setPosition', function (event, slick) {
        $('.box-gallery__item').each(function(index, el) {
          if(!$(this).hasClass('height-large')) {
            $height = $(this).find('img').height();
            return false;
          }
        });

        $('.box-gallery__item').each(function(index, el) {
          $(this).css('height', $height + 'px');
        });
      });
    }

    // js slide product default
    if($('.js-slide-product').length) {
      $('.js-slide-product').slick({
        prevArrow: '<span class="slick-prev">Previous</span>',
        nextArrow: '<span class="slick-next">Next</span>',
        dots: true,
      })
      .on('setPosition', function (event, slick) {
        $('.box-gallery__item').each(function(index, el) {
          if(!$(this).hasClass('height-large')) {
            $height = $(this).find('img').height();
            return false;
          }
        });

        $('.box-gallery__item').each(function(index, el) {
          $(this).css('height', $height + 'px');;
        });
      });
    }

    $(window).load(function() {
      if ($('.js-scroll-down').length) {
        $('.js-scroll-down').addClass('run');
      }
    });

    if ($('.share-custom').length) {
      $('.share-custom').click(function (e) {
        e.preventDefault();
        $(".st-btn[data-network='sharethis']").trigger('click');
      });
    }
  });
})(this, this.document, this.jQuery);
