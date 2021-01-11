$(".ex-click").click(function () {
  $(this).siblings(".ex-slide").slideToggle("slow");
});
	
	
jQuery.colorbox.settings.maxWidth  = '95%';
jQuery.colorbox.settings.maxHeight = '95%';

var resizeTimer;

function resizeColorBox()
{
  if (resizeTimer) clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {
            if (jQuery('#cboxOverlay').is(':visible')) {
                      jQuery.colorbox.load(true);
            }
  }, 300);
}
jQuery(window).resize(resizeColorBox);
window.addEventListener("orientationchange", resizeColorBox, false);


$(document).ready(function(){

    $(function (){
		$("#back-top").hide();

		$(window).scroll(function (){
			if ($(this).scrollTop() > 300){
				$("#back-top").fadeIn();
			} else{
				$("#back-top").fadeOut();
			}
		});

		$("#back-top a").click(function (){
			$("body,html").animate({
				scrollTop:0
			}, 800);
			return false;
		});
	});

    $('#start').on('click', function() {
    	console.log('ok');
	})

});



$(window).scroll(function(){
    if ($(window).scrollTop() > 32) {
        $('.nav-bar').addClass('fix-top');
		$('.main-body').addClass('mrg-top');
    }
    else {
        $('.nav-bar').removeClass('fix-top');
		$('.main-body').removeClass('mrg-top');
    }
});

