jQuery(document).ready(function ($) {

    // Tab functionality for Woo Content Area.
    $('.sera-tabbed-container .tab-links li').click(function (event) {

        $('ul.tab-links li').removeClass('active');
        $('.tabbed').removeClass('active');

        var tabID = $(this).attr('data-tab');

        $(this).addClass('active');
        $('#' + tabID).addClass('active');

    });
});