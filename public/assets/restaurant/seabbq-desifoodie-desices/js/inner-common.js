(function ($) {
    "use strict";

    document.addEventListener('DOMContentLoaded', function () {
        // Toggle open
        document.querySelectorAll('[data-bs-toggle="offcanvas"]').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const selector = this.getAttribute('data-bs-target');
                const offcanvas = document.querySelector(selector);
                if (!offcanvas) return;

                const isShown = offcanvas.classList.contains('show');
                document.querySelectorAll('.offcanvas').forEach(el => el.classList.remove('show'));
                document.querySelectorAll('.offcanvas-backdrop').forEach(b => b.remove());

                if (!isShown) {
                    offcanvas.classList.add('show');
                    document.body.classList.add('offcanvas-open');

                    const backdrop = document.createElement('div');
                    backdrop.className = 'offcanvas-backdrop show';
                    document.body.appendChild(backdrop);

                    backdrop.addEventListener('click', () => {
                        offcanvas.classList.remove('show');
                        backdrop.remove();
                        document.body.classList.remove('offcanvas-open');
                    });
                }
            });
        });

        // Close
        document.querySelectorAll('[data-bs-dismiss="offcanvas"]').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const offcanvas = this.closest('.offcanvas');
                if (!offcanvas) return;
                offcanvas.classList.remove('show');
                const backdrop = document.querySelector('.offcanvas-backdrop');
                if (backdrop) backdrop.remove();
                document.body.classList.remove('offcanvas-open');
            });
        });
    });

    function lazyLoadBackground() {
        $(".bg-img").each(function () {
            var el = $(this);
            if (el.attr("data-bg-image") && el.is(":visible") && el.offset().top < $(window).scrollTop() + $(window).height()) {
                var src = el.attr("data-bg-image");
                el.css({
                    "background-image": "url(" + src + ")",
                }).removeAttr("data-bg-image");
            }
        });
    }
    lazyLoadBackground();
    $(window).on("scroll", lazyLoadBackground);

        $(document).ready(function () {
        $('.nice-select').niceSelect();
    });
})(jQuery);
