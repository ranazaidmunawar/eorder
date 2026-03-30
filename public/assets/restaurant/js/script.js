!(function ($) {
    "use strict";

    // Preloader
    $("#preLoader").delay(1000).queue(function () {
        $(this).remove();
    });

    // Sticky Header
    $(window).on("scroll", function () {
        var header = $(".header-area");
        // If window scroll down .is-sticky class will added to header
        if ($(window).scrollTop() >= 100) {
            header.addClass("is-sticky");
        } else {
            header.removeClass("is-sticky");
        }
    });

    // Background Image
    var bgImage = function () {
        var bgImage = $(".bg-img")
        bgImage.each(function () {
            var el = $(this),
                src = el.attr("data-bg-image");

            el.css({
                "background-image": "url(" + src + ")",
                "background-size": "cover",
                "background-position": "center",
                "display": "block"
            });
        });
    }
    bgImage()

    // Mobile Menu
    var mobileMenu = function () {
        // Variables
        var mainNavbar = $(".main-navbar"),
            mobileNavbar = $(".mobile-menu"),
            cloneInto = $(".mobile-menu-wrapper"),
            cloneItem = $(".mobile-item"),
            menuToggler = $(".menu-toggler")

        menuToggler.on("click", function () {
            $(this).toggleClass("active");
            $("body").toggleClass("mobile-menu-active")
        })

        mainNavbar.find(cloneItem).clone(!0).appendTo(cloneInto);

        mobileNavbar.find("li").each(function (index) {
            var toggleBtn = $(this).children(".toggle")

            toggleBtn.on("click", function (e) {
                $(this)
                    .parent("li")
                    .children("ul")
                    .stop(true, true)
                    .slideToggle(350);
                $(this).parent("li").toggleClass("show");
            })
        })

        // check browser width in real-time
        var checkBreakpoint = function () {
            var winWidth = window.innerWidth;
            if (winWidth <= 1199) {
                mainNavbar.hide();
                mobileNavbar.show()
            } else {
                mainNavbar.show();
                mobileNavbar.hide()
            }
        }
        checkBreakpoint();

        $(window).on('resize', function () {
            checkBreakpoint();
        });
    }
    mobileMenu();

    // Sponsor Slider
    new Swiper(".sponsor-slider", {
        speed: 400,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 400px
            400: {
                slidesPerView: 2,
                spaceBetween: 10
            },
            // when window width is >= 640px
            768: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            // when window width is >= 640px
            1200: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        }
    });

    // User Slider
    new Swiper(".user-slider", {
        speed: 400,
        spaceBetween: 30,
        loop: true,
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        breakpoints: {
            // when window width is >= 320px
            320: {
                slidesPerView: 1,
                spaceBetween: 20
            },
            // when window width is >= 576px
            576: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            // when window width is >= 640px
            992: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });

    // Testimonial Slider
    var testimonialSlider = new Swiper(".testimonial-slider", {
        spaceBetween: 15,
        slidesPerView: 1,
        autoHeight: true,
        grabCursor: true,
        // Pagination bullets
        pagination: {
            el: "#testimonial-slider-pagination",
            clickable: true,
        },

        on: {
            init: function(el) {
                var pagination = $('#testimonial-slider-pagination'),
                    paginationLength = $('#testimonial-slider-pagination span'),
                    currentSlide = 1,
                    totalSlide = paginationLength.length.toString().padStart(2, '0')

                pagination.attr('data-min', '0'+ currentSlide);
                pagination.attr('data-max', totalSlide)
                // var countMin = $(".count-min"),
                //     countMax = $(".count-max");

                // countMin.text('0' + currentSlide)
                // countMax.text('0' + paginationLength.length)

                // var pagination = $('#testimonial-slider-pagination'),
                //     paginationLength = $('#testimonial-slider-pagination span'),
                //     countDiv1 = '<div class="count count-min"></div>',
                //     countDiv2 = '<div class="count count-max"></div>',
                //     currentSlide = 1;
                
                // $(countDiv1).insertBefore(pagination)
                // $(countDiv2).insertAfter(pagination)

                
                // var countMin = $(".count-min"),
                //     countMax = $(".count-max");

                // countMin.text('0' + currentSlide)
                // countMax.text('0' + paginationLength.length)
            }
        }
    });

    // Youtube Popup
    $(".youtube-popup").magnificPopup({
        disableOn: 300,
        type: "iframe",
        mainClass: "mfp-fade",
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    })

    // Go to Top
    $(window).on("scroll", function () {
        // If window scroll down .active class will added to go-top
        var goTop = $(".go-top");
        if ($(window).scrollTop() >= 200) {
            goTop.addClass("active");
        } else {
            goTop.removeClass("active")
        }
    })
    $(".go-top").on("click", function (e) {
        $("html, body").animate({
            scrollTop: 0,
        }, 0);
    });

    // Lazy-load Image
    function lazyLoad() {
        window.lazySizesConfig = window.lazySizesConfig || {};
        window.lazySizesConfig.loadMode = 2;
        lazySizesConfig.preloadAfterLoad = true;
    }

    // AOS Init
    AOS.init({
        easing: "ease",
        duration: 1000,
        once: true,
        offset: 60,
        disable: 'mobile'
    });

    // Pricing list toggle
    $(".pricing-list").each(function(i) {
        const list = $(this).children();
        if (list.length > 10) {
            this.insertAdjacentHTML('afterEnd', '<span class="show-more">' + showmore + ' +</span>');
            const showLink = $(this).next(".show-more");
            list.slice(10).toggle(300);
            showLink.on("click", function() {
                list.slice(10).toggle(300);
                showLink.html(showLink.html() === showless + " -" ? showmore + "+" : showless + " -")
            })
            
        }
    })


    // Nice Select
    $(".select").niceSelect();

    var selectList = $(".nice-select .list")
    $(".nice-select .list").each(function () {
        var list = $(this).children();
        if (list.length > 5) {
            $(this).css({
                "height": "160px",
                "overflow-y": "scroll"
            })
        }
    })

    // Magic Cursor
    var cursor = function () {
        // Variables Declaration
        var cursor = $('.cursor');
        if (window.innerWidth > 1199) {
            // Adding cursor effect
            $(window).on('mousemove', function (e) {
                cursor.css({
                    'transform': "translate(" + e.clientX + "px," + e.clientY + "px)"
                })
            })
            // Add hover class
            $('a, button, .cursor-pointer').on('mouseenter', function () {
                cursor.addClass('hover');
            })
            // Remove hover class
            $('a, button, .cursor-pointer').on('mouseleave', function () {
                cursor.removeClass('hover');
            })
        } else {
            cursor.remove();
        }
    }

    $(document).ready(function () {
        lazyLoad()
        cursor()
    })

})(jQuery);
