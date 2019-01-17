/*jslint browser: true*/
/*global $, jQuery, Modernizr, enquire*/
(function (window, document, $) {
  var $html = $('html'),
    mobileOnly = "screen and (max-width:47.9375em)", // 767px.
    mobileLandscape = "(min-width:30em)", // 480px.
    tablet = "(min-width:48em)"; // 768px.
  // Contact form 7 redirect after submit.
  // document.addEventListener( 'wpcf7mailsent', function( event ) {
  //   if ( '5' == event.detail.contactFormId ) {
  //       window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you-subscribe/';
  //   }else if('204' == event.detail.contactFormId){
  //       window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you-contact/';
  //   }else if('210' == event.detail.contactFormId) {
  //       window.location.href = window.location.protocol + '//' + window.location.hostname + '/thank-you-request/';
  //   }
  // }, false );

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

    // js height box gallery
    if($('.js-height').length) {
      $height = $('.js-height').width() * 1320 / 2000;console.log($('.js-height').width());
      $('.js-height').css('property', 'value');
    }

    //scroll to next section
    $('.js-scroll-down').click(function() {
      var $next = $(this).parent().next().offset().top;
      $('html, body').animate({
        scrollTop: $next
      }, 'slow');
    });
    
    // js header, sticky appear from 40px
    if($('.js-header').length) {
      if($('.js-header').offset().top >= 40) {
        // $('.js-header').addClass('is-sticky');
      }
    }

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
    $('li > a > i').click(function(event) {
      $(this).parent().next().addClass('is-show');
    });

    //js read more
    if($('.js-read-more').length) {
      $('.js-read-more').click(function(e) {
        e.preventDefault();
        if($(this).parent().parent().find('.read-more').hasClass('is-show')) {
          $(this).parent().parent().find('.read-more').removeClass('is-show');
          $(this).text('READ MORE');
        }else {
          $(this).parent().parent().find('.read-more').addClass('is-show');
          $(this).text('READ LESS');
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
            console.log('123');
          } else {
            $('.js-footer').removeClass('is-show');
          }

          $lastScrollTop = $st;
        }
      });
    }, 1000);


    // js pagingInfo for js-slider
    var $status = $('.paginginfo');
    var $slickElement = $('.js-pagination');

    $slickElement.on('init reInit afterChange', function (event, slick, currentSlide, nextSlide) {
      //currentSlide is undefined on init -- set it to 0 in this case (currentSlide is 0 based)
      var i = (currentSlide ? currentSlide : 0) + 1;
      $status.html('<span>' + i + '</span>/' + slick.slideCount);
    });

    // js slide
    if($('.js-slide').length) {
      $('.js-slide').slick({
        prevArrow: '<span class="slick-prev">Previous</span>',
        nextArrow: '<span class="slick-next">Next</span>',
        adaptiveHeight: true,
      });
    }
    
    // js masonry
    $(window).on("load", function() {
      $('.masonry').masonry({
        itemSelector: '.masonry__item',
        horizontalOrder: false
      });
    });


    // js gallery
    if($('.js-lightbox-product').length) {
      $('.js-lightbox-product .slick-track').lightGallery({
        mode: 'lg-fade',
        download: false
      });
    }

    //js form
    $('.wpcf7-quiz').attr('placeholder','To help prevent spam, please type the word ‘artistry’.');

    // js lightbox form
    if($('.js-lightbox-form').length) {
      $('.js-lightbox-form').click(function(event) {
        $('.is-lightbox-form').toggleClass('active');
        $('body').toggleClass('no-scroll');
      });
    }
    
    if($('.is-lightbox-form').length) {
      $('.is-lightbox-form').click(function(event) {
        if($(this).is(event.target)) {
          $(this).toggleClass('active');
        }
      });
    }

  });
})(this, this.document, this.jQuery);
