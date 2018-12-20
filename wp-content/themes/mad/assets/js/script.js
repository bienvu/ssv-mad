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
    // $('.js-scroll-down').click(function() {
    //   var $next = $(this).parent().parent().next().offset().top;
    //   $('html, body').animate({
    //     scrollTop: $next
    //   }, 'slow');
    // });
  });

}(this, this.document, this.jQuery));
