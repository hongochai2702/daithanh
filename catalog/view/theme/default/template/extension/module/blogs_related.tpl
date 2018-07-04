<div id="layers-widget-related-<?php echo $module_id; ?>" class="layers-widget-posts widget widget-blogs-related">
    <div class="heading-title">
        <h2><?php echo $name; ?></h2>
        <div class="line"></div>
    </div>
    <div class="clearfix">
       <div class="post-layout-carousel owl-carousel owl-theme">
          <?php foreach ($blogss as $blogs) { ?>
          <div class="post-item col-md-4 post-id-1">
             <div class="media-image">
                <a href="<?php echo $blogs['href']; ?>" class="post-link">
                <img class="owl-lazy" data-src="<?php echo $blogs['thumb']; ?>" alt="<?php echo $blogs['name']; ?>" />
                </a>
             </div>
             <div class="media-body">
                <a href="<?php echo $blogs['href'] ?>" class="post-link"><h3 class="heading"><?php echo $blogs['name']; ?></h3></a>
                <div class="post-meta">
                  <ul class="meta">
                    <li><a href="#author"><img src="catalog/view/theme/default/images/theme/blogs/user-silhouette.png" alt=""> Văn Chót</a></li>
                    <li><a href="#date"><img src="catalog/view/theme/default/images/theme/blogs/calendar.png" alt=""> 15/3/2017</a></li>
                    <li><a href="#comment"><img src="catalog/view/theme/default/images/theme/blogs/comments.png" alt=""> 2 bình luận</a></li>
                  </ul>
                </div>
                <p class="excerpt">
                  Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been…
                   <?php //echo $blogs['description']; ?>
                </p>
             </div>
          </div>
          <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('#layers-widget-related-<?php echo $module_id; ?> .post-layout-carousel').owlCarousel({
      // loop:true,
      autoplay: 3000,
      lazyLoad : true,
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
          },
          1000:{
              items:2,
              nav:true,
              loop:true,
          }
      },
      navText: ['<img src="catalog/view/theme/default/stylesheet/images/nav_left_black.png" />',
            '<img src="catalog/view/theme/default/stylesheet/images/nav_right_black.png" />']
  });
  });
</script>