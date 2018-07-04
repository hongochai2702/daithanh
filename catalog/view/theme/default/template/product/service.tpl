<?php echo $header; ?>

<div class="container">

  <ul class="breadcrumb">

    <?php foreach ($breadcrumbs as $breadcrumb) { ?>

    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>

    <?php } ?>

  </ul>
  </div>
  <div class="line_later_sev">
  <div class="container">
      <div class="row">

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

            <?php if ( !empty($services) ) { ?> 

              <ul class="list-cate">

                <?php foreach ($services as $service) { ?>

                  <li><a href="<?php echo $service['href']; ?>"><?php echo $service['name'] ?></a></li>

                <?php } ?>

              </ul>

            <?php } ?>

          </div>

        </div>
  </div>
</div>
  <div class="container">


  <div class="row"><?php echo $column_left; ?>

    <?php if ($column_left && $column_right) { ?>

    <?php $class = 'col-sm-6'; ?>

    <?php } elseif ($column_left || $column_right) { ?>

    <?php $class = 'col-sm-9'; ?>

    <?php } else { ?>

    <?php $class = 'col-sm-12'; ?>

    <?php } ?>

    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>

      <div class="row">

        <?php if ($column_left || $column_right) { ?>

        <?php $class = 'col-sm-6'; ?>

        <?php } else { ?>

        <?php $class = 'col-sm-8'; ?>

        <?php } ?>

        <div class="<?php echo $class; ?>">

          <?php if ($thumb || $images) { ?>

          <ul class="thumbnails">
            <?php if ($thumb) { ?>
             <li class="thumb_once">                               
              <a class="thumbnail woocommerce-main-image" href="<?php echo $popup; ?>" data-fancybox="images">
                <img src="<?php echo $thumb; ?>" class="attachment-full size-full" data-zoom-image="<?php echo $popup; ?>" title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"/>
              </a>
            </li>
            <?php } ?>

            <?php if ($images) { ?>
            <div class="single-pro-thumb artemis_swp_gallery_thumbnails">
           
              <ul class="thubm-caro owl-carousel" id="optima_gallery">
                                    <?php if ($images) { ?>
                                        <?php foreach ($images as $image) { ?>
                                            <li>
                                                <a href="<?php echo $image['popup']; ?>" class="artemis_swp_gallery_thumbnail" data-image="<?php echo $image['popup']; ?>" data-fancybox="images"><img src="<?php echo $image['thumb']; ?>" /></a>
                                            </li> 
                                        <?php } ?>
                                    <?php } ?>                    
                                </ul>

           </div>

            <?php } ?>

          </ul>

          <?php } ?>

         

        </div>

        <?php if ($column_left || $column_right) { ?>

        <?php $class = 'col-sm-6'; ?>

        <?php } else { ?>

        <?php $class = 'col-sm-4'; ?>

        <?php } ?>

        <div class="<?php echo $class; ?>">
          <div class="bg_detall">

          <h1><?php echo $heading_title; ?></h1>

                                <div class="rating">
                                    <p>
                                        <?php for ($i = 1; $i <= 5; $i++) { ?>
                                            <?php if ($rating < $i) { ?>
                                                <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>
                                            <?php } else { ?>
                                                <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>
                                            <?php } ?>
                                        <?php } ?> 
                                        /
                                        <a href="" onclick="$('a[href=\'#tab-review\']').trigger('click');
                                                       return false;"><?php echo $reviewsevs; ?></a> 

                                    </p>
                                </div>
         

          <ul class="list-unstyled">

            <?php if ($manufacturersev) { ?>

            <li><strong><?php echo $text_manufacturersev; ?></strong> <a href="<?php echo $manufacturersevs; ?>"><?php echo $manufacturersev; ?></a></li>

            <?php } ?>

            <?php if ($location) { ?>

            <li><strong><?php echo $text_location; ?></strong> <a href="<?php echo $locations; ?>"><?php echo $location; ?></a></li>

            <?php } ?>

            <li><strong><?php echo $text_model; ?> </strong><?php echo $model; ?></li>

            <?php if ($reward) { ?>

            <li><strong><?php echo $text_reward; ?></strong> <?php echo $reward; ?></li>

            <?php } ?>

            <li><strong><?php echo $text_stock; ?></strong> <?php echo $stock; ?></li>

          </ul>
           <div class="social">

                      <ul class="social-wrap">

                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-facebook"></i></a></li>

                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-twitter"></i></a></li>

                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-google-plus"></i></a></li>

                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-youtube"></i></a></li>

                       </ul>

                    </div>

         

          <div id="service">

            <?php if ($optionsevs) { ?>

            <hr>

            <h3><?php echo $text_optionsev; ?></h3>

            <?php foreach ($optionsevs as $optionsev) { ?>

            <?php if ($optionsev['type'] == 'select') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <select name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control">

                <option value=""><?php echo $text_select; ?></option>

                <?php foreach ($optionsev['service_optionsev_value'] as $optionsev_value) { ?>

                <option value="<?php echo $optionsev_value['service_optionsev_value_id']; ?>"><?php echo $optionsev_value['name']; ?>

                <?php if ($optionsev_value['price']) { ?>

                (<?php echo $optionsev_value['price_prefix']; ?><?php echo $optionsev_value['price']; ?>)

                <?php } ?>

                </option>

                <?php } ?>

              </select>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'radio') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label"><?php echo $optionsev['name']; ?></label>

              <div id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>">

                <?php foreach ($optionsev['service_optionsev_value'] as $optionsev_value) { ?>

                <div class="radio">

                  <label>

                    <input type="radio" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="<?php echo $optionsev_value['service_optionsev_value_id']; ?>" />

                    <?php if ($optionsev_value['image']) { ?>

                    <img src="<?php echo $optionsev_value['image']; ?>" alt="<?php echo $optionsev_value['name'] . ($optionsev_value['price'] ? ' ' . $optionsev_value['price_prefix'] . $optionsev_value['price'] : ''); ?>" class="img-thumbnail" /> 

                    <?php } ?>                    

                    <?php echo $optionsev_value['name']; ?>

                    <?php if ($optionsev_value['price']) { ?>

                    (<?php echo $optionsev_value['price_prefix']; ?><?php echo $optionsev_value['price']; ?>)

                    <?php } ?>

                  </label>

                </div>

                <?php } ?>

              </div>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'checkbox') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label"><?php echo $optionsev['name']; ?></label>

              <div id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>">

                <?php foreach ($optionsev['service_optionsev_value'] as $optionsev_value) { ?>

                <div class="checkbox">

                  <label>

                    <input type="checkbox" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>][]" value="<?php echo $optionsev_value['service_optionsev_value_id']; ?>" />

                    <?php if ($optionsev_value['image']) { ?>

                    <img src="<?php echo $optionsev_value['image']; ?>" alt="<?php echo $optionsev_value['name'] . ($optionsev_value['price'] ? ' ' . $optionsev_value['price_prefix'] . $optionsev_value['price'] : ''); ?>" class="img-thumbnail" /> 

                    <?php } ?>

                    <?php echo $optionsev_value['name']; ?>

                    <?php if ($optionsev_value['price']) { ?>

                    (<?php echo $optionsev_value['price_prefix']; ?><?php echo $optionsev_value['price']; ?>)

                    <?php } ?>

                  </label>

                </div>

                <?php } ?>

              </div>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'text') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <input type="text" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="<?php echo $optionsev['value']; ?>" placeholder="<?php echo $optionsev['name']; ?>" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control" />

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'textarea') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <textarea name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" rows="5" placeholder="<?php echo $optionsev['name']; ?>" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control"><?php echo $optionsev['value']; ?></textarea>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'file') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label"><?php echo $optionsev['name']; ?></label>

              <button type="button" id="button-upload<?php echo $optionsev['service_optionsev_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>

              <input type="hidden" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" />

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'date') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <div class="input-group date">

                <input type="text" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="<?php echo $optionsev['value']; ?>" data-date-format="YYYY-MM-DD" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control" />

                <span class="input-group-btn">

                <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                </span></div>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'datetime') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <div class="input-group datetime">

                <input type="text" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="<?php echo $optionsev['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control" />

                <span class="input-group-btn">

                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>

                </span></div>

            </div>

            <?php } ?>

            <?php if ($optionsev['type'] == 'time') { ?>

            <div class="form-group<?php echo ($optionsev['required'] ? ' required' : ''); ?>">

              <label class="control-label" for="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>"><?php echo $optionsev['name']; ?></label>

              <div class="input-group time">

                <input type="text" name="optionsev[<?php echo $optionsev['service_optionsev_id']; ?>]" value="<?php echo $optionsev['value']; ?>" data-date-format="HH:mm" id="input-optionsev<?php echo $optionsev['service_optionsev_id']; ?>" class="form-control" />

                <span class="input-group-btn">

                <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>

                </span></div>

            </div>

            <?php } ?>

            <?php } ?>

            <?php } ?>

            <?php if ($recurrings) { ?>

            <hr>

            <h3><?php echo $text_payment_recurring; ?></h3>

            <div class="form-group required">

              <select name="recurring_id" class="form-control">

                <option value=""><?php echo $text_select; ?></option>

                <?php foreach ($recurrings as $recurring) { ?>

                <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>

                <?php } ?>

              </select>

              <div class="help-block" id="recurring-description"></div>

            </div>

            <?php } ?>

            <div class="form-group">

              <label class="control-label hidden" for="input-quantity"><?php echo $entry_qty; ?></label>

              <input type="text" name="quantity" value="<?php echo $minimum; ?>" size="2" id="input-quantity" class="form-control hidden" />

              <input type="hidden" name="service_id" value="<?php echo $service_id; ?>" />

              <br />

              <button type="button" id="button-cart" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#review_status"><?php echo $button_cart; ?></button>
            </div>

            <?php if ($minimum > 1) { ?>

            <div class="alert alert-info"><i class="fa fa-info-circle"></i> <?php echo $text_minimum; ?></div>

            <?php } ?>

          </div>

          <?php if ($reviewsev_status) { ?>

          <div class="rating">

            <p>

              <?php for ($i = 1; $i <= 5; $i++) { ?>

              <?php if ($rating < $i) { ?>

              <span class="fa fa-stack"><i class="fa fa-star-o fa-stack-1x"></i></span>

              <?php } else { ?>

              <span class="fa fa-stack"><i class="fa fa-star fa-stack-1x"></i><i class="fa fa-star-o fa-stack-1x"></i></span>

              <?php } ?>

              <?php } ?>

              <a href="" onclick="$('a[href=\'#tab-reviewsev\']').trigger('click'); return false;"><?php echo $reviewsevs; ?></a> <a href="" onclick="$('a[href=\'#tab-reviewsev\']').trigger('click'); return false;"><?php echo $text_write; ?></a></p>


          </div>

          <?php } ?>
        </div>

        </div>



      </div>

       <ul class="nav nav-tabs">

            <li class="active"><a href="#tab-description" data-toggle="tab"><?php echo $tab_description; ?></a></li>

            <?php if ($attributesev_groups) { ?>

            <li><a href="#tab-specification" data-toggle="tab"><?php echo $tab_attributesev; ?></a></li>

            <?php } ?>

           

            <li><a href="#tab-reviewsev" data-toggle="tab"><?php echo $tab_reviewsev; ?></a></li>
          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="tab-description"><?php echo $description; ?></div>

            <?php if ($attributesev_groups) { ?>

            <div class="tab-pane" id="tab-specification">

              <table class="table table-bordered">

                <?php foreach ($attributesev_groups as $attributesev_group) { ?>

                <thead>

                  <tr>

                    <td colspan="2"><strong><?php echo $attributesev_group['name']; ?></strong></td>

                  </tr>

                </thead>

                <tbody>

                  <?php foreach ($attributesev_group['attributesev'] as $attributesev) { ?>

                  <tr>

                    <td><?php echo $attributesev['name']; ?></td>

                    <td><?php echo $attributesev['text']; ?></td>

                  </tr>

                  <?php } ?>

                </tbody>

                <?php } ?>

              </table>

            </div>

            <?php } ?>

        

            <div class="tab-pane contact-form" id="tab-reviewsev">

              <form class="form-horizontal" id="form-reviewsev">

                <div id="reviewsev"></div>

                <h2 class="title_review"> <img src="image/data/comment.png"> <?php echo $text_write; ?></h2>
              <div class="form-group required">

                  <div class="col-sm-4">
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" placeholder="<?php echo $entry_name; ?>"/>

                  </div>
                    <div class="col-sm-4">
                    <input type="text" name="name" value="<?php echo $customer_name; ?>" id="input-name" class="form-control" placeholder="<?php echo $entry_name; ?>"/>

                  </div>
                    <div class="col-sm-4">
                  <div class="form-rating">
        <label class="control-label"><?php echo $entry_rating; ?></label>
  <input type="radio" name="rating" value="1" />

                    &nbsp;

                    <input type="radio" name="rating" value="2" />
                      
                    &nbsp;

                    <input type="radio" name="rating" value="3" />

                    &nbsp;

                    <input type="radio" name="rating" value="4" />

                    &nbsp;

                    <input type="radio" name="rating" value="5" />

                  </div>

                  </div>

                </div>

                <div class="form-group required">

                  <div class="col-sm-12">
  <textarea name="text" rows="7" id="input-reviewsev" class="form-control" placeholder="<?php echo $entry_reviewsev; ?>"></textarea>
                  </div>

                </div>

            

                <?php echo $captcha; ?>

                <div class="buttons clearfix text-center">
                     <button type="button" id="button-reviewsev" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary"><?php echo $button_continue; ?></button>

 </div>
              </form>

            </div>
          </div>

      <?php if ($services) { ?>

      

      <div class="row">

        <?php $i = 0; ?>

      

        <?php if ($column_left && $column_right) { ?>

        <?php $class = 'col-xs-8 col-sm-6'; ?>

        <?php } elseif ($column_left || $column_right) { ?>

        <?php $class = 'col-xs-6 col-md-4'; ?>

        <?php } else { ?>

        <?php $class = 'col-xs-6 col-sm-3'; ?>

        <?php } ?>

        <?php if (($column_left && $column_right) && (($i+1) % 2 == 0)) { ?>

        <div class="clearfix visible-md visible-sm"></div>

        <?php } elseif (($column_left || $column_right) && (($i+1) % 3 == 0)) { ?>

        <div class="clearfix visible-md"></div>

        <?php } elseif (($i+1) % 4 == 0) { ?>

        <div class="clearfix visible-md"></div>

        <?php } ?>

        <?php $i++; ?>

       

      </div>

      <?php } ?>

    

      <?php echo $content_bottom; ?></div>

    <?php echo $column_right; ?></div>


</div>
 <section id="text_related" class="section-project content-padding-wrap">
  <div class="section-heading">

    <div class="heading-title">
     <h2><?php echo $text_related; ?></h2>
     <div class="line"></div>
  </div>
</div>


     <div class="section-wrapper">
     <div class="layers-widget-posts widget widget-project">
        <div class="container clearfix">
           <div class="row post-layout-carousel">
              <?php foreach ($services as $service) { ?>
              <div class="post-item col-md-4 post-id-1">
                 <div class="media-image">
                    <a href="<?php echo $service['href']; ?>" class="post-link">
                    <img class="owl-lazy" data-src="<?php echo $service['thumb']; ?>" alt="<?php echo $service['name']; ?>" />
                    </a>
                 </div>
                 <div class="media-body">
                    <a href="<?php echo $service['href'] ?>" class="post-link"><h3 class="heading"><?php echo $service['name']; ?></h3></a>
                    <div class="meta-info">
                       <div class="cat-item"><a href="#cat-link">Đồng Nai</a></div>
                    </div>
                    <p class="excerpt">
                       <?php echo $service['description']; ?>
                    </p>
                 </div>
              </div>
              <?php } ?>
            </div>
        </div>
    </div>
  </div>
</section>
<div id="review_status" class="modal fade" role="dialog" ng-controller="ctrlCtForm">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><img src="http://demo.xulynuocthaidaithanh.com/catalog/view/theme/default/images/Close.png"></button>
                    <div class="title_contact">
                    <h2 class="title">Liên hệ với chúng tôi</h2>
                    <div class="line"></div>
                  </div>
                        <p>Chúng tôi muốn mang lại một môi trường trong lành đến cho bạn. Vui lòng liên hệ với chúng tôi bằng cách sử dụng mẫu dưới đây đội ngũ của Đại Thanh sẽ liên hệ lại với bạn sớm nhất.</p>
                <form class="form-horizontal" id="form-reviewsev">
                  <div class="col-sm-6">
                    <div class="form-group required">
                     <div class="col-sm-12">
                     <input type="text" name="name" value="" id="input-name" class="form-control" placeholder="Tên/Doanh nghiệp*">
                    </div>
                    </div>

                    <div class="form-group required">
                     <div class="col-sm-12">
                      <input type="text" name="name" value="" id="input-name" class="form-control" placeholder="Địa chỉ Email*">
                    </div>
                  </div>

                  <div class="form-group required">
                     <div class="col-sm-12">
                      <input type="text" name="name" value="" id="input-name" class="form-control" placeholder="Số điện thoại*">
                    </div>
                  </div>
                  </div>
                 <div class="col-sm-6">
                  <div class="form-group required">
                  <div class="col-sm-12">
                    <textarea name="text" rows="6" id="input-reviewsev" class="form-control" placeholder="Nội dung"></textarea>
                  </div>
                </div>
                 </div>
                <div class="buttons clearfix text-center">
                     <button type="button" id="button-reviewsev" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-primary" ng-click="sendContact();">Gửi ngay</button>
              </div>
              </div>
    </div>
</div>
</div>
<script type="text/javascript"><!--

$('select[name=\'recurring_id\'], input[name="quantity"]').change(function(){

	$.ajax({

		url: 'index.php?routes=product/service/getRecurringDescription',

		type: 'post',

		data: $('input[name=\'service_id\'], input[name=\'quantity\'], select[name=\'recurring_id\']'),

		dataType: 'json',

		beforeSend: function() {

			$('#recurring-description').html('');

		},

		success: function(json) {

			$('.alert, .text-danger').remove();



			if (json['success']) {

				$('#recurring-description').html(json['success']);

			}

		}

	});

});

//--></script>

<script type="text/javascript"><!--

$('#button-cart').on('click', function() {

	$.ajax({

		url: 'index.php?routes=checkout/cart/add',

		type: 'post',

		data: $('#service input[type=\'text\'], #service input[type=\'hidden\'], #service input[type=\'radio\']:checked, #service input[type=\'checkbox\']:checked, #service select, #service textarea'),

		dataType: 'json',

		beforeSend: function() {

			$('#button-cart').button('loading');

		},

		complete: function() {

			$('#button-cart').button('reset');

		},

		success: function(json) {

			$('.alert, .text-danger').remove();

			$('.form-group').removeClass('has-error');



			if (json['error']) {

				if (json['error']['optionsev']) {

					for (i in json['error']['optionsev']) {

						var element = $('#input-optionsev' + i.replace('_', '-'));



						if (element.parent().hasClass('input-group')) {

							element.parent().after('<div class="text-danger">' + json['error']['optionsev'][i] + '</div>');

						} else {

							element.after('<div class="text-danger">' + json['error']['optionsev'][i] + '</div>');

						}

					}

				}



				if (json['error']['recurring']) {

					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');

				}



				// Highlight any found errors

				$('.text-danger').parent().addClass('has-error');

			}



			if (json['success']) {

				$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');



				$('#cart > button').html('<span id="cart-total"><i class="fa fa-shopping-cart"></i> ' + json['total'] + '</span>');



				$('html, body').animate({ scrollTop: 0 }, 'slow');



				$('#cart > ul').load('index.php?routes=common/cart/info ul li');

			}

		},

        error: function(xhr, ajaxOptions, thrownError) {

            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

        }

	});

});

//--></script>

<script type="text/javascript"><!--

$('.date').datetimepicker({

	pickTime: false

});



$('.datetime').datetimepicker({

	pickDate: true,

	pickTime: true

});



$('.time').datetimepicker({

	pickDate: false

});



$('button[id^=\'button-upload\']').on('click', function() {

	var node = this;



	$('#form-upload').remove();



	$('body').prepend('<form enctype="multipart/form-data" id="form-upload" style="display: none;"><input type="file" name="file" /></form>');



	$('#form-upload input[name=\'file\']').trigger('click');



	if (typeof timer != 'undefined') {

    	clearInterval(timer);

	}



	timer = setInterval(function() {

		if ($('#form-upload input[name=\'file\']').val() != '') {

			clearInterval(timer);



			$.ajax({

				url: 'index.php?routes=tool/upload',

				type: 'post',

				dataType: 'json',

				data: new FormData($('#form-upload')[0]),

				cache: false,

				contentType: false,

				processData: false,

				beforeSend: function() {

					$(node).button('loading');

				},

				complete: function() {

					$(node).button('reset');

				},

				success: function(json) {

					$('.text-danger').remove();



					if (json['error']) {

						$(node).parent().find('input').after('<div class="text-danger">' + json['error'] + '</div>');

					}



					if (json['success']) {

						alert(json['success']);



						$(node).parent().find('input').val(json['code']);

					}

				},

				error: function(xhr, ajaxOptions, thrownError) {

					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);

				}

			});

		}

	}, 500);

});

//--></script>

<script type="text/javascript"><!--

$('#reviewsev').delegate('.pagination a', 'click', function(e) {

    e.preventDefault();



    $('#reviewsev').fadeOut('slow');



    $('#reviewsev').load(this.href);



    $('#reviewsev').fadeIn('slow');

});



$('#reviewsev').load('index.php?routes=product/service/reviewsev&service_id=<?php echo $service_id; ?>');



$('#button-reviewsev').on('click', function() {

	$.ajax({

		url: 'index.php?routes=product/service/write&service_id=<?php echo $service_id; ?>',

		type: 'post',

		dataType: 'json',

		data: $("#form-reviewsev").serialize(),

		beforeSend: function() {

			$('#button-reviewsev').button('loading');

		},

		complete: function() {

			$('#button-reviewsev').button('reset');

		},

		success: function(json) {

			$('.alert-success, .alert-danger').remove();



			if (json['error']) {

//				$('#reviewsev').after('<div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> ' + json['error'] + '</div>');

         swal({

                    text: json['error'],

                    icon: "warning",

                    dangerMode: true

                });



			}



			if (json['success']) {

			//	$('#reviewsev').after('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '</div>');

        swal("Thành công!",json['success'],'success');



				$('input[name=\'name\']').val('');

				$('textarea[name=\'text\']').val('');

				$('input[name=\'rating\']:checked').prop('checked', false);

			}

		}

	});

});





//--></script>
    <script type="text/javascript">

        $(document).ready(function() {
            $('.thubm-caro').owlCarousel({
                   autoplay: false,
                    autoplayTimeout: 4000,
                    loop: true,
                    singleItem: false,
                    nav: false,
                    margin: 20,
                    pagination: true,
                    rewindNav : false,
                    responsive:{
                                0:{
                                    items:1,

                                },
                                750:{
                                    items:1,

                                },
                                970:{
                                    items:1,

                                },
                                1170:{
                                    items:4,

                                }
                            },
                          lazyLoad:true
                  });
          
    });
</script>
<script type="text/javascript">
  jQuery( document ).ready( function( $ ) {
     runUnslider( $ );
});

var runUnslider = function( $ ) {
    var next_value = "next";
    var prev_value = "prev";
    var slider_arrows = {
            prev : '<a class="unslider-arrow prev">' + prev_value + '</a>',
            next : '<a class="unslider-arrow next">' + next_value + '</a>',
        };
    var gallery = $( '.woocommerce div.images .image_gallery' );
    gallery.on( 'unslider.change', function( event, index, slide ) {
        $( '.artemis_swp_gallery_thumbnails a.artemis_swp_gallery_thumbnail' ).removeClass( 'active' );
        $( '.artemis_swp_gallery_thumbnails a.artemis_swp_gallery_thumbnail:eq(' + index + ')' ).addClass( 'active' );
        var currentSlide = event.target;
        var otherSlides = slide.siblings('li');
        console.log(otherSlides);
    } );
    gallery.unslider( {
        arrows   : {
            prev : '<a class="gallery-unslider-arrow prev"><i class="fa fa-angle-left" aria-hidden="true"></i> <span class="at_swp_slider_prev_next_text">' + artemis_swp.sliderPrevText + '</span> </a>',
            next : '<a class="gallery-unslider-arrow next"><i class="fa fa-angle-right" aria-hidden="true"></i><span class="at_swp_slider_prev_next_text">' + artemis_swp.sliderNextText + '</span> </a>',
        },
        autoplay : false,
        delay    : 10000,
        speed    : 400,
        nav      : false
    } );
    $( '.artemis_swp_gallery_thumbnails a' ).click( function( event ) {
        event.preventDefault();
        var index = $( this ).index();
        var data_image = $(this).attr('data-image');
            $(".attachment-full").animate({opacity: 0.3}, 500);
            $('.attachment-full').attr('src',data_image);
            $('.woocommerce-main-image').attr('href',data_image);
            $(".attachment-full").animate({opacity: 1}, 500);
           
           
        $( gallery ).unslider( 'animate:' + index );
        return false;
    });



  
};


</script>

<script type="text/javascript">
  var classs =  $('.unslider-wrap');
var artemis_swp = {"confirmCancel":"Cancel","confirmOk":"Ok","alertOk":"Ok","sliderPrevText":"PREV","sliderNextText":"NEXT"};
var artemis_swp_login_popup = {"ajax_url":"","general_error_text":"Something went wrong! Please try again later!"};
    if(classs.owlCarousel != undefined) {
         classs.owlCarousel({
        items: 1,
        autoPlay: false,
        navigation: true,
        itemsDesktop : [1000,1],
        itemsDesktopSmall : [900,1],
        itemsTablet: [767,1],
        itemsMobile : [450,1],
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
    });
}



</script>
<script type="text/javascript">
	
	app.controller('ctrlCtForm',function($http,$scope){

		$scope.sendContact = function(){
			
		}
	});

</script>
<?php echo $footer; ?>

