"use strict";

$(window).on('load', function() {
    //===== Preloader
    $('.preloader').delay(500).fadeOut('500');

    //===== Popup
    if ($('.popup-wrapper').length > 0) {
        let $firstPopup = $('.popup-wrapper').eq(0);

        appearPopup($firstPopup);
    }

    // scroll to bottom
    if ($('.message-list').length > 0) {
        $('.message-list')[0].scrollTop = $('.message-list')[0].scrollHeight;
    }
});

function appearPopup($this) {
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
                items: {
                    src: '#' + $this.attr('id')
                },
                type: 'inline',
                callbacks: {
                    afterClose: function() {
                        // after the popup is closed, store it in the sessionStorage & show next popup
                        closedPopups.push($this.data('popup_id'));
                        sessionStorage.setItem('closedPopups', JSON.stringify(closedPopups));

                        if ($this.next('.popup-wrapper').length > 0) {
                            appearPopup($this.next('.popup-wrapper'));
                        }
                    }
                }
            }, 0);
        }, popupDelay);
    } else {
        if ($this.next('.popup-wrapper').length > 0) {
            appearPopup($this.next('.popup-wrapper'));
        }
    }
}

$(function($) {

    //===== 01. Main Menu
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
            if ($(this).next().length > 0) {
                $(this)
                    .parent('li')
                    .append(
                        '<span class="dd-trigger"><i class="fas fa-angle-down"></i></span>'
                    );
            }
        });
        // expands the dropdown menu on each click
        navMenu.find('li .dd-trigger').on('click', function(e) {
            e.preventDefault();
            $(this)
                .parent('li')
                .children('ul')
                .stop(true, true)
                .slideToggle(350);
            $(this).parent('li').toggleClass('active');
        });

        // check browser width in real-time
        function breakpointCheck() {
            var windoWidth = window.innerWidth;

            if (windoWidth <= 1199) {
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
    mainMenu();

    //===== Sticky
    $(window).on('scroll', function(event) {
        var scroll = $(window).scrollTop();

        if (scroll < 100) {
            $(".header-navigation").removeClass("sticky");
        } else {
            $(".header-navigation").addClass("sticky");
        }
    });


    //===== Back to Top
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > 600) {
            $('.back-to-top').fadeIn(500);
        } else {
            $('.back-to-top').fadeOut(500);
        }
    });


    //===== Animate The Scroll to Top
    $('.back-to-top').on('click', function(event) {
        event.preventDefault();

        $('html, body').animate({
            scrollTop: 0,
        }, 1500);
    });


    //====== Magnific Popup
    $('.video-popup').magnificPopup({
        type: 'iframe'
    });

    $('.service-slider-image').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    $('.image-popup').magnificPopup({
        type: 'image',
        gallery: {
            enabled: true
        }
    });

    // nice select
    $('select.wide').niceSelect();

    // Read more toggle button
    $(".read-more-btn").on("click", function () {
      $(this).prev().toggleClass('show');

      if ($(this).prev().hasClass("show")) {
          $(this).text(readLess);
      } else {
          $(this).text(readMore);
      }
  })

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
            dots: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            rtl: langDir == 1 ? true : false
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
      prevArrow: '<div class="prev"><i class="far fa-chevron-left"></i></div>',
      nextArrow: '<div class="next"><i class="far fa-chevron-right"></i></div>',
      Speed: 1500,
      slidesToScroll: 1,
      slidesToShow: 5,
      rtl: langDir == 1 ? true : false,
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
          }
      ]
    });
    $('.testimonial-slider-one').slick({
      dots: false,
      arrows: false,
      infinite: true,
      autoplay: false,
      Speed: 1500,
      slidesToShow: 2,
      slidesToScroll: 1,
      rtl: langDir == 1 ? true : false,
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
        rtl: langDir == 1 ? true : false
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
        rtl: langDir == 1 ? true : false
    });
    $('.client-logo-two-active').slick({
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        autoplaySpeed: 1500,
        slidesToShow: 4,
        slidesToScroll: 1,
        rtl: langDir == 1 ? true : false,
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
        }]
    });
    $('.sponsor-slider-one').slick({
        dots: false,
        arrows: false,
        infinite: true,
        autoplay: true,
        Speed: 1500,
        slidesToShow: 5,
        slidesToScroll: 1,
        rtl: langDir == 1 ? true : false,
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
        rtl: langDir == 1 ? true : false,
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
        rtl: langDir == 1 ? true : false,
        responsive: [{
            breakpoint: 767,
            settings: {
                slidesToShow: 3
            }
        }]
    });

    // lazy load init
    new LazyLoad({});

    // search post by category
    $('.blog-category').on('click', function(e) {
        e.preventDefault();

        let value = $(this).data('category_slug');

        $('#categoryKey').val(value);
        $('#submitBtn').trigger('click');
    });

    // disqus init
    if (typeof shortName !== 'undefined') {
        let d = document,
            s = d.createElement('script');
        s.src = `https://${shortName}.disqus.com/embed.js`;
        s.setAttribute('data-timestamp', +new Date());
        (d.head || d.body).appendChild(s);
    }

    // datepicker init
    $('.datepicker').datepicker({
        autoclose: true
    });

    // timepicker init
    $('.timepicker').timepicker();

    // initialize bootstrap dataTable
    var dataTable = function() {
      var userDataTable = $("#user-datatable");

      if (userDataTable.length) {
        userDataTable.DataTable({
            // ordering: false,
        })
      }
    }
    $(document).ready(function() {
      dataTable()
  })

    // add user email for subscription
    $('.subscription-form').on('submit', function(event) {
        event.preventDefault();

        let formURL = $(this).attr('action');
        let formMethod = $(this).attr('method');

        let formData = new FormData($(this)[0]);

        $.ajax({
            url: formURL,
            method: formMethod,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('input[name="email_id"]').val('');

                toastr['success'](response.success);
            },
            error: function(errorData) {
                toastr['error'](errorData.responseJSON.error.email_id[0]);
            }
        });
    });

    // Shop Slick slider
    $('.product-item-slide').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        fade: true,
        asNavFor: '.product-details-slide-item ul',
        rtl: langDir == 1 ? true : false
    });

    $('.product-details-slide-item ul').slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        asNavFor: '.product-item-slide',
        dots: false,
        centerMode: true,
        arrows: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        centerPadding: '0',
        focusOnSelect: true,
        rtl: langDir == 1 ? true : false
    });

    $('.shop-item-slide').slick({
        dots: false,
        arrows: true,
        prevArrow: '<span class="prev"><i class="fas fa-arrow-left"></i></span>',
        nextArrow: '<span class="next"><i class="fas fa-arrow-right"></i></span>',
        infinite: true,
        autoplay: false,
        Speed: 1500,
        slidesToShow: 4,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1200,
                settings: {
                    slidesToShow: 4
                }
            },
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 991,
                settings: {
                    slidesToShow: 3
                }
            },
            {
                breakpoint: 768,
                settings: {
                    arrows: false,
                    slidesToShow: 1
                }
            }
        ],
        rtl: langDir == 1 ? true : false
    });

    // uploaded image preview
    $('.upload').on('change', function(event) {
        let file = event.target.files[0];
        let reader = new FileReader();

        reader.onload = function(e) {
            $('.user-photo').attr('src', e.target.result);
        };

        reader.readAsDataURL(file);
    });

    // floating whatsapp
    if (whatsappStatus == 1) {
        $('.whatsapp-btn').floatingWhatsApp({
            phone: whatsappNumber,
            popupMessage: whatsappPopupMessage,
            showPopup: whatsappPopupStatus == 1 ? true : false,
            headerTitle: whatsappHeaderTitle,
            position: 'right'
        });
    }

    // tinymce initialization
    $(".summernote").each(function(i) {
        tinymce.init({
            selector: '.summernote',
            plugins: 'autolink charmap emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
            tinycomments_mode: 'embedded',
            tinycomments_author: 'Author name',
            promotion: false,
            mergetags_list: [{
                    value: 'First.Name',
                    title: 'First Name'
                },
                {
                    value: 'Email',
                    title: 'Email'
                },
            ]
        });
    });

    // uploaded file progress bar and file name preview
    $('.custom-file-input').on('change', function(e) {
        let file = e.target.files[0];
        let fileName = e.target.files[0].name;

        let fd = new FormData();
        fd.append('attachment', file);

        $.ajax({
            xhr: function() {
                let xhr = new window.XMLHttpRequest();

                xhr.upload.addEventListener('progress', function(ele) {
                    if (ele.lengthComputable) {
                        let percentage = ((ele.loaded / ele.total) * 100);
                        $('.progress').removeClass('d-none');
                        $('.progress-bar').css('width', percentage + '%');
                        $('.progress-bar').html(Math.round(percentage) + '%');

                        if (Math.round(percentage) === 100) {
                            $('.progress-bar').addClass('bg-success');
                            $('#attachment-info').text(fileName);
                        }
                    }
                }, false);

                return xhr;
            },
            url: $(this).data('url'),
            method: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(res) {

            }
        });
    });

    // format date & time for announcement popup
    $('.offer-timer').each(function() {
        let $this = $(this);

        let date = new Date($this.data('end_date'));
        let year = parseInt(new Intl.DateTimeFormat('en', {
            year: 'numeric'
        }).format(date));
        let month = parseInt(new Intl.DateTimeFormat('en', {
            month: 'numeric'
        }).format(date));
        let day = parseInt(new Intl.DateTimeFormat('en', {
            day: '2-digit'
        }).format(date));

        let time = $this.data('end_time');
        time = time.split(':');
        let hour = parseInt(time[0]);
        let minute = parseInt(time[1]);

        $this.syotimer({
            year: year,
            month: month,
            day: day,
            hour: hour,
            minute: minute
        });
    });

    // count total view of an advertisement
    function adView(id) {
        let url = `${baseURL}/advertisement/${id}/count-view`;

        let data = {
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        };

        $.post(url, data, function(response) {
            if ('success' in response) {

            } else {

            }
        });
    }
});
