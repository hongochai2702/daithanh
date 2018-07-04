<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
</div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> portfolio-single portfolio-page"><?php echo $content_top; ?>
      <h1 class="hidden"><?php echo $heading_title; ?></h1>
      <div class="portfolio-single-wrapper">
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php if ( !empty($categories) ) { ?> 
                <ul class="list-cate">
                  <?php foreach ($categories as $cat) { ?>
                    <li><a href="<?php echo $cat['href']; ?>"><?php echo $cat['name'] ?></a></li>
                  <?php } ?>
                </ul>
              <?php } ?>
            </div>
          </div>
          <div class="row single-row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7 left">
              <div class="thumbnail-gallery">
                <div id="slider" class="flexslider">
                  <ul class="slides">
                    <?php if( !empty($thumb) ) { ?>
                    <!-- Featured -->
                    <li data-thumb="<?php echo $thumb; ?>">
                      <a href="<?php echo $popup; ?>" data-fancybox="images"><img src="<?php echo $image; ?>" alt="<?php echo $heading_title; ?>" /></a>
                    </li>
                    <?php } ?>

                    <?php if( !empty($gallery_thumb) ) { ?>
                    <!-- Gallery image -->
                    <?php foreach ( $gallery_thumb as $image ) {?>
                      <li data-thumb="<?php echo $image['thumb']; ?>">
                        <a href="<?php echo $image['popup']; ?>" data-fancybox="images"><img class="lazy" data-src="<?php echo $image['image']; ?>" /></a>
                      </li>
                    <?php } ?>
                    <?php } ?>
                    <!-- items mirrored twice, total of 12 -->
                  </ul>
                </div>
                <div id="carousel" class="flexslider">
                  <ul class="slides">
                    <?php if( !empty($thumb) ) { ?>
                    <!-- Featured -->
                    <li data-thumb="<?php echo $thumb; ?>">
                      <img src="<?php echo $thumb; ?>" alt="<?php echo $heading_title; ?>" />
                    </li>
                    <?php } ?>

                    <?php if( !empty($gallery_thumb) ) { ?>
                    <!-- Gallery image -->
                    <?php foreach ( $gallery_thumb as $image ) {?>
                      <li data-thumb="<?php echo $image['thumb']; ?>">
                        <img src="<?php echo $image['thumb']; ?>" />
                      </li>
                    <?php } ?>
                    <?php } ?>
                    <!-- items mirrored twice, total of 12 -->
                  </ul>
                </div>
              </div>
            </div>
            <!-- .col-left -->
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-5 right">
              <div class="project-detail">
                <div class="block-content shadow-block">
                  <h1 class="heading"><?php echo $name; ?></h1>
                  <ul class="list-options list-unstyled">
                    <li class="<?php echo empty($portfolio_options['categories']) ? 'hidden' : ''; ?>"><strong>Hạng mục</strong> <?php echo $portfolio_options['categories'] ?></li>
                    <li class="<?php echo empty($portfolio_options['design']) ? 'hidden' : ''; ?>"><strong>Thiết kế</strong> <?php echo $portfolio_options['design'] ?></li>
                    <li class="<?php echo empty($portfolio_options['construction']) ? 'hidden' : ''; ?>"><strong>Thi công</strong> <?php echo $portfolio_options['construction'] ?></li>
                    <li class="<?php echo empty($portfolio_options['investor']) ? 'hidden' : ''; ?>"><strong>Chủ đầu tư</strong> <?php echo $portfolio_options['investor'] ?></li>
                    <li class="<?php echo empty($portfolio_options['construction_time']) ? 'hidden' : ''; ?>"><strong>Thời gian thi công</strong> <?php echo $portfolio_options['construction_time'] ?></li>
                  </ul>
                </div>
                <div class="social">
                  <span class="text">Chia sẽ</span>
                  <ul class="social-wrap">
                    <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-facebook"></i></a></li>
                    <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-twitter"></i></a></li>
                    <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                    <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-youtube"></i></a></li>
                   </ul>
                </div>
              </div>
            </div>
          </div>
          <div class="row content-row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 left">
              <h3 class="title">Mô tả chung</h3>
              <div class="description">
                <?php echo $description; ?>
              </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 right">
              <h3 class="title">Thách thức chung</h3>
              <div class="description">
                <?php echo $challenge_description; ?>
              </div>
            </div>
          </div>
          
        </div>
      </div>
      <?php if (!empty($portfolio_related)) { ?>
      <!-- related portfolio -->
      <div id="related-portfolio" class="section-project content-padding-wrap">
      <div class="container">
      <div class="section-heading">
      <div class="heading-title">
      <h2>Dự án liên quan</h2>
      <div class="line"></div>
      </div>
      </div>
      <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 related-wrap">
      <div id="layers-widget-posts" class="layers-widget-posts widget widget-related-portfolio">
      <div class="clearfix">
      <div class="post-layout-carousel owl-carousel owl-theme">
      <?php foreach ($portfolio_related as $related) { ?>
      <div class="post-item post-id-<?php echo $related['portfolio_id']; ?>">
      <div class="media-image">
      <a href="<?php echo $related['href']; ?>" class="post-link">
      <img class="owl-lazy" data-src="<?php echo $related['thumb']; ?>" alt="<?php echo $related['name']; ?>" />
      </a>
      </div>
      <div class="media-body">
      <a href="<?php echo $related['href'] ?>" class="post-link"><h3 class="heading"><?php echo $related['name']; ?></h3></a>
      <div class="meta-info">
      <div class="cat-item"><a href="#cat-link">Đồng Nai</a></div>
      </div>
      <p class="excerpt">
      <?php echo $related['short_description']; ?>
      </p>
      </div>
      </div>
      <?php } ?>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth: 120,
        itemMargin: 5,
        asNavFor: '#slider'
      });
     
      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        // Lazy loading
        start: function(slider) { flexsliderLazyloaderInit(slider) },
        before: function(slider) { flexsliderLazyloaderLoad(slider) }
      });
--></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {

    // Project Carousel.
    $('#related-portfolio .post-layout-carousel').addClass('owl-carousel owl-theme');
    $('#related-portfolio .post-layout-carousel').owlCarousel({
        // loop:true,
        autoplay: 3000,
        lazyLoad:true,
        margin:0,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true,
            },
            600:{
                items:3,
                nav:true,
                dots: true,
            },
            1000:{
                items:3,
                nav:true,
                dots: true,
            }
        },
        navText: ['<img src="catalog/view/theme/default/stylesheet/images/nav_left.png" />',
              '<img src="catalog/view/theme/default/stylesheet/images/nav_right.png" />']
    });

    // Fancybox
    $().fancybox({
      selector : '.slides li:not(.clone) a',
      hash   : false,
      protect: true, // Bảo mật
      animationEffect: 'zoom',
      transitionEffect: 'slide',
      spinnerTpl: '<div class="fancybox-loading"></div>',
      loop : true,
      thumbs : {
        autoStart : true
      },
      buttons: [
        'zoom',
        'share',
        'slideShow',
        'fullScreen',
        'download',
        'thumbs',
        'close'
      ]
    });
  });
</script>
<?php echo $footer; ?>