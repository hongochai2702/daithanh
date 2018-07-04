<div class="section-wrapper">
     <div id="layers-widget-posts-<?php echo $module_id; ?>" class="layers-widget-posts widget widget-project">
        <div class="container clearfix">
           <div class="row post-layout-carousel">
              <?php foreach ($portfolios as $portfolio) { ?>
              <div class="post-item col-md-4 post-id-1">
                 <div class="media-image">
                    <a href="<?php echo $portfolio['href']; ?>" class="post-link">
                    <img class="owl-lazy" data-src="<?php echo $portfolio['thumb']; ?>" alt="<?php echo $portfolio['name']; ?>" />
                    </a>
                 </div>
                 <div class="media-body">
                    <a href="<?php echo $portfolio['href'] ?>" class="post-link"><h3 class="heading"><?php echo $portfolio['name']; ?></h3></a>
                    <div class="meta-info">
                       <div class="cat-item"><a href="#cat-link">Đồng Nai</a></div>
                    </div>
                    <p class="excerpt">
                       <?php echo $portfolio['short_description']; ?>
                    </p>
                 </div>
              </div>
              <?php } ?>
        </div>
    </div>
</div>