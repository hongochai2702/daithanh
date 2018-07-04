<div class="section-wrapper">
   <div id="layers-widget-posts-<?php echo $module_id; ?>" class="layers-widget-posts widget widget-service">
      <div class="container clearfix">
         <div class="row post-layout-list">
          <?php foreach ($services as $key => $service) { ?>
          
            <div class="post-item col-md-4 post-id-<?php echo $service['service_id']; ?> <?php echo ($key == 0) ? 'first-item-service' : ''; ?>">
               <div class="media-image">
                  <a href="<?php echo $service['href']; ?>" class="post-link">
                  <img src="<?php echo $service['thumb']; ?>" alt="<?php echo $service['name']; ?>">
                  </a>
               </div>
               <div class="media-body">
                  <a href="<?php echo $service['href']; ?>" class="post-link">
                     <h3 class="heading"><?php echo $service['name']; ?></h3>
                     <div class="lead"><?php echo $product['description']; ?></div>
                  </a>
               </div>
            </div>
          <?php } ?>
         </div>
      </div>
   </div>
  </div>
