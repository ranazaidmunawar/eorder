"use strict";

function popupAnnouncement($this) {
    let closedPopups = [];
    if (sessionStorage.getItem('closedPopups')) {
        closedPopups = JSON.parse(sessionStorage.getItem('closedPopups'));
    }

    // if the popup is not in closedPopups Array
    if (closedPopups.indexOf($this.data('popup_id')) == -1) {
        $('#' + $this.attr('id')).show();
        let popupDelay = $this.data('popup_delay');

        setTimeout(function() {
            jQuery.magnificPopup.open({
                items: {src: '#' + $this.attr('id')},
                type: 'inline',
                callbacks: {
                    afterClose: function() {
                        // after the popup is closed, store it in the sessionStorage & show next popup
                        closedPopups.push($this.data('popup_id'));
                        sessionStorage.setItem('closedPopups', JSON.stringify(closedPopups));


                        if ($this.next('.popup-wrapper').length > 0) {
                            popupAnnouncement($this.next('.popup-wrapper'));
                        }
                    }
                }
            }, 0);
        }, popupDelay);
    } else {
        if ($this.next('.popup-wrapper').length > 0) {
            popupAnnouncement($this.next('.popup-wrapper'));
        }
    }
}
!(function($) {
    "use strict";

    // Preloader
    $("#preLoader").delay(1000).queue(function() {
        $(this).remove();
    });

    // Sticky Header
    $(window).on("scroll", function() {
        var header = $(".header-area");
        // If window scroll down .is-sticky class will added to header
        if($(window).scrollTop() >= 100) {
            header.addClass("is-sticky");
        } else {
            header.removeClass("is-sticky");
        }
    });

    // Mobile Menu
    var mobileMenu = function() {
        // Variables
        var mainNavbar = $(".main-navbar"),
        cloneInto = $(".mobile-menu-wrapper"),
        cloneItem = $(".mobile-item"),
        cloneBlank = "",
        menuToggler = $(".menu-toggler")

        menuToggler.on("click", function() {
            $(this).toggleClass("active");
            $("body").toggleClass("mobile-menu-active")
        })
        
        // check browser width in real-time
        var winWidth = window.innerWidth;
        if (winWidth <= 1199) {
            mainNavbar.find(cloneItem).clone(!0).appendTo(cloneInto);
            mainNavbar.hide();
        } else {
            cloneInto.html(cloneBlank);
            mainNavbar.show();
        }

        cloneInto.find("#mainMenu .toggle").on("click", function (e) {
			// e.preventDefault();
			$(this)
				.parent("li")
				.children("ul")
				.stop(true, true)
				.slideToggle(350);
			$(this).parent("li").toggleClass("show");
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

    // subscribe functionality
    if ($(".subscribeForm").length > 0) {
        $(".subscribeForm").each(function () {
            let $this = $(this);

            $this.on('submit', function (e) {

                e.preventDefault();

                let formId = $this.attr('id');
                let fd = new FormData(document.getElementById(formId));

                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if ((data.errors)) {
                            $this.find(".err-email").html(data.errors.email[0]);
                        } else {
                            toastr["success"]("You are subscribed successfully!");
                            $this.trigger('reset');
                            $this.find(".err-email").html('');
                        }
                    },
                  
                });
            });
        });
    } 

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
    new Swiper(".testimonial-slider", {
        spaceBetween: 15,
        slidesPerView: 1,
        autoHeight: true,
        // Pagination bullets
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        // Navigation arrows
        navigation: {
            nextEl: '.slider-btn-next',
            prevEl: '.slider-btn-prev',
        },
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
    $(window).on("scroll", function() {
        // If window scroll down .active class will added to go-top
        var goTop = $(".go-top");
        if($(window).scrollTop() >= 200) {
            goTop.addClass("active");
        } else {
            goTop.removeClass("active")
        }
    })
    $(".go-top").on("click", function(e) {
        $("html, body").animate({
            scrollTop: 0,
        }, 0 );
    });

    // Lazy-load Image
    function lazyLoad() {
        window.lazySizesConfig = window.lazySizesConfig || {};
        window.lazySizesConfig.loadMode = 2;
        lazySizesConfig.preloadAfterLoad = true;
    }

    // AOS Init
    AOS.init({
        easing: "ease-out",
        duration: 600
    });

    // Nice Select
    $("select").niceSelect();

    // Magic Cursor
    var cursor = function() {
        // Variables Declaration
        var cursor = $('.cursor');
        if (window.innerWidth > 1199) {
            // Adding cursor effect
            $(window).on('mousemove', function(e) {
                cursor.css({
                    'transform': "translate(" + e.clientX + "px," + e.clientY + "px)"
                })
            })
            // Add hover class
            $('a, button, .cursor-pointer').on('mouseenter', function() {
                cursor.addClass('hover');
            })
            // Remove hover class
            $('a, button, .cursor-pointer').on('mouseleave', function() {
                cursor.removeClass('hover');
            })
        } else {
            cursor.remove();
        }
    }
    
    $(document).ready(function() {
        lazyLoad()
        cursor()
    })

})(jQuery);

$(window).on('load', function(event) {
    if ($(".popup-wrapper").length > 0) {
        let $firstPopup = $(".popup-wrapper").eq(0);
        popupAnnouncement($firstPopup);
    }
    $('.preloader').fadeOut('500');
});
