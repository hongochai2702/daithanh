<div class="section-wrapper">
   <div id="layers-widget-testimonials-1" class="layers-widget-testimonials widget <?php echo $classes; ?>">
      <div class="container clearfix">
         <div class="row testimonials-layout-carousel">
            <?php foreach( $testimonials as $testimonial ) { ?>
            <div class="testimonials-item col-md-12 post-id-1">
               <div class="testimonial-image">
                  <a href="<?php echo $testimonial['href']; ?>" class="post-link">
                  <img class="owl-lazy" data-src="<?php echo $testimonial['thumb']; ?>">
                  </a>
               </div>
               <div class="testimonial-body">
                  <h3 class="heading"><?php echo $testimonial['name']; ?></h3>
                  <div class="meta-info">
                     <div class="position"><span><?php echo $testimonial['position']; ?></span></div>
                  </div>
                  <div class="excerpt">
                     <p><?php echo $testimonial['description']; ?></p>
                     <p class="sologan">"Nếu bạn cần hỗ trợ, cứ nói họ, họ sẽ hỗ trợ cho bạn"</p>
                     <p>Chúng tôi tự hào về điều đó.</p>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
   </div>
</div>