$(function ($) {
  "use strict";

  if ($('.testimonial-three-active').length > 0) {
    $('.testimonial-two-active').slick({
      dots: true,
      arrows: false,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 1500,
      slidesToShow: 1,
      slidesToScroll: 1,
      rtl: langDir == 1 ? true : false
    });
  }

  if ($('.testimonial-three-active').length > 0) {
    $('.testimonial-three-active').slick({
      dots: true,
      arrows: false,
      infinite: false,
      autoplay: true,
      autoplaySpeed: 1500,
      slidesToShow: 1,
      rows: 2,
      slidesToScroll: 1,
      rtl: langDir == 1 ? true : false
    });
  }

  if ($('.client-logo-two-active').length > 0) {
    $('.client-logo-two-active').slick({
      dots: false,
      arrows: false,
      infinite: true,
      autoplay: true,
      autoplaySpeed: 1500,
      slidesToShow: 4,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 3
          }
        },
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 2
          }
        }
      ],
      rtl: langDir == 1 ? true : false
    });
  }

});
