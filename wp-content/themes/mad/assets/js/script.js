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

    // js back on menu
    $('.js-back').children().click(function(event) {
      console.log()
      $(this).parents('.is-show').first().removeClass('is-show');
    });

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
    $(document).scroll(function(event) {
      setTimeout(function () {
        if($(this).scrollTop() > 80) {
          $('.js-footer').addClass('is-show');
        } else {
          $('.js-footer').removeClass('is-show');
        }
      }, 100)
    });

    // js slide
    $('.js-slide').slick({
      prevArrow: '<span class="slick-prev">Previous</span>',
      nextArrow: '<span class="slick-next">Next</span>',
      adaptiveHeight: true
    });
    // js masonry
    $(window).load(function() {
      $('.js-masonry').masonry();
    });

    // js gallery
    if($('.js-lightbox-product').length) {
      $('.js-lightbox-product .slick-track').lightGallery({
        mode: 'lg-fade',
        download: false
      });
    }

  });
})(this, this.document, this.jQuery);
