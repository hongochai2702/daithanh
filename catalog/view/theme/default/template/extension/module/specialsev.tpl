<h3><?php echo $heading_title; ?></h3>
<div class="row">
  <?php foreach ($services as $service) { ?>
  <div class="service-layout col-lg-3 col-md-3 col-sm-6 col-xs-12">
    <div class="service-thumb transition">
      <div class="image"><a href="<?php echo $service['href']; ?>"><img src="<?php echo $service['thumb']; ?>" alt="<?php echo $service['name']; ?>" title="<?php echo $service['name']; ?>" class="img-responsive" /></a></div>
      <div class="caption">
        <h4><a href="<?php echo $service['href']; ?>"><?php echo $service['name']; ?></a></h4>
        <p><?php echo $service['description']; ?></p>
        <?php if ($service['rating']) { ?>
        <div class="rating">
          <?php for ($i = 1; $i <= 5; $i++) { ?>
          <?php if ($service['rating'] < $i) { ?>
          <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } else { ?>
          <span class="fa fa-stack"><i class="fa fa-star fa-stack-2x"></i><i class="fa fa-star-o fa-stack-2x"></i></span>
          <?php } ?>
          <?php } ?>
        </div>
        <?php } ?>
        <?php if ($service['price']) { ?>
        <p class="price">
          <?php if (!$service['specialsev']) { ?>
          <?php echo $service['price']; ?>
          <?php } else { ?>
          <span class="price-new"><?php echo $service['specialsev']; ?></span> <span class="price-old"><?php echo $service['price']; ?></span>
          <?php } ?>
          <?php if ($service['tax']) { ?>
          <span class="price-tax"><?php echo $text_tax; ?> <?php echo $service['tax']; ?></span>
          <?php } ?>
        </p>
        <?php } ?>
      </div>
      <div class="button-group">
        <button type="button" onclick="cart.add('<?php echo $service['service_id']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $service['service_id']; ?>');"><i class="fa fa-heart"></i></button>
        <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $service['service_id']; ?>');"><i class="fa fa-exchange"></i></button>
      </div>
    </div>
  </div>
  <?php } ?>
</div>
