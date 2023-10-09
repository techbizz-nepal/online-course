jQuery(document).ready(function ($) {
    // wow animation
    const courseListEl = $("#course-list")

    function wowAnimation() {
        wow = new WOW({
            boxClass: 'wow',      // default
            animateClass: 'animated', // default
            offset: 0,          // default
            mobile: true,       // default
            live: true        // default
        })
        wow.init();
    }

    //

    //Dropdown Menu
    function dropdownMenu() {

        jQuery('.stellarnav').stellarNav({
            theme: 'dark',
            breakpoint: 767,
            position: 'right'
        });

        //
        if ($(window).width() >= 992) {
            $('.navbar .menu-item-has-children, .navbar .dropdown').hover(function () {
                $(this).find('.sub-menu, .dropdown-menu').first().stop(true, true).delay(250).slideDown();

            }, function () {
                $(this).find('.sub-menu, .dropdown-menu').first().stop(true, true).delay(100).slideUp();

            });
        }
        $('.navbar .dropdown > a').click(function () {
            location.href = this.href;
        });
    }

    //
    function matchHeights() {
        var options = {
            byRow: false,
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        };
        $('.product__info, .support__info').matchHeight(options);
        $('.section-news .news__info').matchHeight(options);
    }

    //
    function mainSlider() {
        $('.hero__slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000,
            arrows: false,
            dots: false,
            fade: false,
            speed: 2500,
            cssEase: 'ease-in-out'

        });
        //

    }

    // img tags converted to svg

    function imgToSvg() {
        $("img.svg").each(function () {
            //console.log('gdg');
            var $img = $(this);
            var imgID = $img.attr("id");
            var imgClass = $img.attr("class");
            var imgURL = $img.attr("src");
            $.get(
                imgURL,
                function (data) {
                    // Get the SVG tag, ignore the rest
                    var $svg = $(data).find("svg");
                    // Add replaced image's ID to the new SVG
                    if (typeof imgID !== "undefined") {
                        $svg = $svg.attr("id", imgID);
                    }
                    // Add replaced image's classes to the new SVG
                    if (typeof imgClass !== "undefined") {
                        $svg = $svg.attr("class", imgClass + " replaced-svg");
                    }
                    // Remove any invalid XML tags as per http://validator.w3.org
                    $svg = $svg.removeAttr("xmlns:a");
                    // Replace image with new SVG
                    $img.replaceWith($svg);
                },
                "xml"
            );
        });
    }

    function conainerWidth() {
        jQuery(window).on("load resize", function (e) {
            if (jQuery('.hero-content').length > 0) {
                var $ = jQuery
                var fortalezaOffset = $('.navbar .container').offset().left;
                $('.hero-content').css({
                    'padding-left': fortalezaOffset
                });
            }
        });
    }

    function expandCourseListOnDesktop() {
        courseListEl.css({"columns": "3 6em", "width": "60em"})
    }

    // call functions
    wowAnimation();
    dropdownMenu();
    imgToSvg();
    matchHeights();
    mainSlider();
    conainerWidth();
    expandCourseListOnDesktop()
    $(window).on('resize', function () {
        let innerWidth = $(this).width()
        console.log(innerWidth)

        if (innerWidth <= 767) {
            courseListEl.css("all", "unset")
        }
        if (innerWidth <= 1160 && innerWidth > 890) {
            courseListEl.css({"width": "45em", "columns": "2 6em"})
        }
        if (innerWidth > 1160) {
            expandCourseListOnDesktop()
        }
    });
});






