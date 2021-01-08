jQuery(document).ready(function($){

    var sideNavMenu = $(".entry-content").height();
    if (sideNavMenu > 1500)
    {
        $('.entry-content').addClass('active-lit');
        $('.entry-content').after('<a class="button more-cont-x">READ MORE</a>');
    }
    $('.more-cont-x').click(function(){
        $('.entry-content').removeClass('active-lit');
        $(this).hide();
    });
    $('#categories-2, #gform_widget-2').wrapAll('<div class="moboleft-bar"></div>');
    $(window).scroll(function() {
        if (jQuery(this).scrollTop() > 100) {
            $('.topicon').fadeIn();
        } else {
            $('.topicon').fadeOut();
        }
      });
      $('.topicon').on('click', function(e) {
        e.preventDefault();
        $('html, body').animate({scrollTop : 0}, 800);
      });
});