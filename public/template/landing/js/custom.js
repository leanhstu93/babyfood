$(document).ready(function () {

var clickEvent = false;
	$('#myCarousel').carousel({
		interval:   4000	
	}).on('click', '.list-group li', function() {
			clickEvent = true;
			$('.list-group li').removeClass('active');
			$(this).addClass('active');		
	}).on('slid.bs.carousel', function(e) {
		if(!clickEvent) {
			var count = $('.list-group').children().length -1;
			var current = $('.list-group li.active');
			current.removeClass('active').next().addClass('active');
			var id = parseInt(current.data('slide-to'));
			if(count == id) {
				$('.list-group li').first().addClass('active');	
			}
		}
		clickEvent = false;
	});
	
$(window).load(function() {
    var boxheight = $('#myCarousel .carousel-inner').innerHeight();
    var itemlength = $('#myCarousel .item').length;
    var triggerheight = Math.round(boxheight/itemlength+1);
	$('#myCarousel .list-group-item').outerHeight(triggerheight);
});

wow = new WOW({
	boxClass:     'wow',      // default
	animateClass: 'animated', // default
	offset:       0,          // default
	mobile:       true,       // default
	live:         true        // default
	}
)
wow.init();


  $("#owl-carousel").owlCarousel({
    items : 3,
    lazyLoad : true,
    navigation : true,
	pagination: false,
	itemsDesktop : [1199, 2],
	itemsDesktopSmall : [979, 2],
	itemsTablet : [768, 1],
	itemsTabletSmall : false,
	itemsMobile : [479, 1],
	autoPlay: false
  }); 
  
  $("#owl-carousel-1").owlCarousel({
    items : 5,
    lazyLoad : true,
    navigation : true,
	pagination: false,
	itemsDesktopSmall : [979, 3],
	itemsTablet : [768, 2],
	itemsTabletSmall : false,
	itemsMobile : [479, 1],
	autoPlay: false
  }); 
  

	
  // nav
  
  
if($(window).width()>769){
        $('.navbar .dropdown').hover(function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(200).slideDown();

        }, function() {
            $(this).find('.dropdown-menu').first().stop(true, true).delay(100).slideUp();

        });

        $('.navbar .dropdown > a').click(function(){
            location.href = this.href;
        });

    } 
  
  
 // Top pages
  
     $(window).scroll(function () {
	if ($(this).scrollTop() > 50) {
			$('#back-to-top').fadeIn();
		} else {
		$('#back-to-top').fadeOut();
		}
	});
	// scroll body to 0px on click
	$('#back-to-top').click(function () {
		$('body,html').animate({
			scrollTop: 0
		}, 800);
		return false;
	});
		
  

});

