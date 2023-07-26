jQuery(function($) {
    "use strict";
    $(document).ready(function() {
        "use strict";
        $('#aniimated-thumbnials').lightGallery({
            thumbnail: true,
        });
        $('.slider-for').slick({
            rtl: rtl,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            fade: true,
            adaptiveHeight: true,
            asNavFor: '.slider-nav'
        });
        $('.slider-nav').slick({
            rtl: rtl,
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            dots: false,
            arrows: true,
            focusOnSelect: true,
            variableWidth: true,
            responsive: [{
                breakpoint: 1099,
                settings: {
                    slidesToShow: 4,
                }
            }, {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                }
            }, {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                }
            }]
        });
        $('.recommend').slick({
            rtl: rtl,
            slidesToShow: 2,
            slidesToScroll: 1,
            arrows: true,
            fade: false,
            responsive: [{
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                }
            }]
        });
    });
    // handle links with @href started with '#' only
    $(document).on('click', 'a[href^="#"]', function(e) {
        // target element id
        var id = $(this).attr('href');

        // target element
        var $id = $(id);
        if ($id.length === 0) {
            return;
        }

        // prevent standard hash navigation (avoid blinking in IE)
        e.preventDefault();

        // top position relative to the document
        var pos = $id.offset().top-65;

        // animated top scrolling
        $('body, html').animate({scrollTop: pos});
    });
});