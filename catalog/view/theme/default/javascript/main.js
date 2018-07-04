jQuery(document).ready(function($) {
	$("[href]").each(function() {
        this.href == window.location.href && $(this).parent().addClass("active")
    })

	// ===== Scroll to Top ==== 
	$(window).scroll(function() {
	    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
	        $('#return-to-top').fadeIn(200);    // Fade in the arrow
	    } else {
	        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
	    }
	});
	$('#return-to-top').click(function() {      // When arrow is clicked
	    $('body,html').animate({
	        scrollTop : 0                       // Scroll to top of body
	    }, 500);
	});
	// WRAP BLOCK WORKING PROCRESS.
	$(".widget-working-process .content-item").wrapInner('<div class="content-wrapper"></div>');
	
	// Project Carousel.
	$('.widget-project .post-layout-carousel').addClass('owl-carousel owl-theme');
	$('.widget-project .post-layout-carousel').owlCarousel({
	    // loop:true,
	    autoplay: 3000,
	    lazyLoad:true,
	    margin:0,
	    responsiveClass:true,
	    responsive:{
	        0:{
	            items:1,
	            nav:true,
	            loop:true,
	        },
	        600:{
	            items:3,
	            nav:true,
	            loop:true,
	            dots: true,
	        },
	        1000:{
	            items:3,
	            nav:true,
	            loop:true,
	            dots: true,
	        }
	    },
	    navText: ['<img src="catalog/view/theme/default/stylesheet/images/nav_left.png" />',
	    			'<img src="catalog/view/theme/default/stylesheet/images/nav_right.png" />']
	});

	// Project Carousel.
	$('.widget-project-testimonial .testimonials-layout-carousel').addClass('owl-carousel owl-theme');
	$('.widget-project-testimonial .testimonials-layout-carousel').owlCarousel({
	    // loop:true,
	    autoplay: 3000,
	    lazyLoad:true,
	    margin:0,
	    responsiveClass:true,
	    responsive:{
	        0:{
	            items:1,
	            nav:true,
	            loop:true,
	        },
	        600:{
	            items:1,
	            nav:true,
	            loop:true,
	            dots: true,
	        },
	        1000:{
	            items:1,
	            nav:true,
	            loop:true,
	            dots: true,
	        }
	    },
	    navText: ['<img src="catalog/view/theme/default/stylesheet/images/nav_left.png" />',
	    			'<img src="catalog/view/theme/default/stylesheet/images/nav_right.png" />']
	});

	
	// Project Carousel.
	$('.widget-founder-message .testimonials-layout-carousel').addClass('owl-carousel owl-theme');
	$('.widget-founder-message .testimonials-layout-carousel').owlCarousel({
	    items: 1,
	    loop:true,
	    autoplay: 3000,
	    lazyLoad:true,
	    animateOut: 'fadeOut',
    	animateIn: 'fadeIn',
	    nav: true,
	    dots: true,
	    navText: ['<img src="catalog/view/theme/default/stylesheet/images/nav_left.png" />',
	    			'<img src="catalog/view/theme/default/stylesheet/images/nav_right.png" />']
	});

	// WOW JS
	if ( $("body.common-home").length > 0 ) {
		var wow = new WOW({
		    boxClass:     'wow',      // animated element css class (default is wow)
		    animateClass: 'animated', // animation css class (default is animated)
		    offset:       0,          // distance to the element when triggering the animation (default is 0)
		    mobile:       true,       // trigger animations on mobile devices (default is true)
		    live:         true,       // act on asynchronously loaded content (default is true)
		    callback:     function(box) {
		      // the callback is fired every time an animation is started
		      // the argument that is passed in is the DOM node being animated
		    },
		    scrollContainer: null,    // optional scroll container selector, otherwise use window,
		    resetAnimation: true,     // reset animation on end (default is true)
		  }
		);
		wow.init();
	}
});