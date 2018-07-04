/*
 * Lazyloader for FlexSlider 2
 * https://github.com/bmcgill/LazyLoader-for-FlexSlider
 */
(function ($) {

  flexsliderLazyloaderInit = function(slider) { // Fires when the slider loads the first slide
    // Add src attribtes to each image.
    // Otherwise, slides will not load correctly if you are using the pagination controls.
    $(slider).find('li img.lazy').attr('src',"");

    // If the slideshow autoplays, preload the next slide.
    if(slider.vars.slideshow) {
      var index = slider.currentSlide;

      if(index == slider.count-1) {
        nextSlide = 0;
      } else {
        nextSlide = index + 1;
      }

      flexsliderLazyloaderCheck([nextSlide], slider.slides);
    }
  }
  flexsliderLazyloaderLoad = function(slider) { // Fires with each slider animation
    var index = slider.animatingTo; // Flexslider variables

    if(index == slider.count-1) {
      nextSlide = 0;
    } else {
      nextSlide = index + 1;
    }

    if(index == 0) {
      prevSlide = slider.count-1;
    } else {
      prevSlide = index - 1;
    }

    // Load slide that was navigated to, plus the next and previous slides.
    flexsliderLazyloaderCheck([index, nextSlide, prevSlide], slider.slides);
  }

  flexsliderLazyloaderCheck = function(checkSlides, slides) {
    $.each(checkSlides, function(i, value) {
      var datasrc = $(slides[value]).find('img').attr('data-src');
      // Only set src if data-src is still set.
      // For some browsers, 'attr' is undefined; for others, 'attr' is false. Check for both.
      if (typeof datasrc !== typeof undefined && datasrc !== false) {
        $(slides[value]).find('img').attr('src', datasrc).removeAttr('data-src');
      }
    });
  }
})(jQuery);
