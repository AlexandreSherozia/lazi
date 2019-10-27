jQuery(document).ready(function() {

    $('.m-menu__toggle').mouseover( function () {
        $('.m-menu__hor-arrow').show('fast');
        $('#ffcb-sub-menu').show('fast');
    });
    $('body').on('click', function () {
        $('.m-menu__hor-arrow').hide('fast');
        $('#ffcb-sub-menu').hide('fast');
    });

});