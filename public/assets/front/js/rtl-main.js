/*-----------------------------------------------------------
 * Template Name    : Prohire - Service Selling Freelancer Marketplace HTML Template
 * Author           : KreativDev
 * File Description : This file contains the JavaScript for the actual template, this
					  is the file you need to edit to change the functionality of the
					  template.
 *------------------------------------------------------------
*/
!(function($) {
	"use strict";

	// Main Menu
	function mainMenu() {
		// Variables
		var var_window = $(window),
			navContainer = $('.header-navigation'),
			navbarToggler = $('.navbar-toggler'),
			navMenu = $('.nav-menu'),
			navMenuLi = $('.nav-menu ul li ul li'),
			closeIcon = $('.navbar-close');
		// navbar toggler
		navbarToggler.on('click', function() {
			navbarToggler.toggleClass('active');
			navMenu.toggleClass('menu-on');
		});
		// close icon
		closeIcon.on('click', function() {
			navMenu.removeClass('menu-on');
			navbarToggler.removeClass('active');
		});
		// adds toggle button to li items that have children
		navMenu.find('li a').each(function() {
			if($(this).next().length > 0) {
				$(this).parent('li').append('<span class="dd-trigger"><i class="fas fa-angle-down"></i></span>');
			}
		});
		// expands the dropdown menu on each click
		navMenu.find('li .dd-trigger').on('click', function(e) {
			e.preventDefault();
			$(this).parent('li').children('ul').stop(true, true).slideToggle(350);
			$(this).parent('li').toggleClass('active');
		});
		// check browser width in real-time
		function breakpointCheck() {
			var windoWidth = window.innerWidth;
			if(windoWidth <= 1199) {
				navContainer.addClass('breakpoint-on');
			} else {
				navContainer.removeClass('breakpoint-on');
			}
		}
		breakpointCheck();
		var_window.on('resize', function() {
			breakpointCheck();
		});
	};

	// Document Ready
	$(document).ready(function() {
		mainMenu();
	});

	// Active nav
	var a = $(".main-menu .menu-item a"),
        c = window.location;

    for (var i = 0; i < a.length; i++) {
        const el = a[i];

        if (el.href == c) {
            el.classList.add("active");
        }
    }

    // Image to bg-img
    var bgImage = $(".bg-img")
    bgImage.each(function() {
        var el = $(this),
            src = el.attr("data-bg-img");

        el.css({
            "background-image": "url(" + src + ")",
            "background-repeat": "no-repeat"
        });
    });

	// Prealoder
	$(window).on('load', function(event) {
        $('.preloader').delay(500).fadeOut('500');
    })

	// Sticky
	$(window).on('scroll', function(event) {
		var scroll = $(window).scrollTop();
		if(scroll < 100) {
			$(".header-navigation").removeClass("sticky");
		} else {
			$(".header-navigation").addClass("sticky");
		}
	});

	// Back to top
	$(window).on('scroll', function(event) {
		if($(this).scrollTop() > 600) {
			$('.back-to-top').fadeIn(200)
		} else {
			$('.back-to-top').fadeOut(200)
		}
	});

	//Animate the scroll to top
	$('.back-to-top').on('click', function(event) {
		event.preventDefault();
		$('html, body').animate({
			scrollTop: 0,
		}, 1500);
	});

	// Magnific Popup
	$('.video-popup').magnificPopup({
		type: 'iframe'
			// other options
	});
	$(".gallery-single").magnificPopup({
		type: "image",
		gallery: {
			enabled: true
		}
	});

	// jquery nice select js
	$('select').niceSelect();
    
	// Slick Slider
	function heroSlider() {
		var BasicSlider = $('.hero-content-slider');
		BasicSlider.on('init', function(e, slick) {
			var $firstAnimatingElements = $('.single-slider:first-child').find('[data-animation]');
			doAnimations($firstAnimatingElements);
		});
		BasicSlider.on('beforeChange', function(e, slick, currentSlide, nextSlide) {
			var $animatingElements = $('.single-slider[data-slick-index="' + nextSlide + '"]').find('[data-animation]');
			doAnimations($animatingElements);
		});
		BasicSlider.slick({
			autoplay: true,
			Speed: 2000,
			infinite: true,
			arrows: false,
			fade: true,
            rtl: true,
			dots: false,
			slidesToShow: 1,
			slidesToScroll: 1
		});

		function doAnimations(elements) {
			var animationEndEvents = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
			elements.each(function() {
				var $this = $(this);
				var $animationDelay = $this.data('delay');
				var $animationType = 'animated ' + $this.data('animation');
				$this.css({
					'animation-delay': $animationDelay,
					'-webkit-animation-delay': $animationDelay
				});
				$this.addClass($animationType).one(animationEndEvents, function() {
					$this.removeClass($animationType);
				});
			});
		}
	}
	heroSlider();
	$('.categories-slider-one').slick({
		dots: false,
		arrows: true,
		infinite: true,
		autoplay: false,
        rtl: true,
		prevArrow: '<div class="prev"><i class="far fa-chevron-left"></i></div>',
		nextArrow: '<div class="next"><i class="far fa-chevron-right"></i></div>',
		Speed: 1500,
		slidesToShow: 5,
		slidesToScroll: 1,
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 4
			}
		}, {
			breakpoint: 1024,
			settings: {
				slidesToShow: 3
			}
		}, {
			breakpoint: 991,
			settings: {
				slidesToShow: 2
			}
		},
		{
			breakpoint: 768,
			settings: {
				arrows: false,
				slidesToShow: 2
			}
		},
		{
			breakpoint: 575,
			settings: {
				arrows: false,
				slidesToShow: 1
			}
		}]
	});
	$('.testimonial-slider-one').slick({
		dots: false,
		arrows: false,
		infinite: true,
		autoplay: false,
        rtl: true,
		Speed: 1500,
		slidesToShow: 2,
		slidesToScroll: 1,
		responsive: [{
			breakpoint: 768,
			settings: {
				slidesToShow: 1
			}
		}]
	});
	$('.testimonial-two-active').slick({
		dots: true,
		arrows: false,
		infinite: true,
		autoplay: true,
		autoplaySpeed: 1500,
		slidesToShow: 1,
		slidesToScroll: 1,
        rtl: true,
	});
	$('.testimonial-three-active').slick({
		dots: true,
		arrows: false,
		infinite: false,
		autoplay: true,
		autoplaySpeed: 1500,
		slidesToShow: 1,
		rows: 2,
		slidesToScroll: 1,
        rtl: true,
	});
	$('.client-logo-two-active').slick({
		dots: false,
		arrows: false,
		infinite: true,
		autoplay: true,
		autoplaySpeed: 1500,
		slidesToShow: 4,
		slidesToScroll: 1,
        rtl: true,
		responsive: [{
			breakpoint: 991,
			settings: {
				slidesToShow: 3
			}
		}, {
			breakpoint: 768,
			settings: {
				slidesToShow: 2
			}
		}, {
			breakpoint: 575,
			settings: {
				slidesToShow: 1
			}
		}],
	});
	$('.sponsor-slider-one').slick({
		dots: false,
		arrows: false,
		infinite: true,
		autoplay: true,
		Speed: 1500,
		slidesToShow: 5,
		slidesToScroll: 1,
        rtl: true,
		responsive: [{
			breakpoint: 1200,
			settings: {
				slidesToShow: 4
			}
		}, {
			breakpoint: 1024,
			settings: {
				slidesToShow: 3
			}
		}, {
			breakpoint: 768,
			settings: {
				slidesToShow: 2
			}
		}, {
			breakpoint: 480,
			settings: {
				slidesToShow: 1
			}
		}]
	});
	$('.gigs-big-slider').slick({
		dots: false,
		arrows: true,
		infinite: true,
		autoplaySpeed: 1500,
		asNavFor: '.gigs-thumbs-slider',
		slidesToShow: 1,
		slidesToScroll: 1,
        rtl: true,
		prevArrow: '<div class="prev"><i class="far fa-angle-left"></i></div>',
		nextArrow: '<div class="next"><i class="far fa-angle-right"></i></div>',
		responsive: [{
			breakpoint: 768,
			settings: {
				arrows: false
			}
		}]
	});
	$('.gigs-thumbs-slider').slick({
		dots: false,
		arrows: false,
		infinite: true,
		autoplaySpeed: 1500,
		focusOnSelect: true,
		asNavFor: '.gigs-big-slider',
		slidesToShow: 5,
		slidesToScroll: 1,
        rtl: true,
		responsive: [{
			breakpoint: 767,
			settings: {
				slidesToShow: 3
			}
		}]
	});

	// Countdown timer
	function makeTimer() {
        var endTime = new Date("May 20, 2024 17:00:00 PDT");
        var endTime = (Date.parse(endTime)) / 1000;
        var now = new Date();
        var now = (Date.parse(now) / 1000);
        var timeLeft = endTime - now;
        var days = Math.floor(timeLeft / 86400);
        var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
        var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600)) / 60);
        var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
        if (hours < "10") {
            hours = "0" + hours;
        }
        if (minutes < "10") {
            minutes = "0" + minutes;
        }
        if (seconds < "10") {
            seconds = "0" + seconds;
        }
        $("#days .time").html(days);
        $("#hours .time").html(hours);
        $("#minutes .time").html(minutes);
        $("#seconds .time").html(seconds);
    }
    setInterval(function() {
        makeTimer()
    }, 0);

	// Product Quantity
	$("#slider-range").slider({
		range: true,
		min: 0,
		max: 1000,
		values: [200, 800],
		slide: function(event, ui) {
			$("#amount").val("$" + ui.values[0] + " - $" + ui.values[1]);
		}
	});
	$("#amount").val("$" + $("#slider-range").slider("values", 0) + " - $" + $("#slider-range").slider("values", 1));
})(jQuery);