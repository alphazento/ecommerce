if (!("ontouchstart" in document.documentElement)) {
    document.documentElement.className += " no-touch";
}

if (!$('html').hasClass('no-touch')) {
    var $accountLink = $('.account-link');
    var $cartLink = $('.cart-link');
    $accountLink.children('.dropdown-toggle').attr('data-toggle', 'dropdown');
    $accountLink.children('.dropdown-menu').addClass('dropdown-menu-right');
    $cartLink.children('.dropdown-toggle').attr('data-toggle', 'dropdown');
    $cartLink.children('.dropdown-menu').addClass('dropdown-menu-right');

    $accountLink.bind('touchstart', function () {
        if($(this).find('.dropdown-menu').is(':hidden')) {
            $('.header-search-div').removeClass('active');
        }
    });

    $cartLink.bind('touchstart', function () {
        if($(this).find('.dropdown-menu').is(':hidden')){
            $('.header-search-div').removeClass('active');
        }
    });

    $('.header-search-div').bind('touchstart', function () {
        $(this).toggleClass('active');
    });

    $("#mobile-menu-btn").bind('touchstart', function(){
        $('body').toggleClass('mobile-menu-active');
    });

    $('.btn-close').bind('touchstart', function(){
        $(this).closest('.level0').toggleClass('mob-active');
    });
}

$(window).scroll(function() {
    var location = window.location.href;
    if(location.indexOf('checkout') === -1){
        var scroll = $(window).scrollTop();
        var width = $(window).width();
        if($("body").hasClass('modal-open')){
            return false;
        }
        if( width > 1024 ){
            if (scroll >= 168) {
                $("body").addClass("sticky-header");
            }else{
                $("body").removeClass("sticky-header");
            }
        }else if(width === 1024){
            if (scroll > 47) {
                $("body").addClass("sticky-header");
            }else{
                $("body").removeClass("sticky-header");
            }
        }else{
            if (scroll >= 33) {
                $("body").addClass("sticky-header");
            }else{
                $("body").removeClass("sticky-header");
            }
        }
    }
});

$(document).ready(function () {

    $(document).on('mouseover', '.header-search-form', function () {
        $('.header-search-div').addClass('active');
    });

    $(document).on('mouseout', '.header-search-form', function () {
        $('.header-search-div').removeClass('active');
    });

    var mobaccordion__head = $('.mobaccordion__head');
    mobaccordion__head.click(function(){
        var $this = $(this);
        $this.closest('.mobaccordion').toggleClass('mobaccordion--opened');
    })
});
