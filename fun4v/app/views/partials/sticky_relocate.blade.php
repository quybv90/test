<script type="text/javascript">

	function sticky_relocate() {
	    var window_top = $(window).scrollTop();
	    var div_top = $('#sticky-anchor').offset().top;
	    if (window_top > div_top && window_top < ($(document).height() - 600)) {
	        $('#last-widget').addClass('stick');
	    } else {
	        $('#last-widget').removeClass('stick');
	    }
	}
	$(function () {
	    $(window).scroll(sticky_relocate);
	    sticky_relocate();
	});
	
</script>