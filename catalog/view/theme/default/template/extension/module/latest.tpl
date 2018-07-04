<div class="section-wrapper">
     <div id="layers-widget-posts-<?php echo $module_id; ?>" class="layers-widget-posts widget widget-project">
        <div class="container clearfix">
           <div class="row post-layout-carousel">
              <?php foreach ($products as $product) { ?>
              <div class="post-item col-md-4 post-id-1">
                 <div class="media-image">
                    <a href="<?php echo $product['href']; ?>" class="post-link">
                    <img class="owl-lazy" data-src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" />
                    </a>
                 </div>
                 <div class="media-body">
                    <h3 class="heading"><?php echo $product['name']; ?></h3>
                    <div class="meta-info">
                       <div class="cat-item"><a href="#cat-link">Đồng Nai</a></div>
                    </div>
                    <p class="excerpt">
                       <?php echo $product['description']; ?>
                    </p>
                 </div>
              </div>
              <?php } ?>
        </div>
    </div>
</div>