<!-- Swiper -->
  <div id="layers-widget-slider-<?php echo $settings['banner_id'] ?>" class="banner-id-<?php echo $settings['banner_id'] ?> swiper-container widget layers-slider-widget row slide swiper-container auto-height not-full-screen swiper-container-horizontal" style="height: <?php echo $settings['height'] ?>px">
     <div class="swiper-wrapper">
        <?php if( !empty($banners) ) { ?>
            <?php foreach ( $banners as $banner ) { ?>
                <div class="swiper-slide" style="background-image: url(<?php echo $banner['image'] ?>); background-position: center center; background-size: cover; height: <?php echo $settings['height'] ?>px">
                   <div class="overlay content">
                      <div class="container clearfix">
                         <h3 class="heading-title">CHUYÊN GIA TRONG XỬ LÝ MÔI TRƯỜNG</h3>
                         <div class="excerpt text-center">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.</p>
                         </div>
                         <a class="btn btn-default text-center">XEM THÊM</a>
                      </div>
                   </div>
                </div>
            <?php } ?>
        <?php } ?>
     </div>
     <!-- Add Pagination -->
     <div class="swiper-pagination"></div>
     <!-- Add Arrows -->
     <div class="swiper-button-next"></div>
     <div class="swiper-button-prev"></div>
  </div>
  <!-- Initialize Swiper -->
<script type="text/javascript">
var swiper = new Swiper('#layers-widget-slider-<?php echo $settings['banner_id'] ?>', {
        slidesPerView: 1,
        spaceBetween: 30,
        loop: true,
        pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
});
</script>