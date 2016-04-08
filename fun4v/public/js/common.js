jQuery.fn.reverse = function() {
    return this.pushStack(this.get().reverse());
};
var panel_arr = new Array();
$("#backToTopBtn").hide();
    // fade in #back-top
$(function () {
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('#backToTopBtn').fadeIn();
        } else {
            $('#backToTopBtn').fadeOut();
        }
    });

    // scroll body to 0px on click
    $('#backToTopBtn').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);
        return false;
    });




    $(document).keydown(function (evt) {
        if (evt.keyCode == 39) { // right arrow
            evt.preventDefault(); // prevents the usual scrolling behaviour
            var current = $(window).scrollTop();
            $('div.row').each(function(i, element){
                var thisTop = $(this).offset().top;
                if(current < thisTop-50) {
                    $.scrollTo(thisTop-50, 800);
                    return false;
                }

            });

        } else if (evt.keyCode == 37) { // left arrow
            evt.preventDefault(); // prevents the usual scrolling behaviour
            var current = $(window).scrollTop();
            $('div.row').reverse().each(function(i, element){
                var thisTop = $(this).offset().top;
                if(current > thisTop-50) {
                    $.scrollTo(thisTop-50, 800);
                    return false;
                }

            });
        }
    });

});

