<div class="section-wrapper">
     <div id="layers-widget-posts-<?php echo $module_id; ?>" class="layers-widget-posts widget widget-bod">
        <div class="clearfix">
           <div class="row post-list">
              <?php foreach ($testimonials as $testimonial) { ?>
              <div class="post-item col-md-4 post-id-1">
                <div class="post-wrap">
                   <div class="media-image">
                      <a href="<?php echo $testimonial['href']; ?>" class="post-link">
                      <img class="owl-lazy" src="<?php echo $testimonial['thumb']; ?>" alt="<?php echo $testimonial['name']; ?>" />
                      </a>
                      <div class="social-meta">
                          <?php foreach ($testimonial['social_meta'] as $key => $val) { ?>
                             <div class="social-item <?php echo $key; ?>"><a href="<?php echo $val; ?>"><i class="fa fa-<?php echo $key; ?>"></i></a></div>
                          <?php } ?>
                      </div>
                   </div>
                   <div class="media-body">
                      <h3 class="heading"><?php echo $testimonial['name']; ?></h3>
                      <p class="position"><?php echo $testimonial['position']; ?></p>
                   </div>
                </div>
              </div>
              <?php } ?>
              <div class="pagination-a" style="clear: both"><?php echo $pagination; ?></div>
        </div>
    </div>
</div>