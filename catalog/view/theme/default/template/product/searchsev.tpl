<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <label class="control-label" for="input-searchsev"><?php echo $entry_searchsev; ?></label>
      <div class="row">
        <div class="col-sm-4">
          <input type="text" name="searchsev" value="<?php echo $searchsev; ?>" placeholder="<?php echo $text_keyword; ?>" id="input-searchsev" class="form-control" />
        </div>
        <div class="col-sm-3">
          <select name="categorysev_id" class="form-control">
            <optionsev value="0"><?php echo $text_categorysev; ?></optionsev>
            <?php foreach ($categories as $categorysev_1) { ?>
            <?php if ($categorysev_1['categorysev_id'] == $categorysev_id) { ?>
            <optionsev value="<?php echo $categorysev_1['categorysev_id']; ?>" selected="selected"><?php echo $categorysev_1['name']; ?></optionsev>
            <?php } else { ?>
            <optionsev value="<?php echo $categorysev_1['categorysev_id']; ?>"><?php echo $categorysev_1['name']; ?></optionsev>
            <?php } ?>
            <?php foreach ($categorysev_1['children'] as $categorysev_2) { ?>
            <?php if ($categorysev_2['categorysev_id'] == $categorysev_id) { ?>
            <optionsev value="<?php echo $categorysev_2['categorysev_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $categorysev_2['name']; ?></optionsev>
            <?php } else { ?>
            <optionsev value="<?php echo $categorysev_2['categorysev_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $categorysev_2['name']; ?></optionsev>
            <?php } ?>
            <?php foreach ($categorysev_2['children'] as $categorysev_3) { ?>
            <?php if ($categorysev_3['categorysev_id'] == $categorysev_id) { ?>
            <optionsev value="<?php echo $categorysev_3['categorysev_id']; ?>" selected="selected">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $categorysev_3['name']; ?></optionsev>
            <?php } else { ?>
            <optionsev value="<?php echo $categorysev_3['categorysev_id']; ?>">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $categorysev_3['name']; ?></optionsev>
            <?php } ?>
            <?php } ?>
            <?php } ?>
            <?php } ?>
          </select>
        </div>
        <div class="col-sm-3">
          <label class="checkbox-inline">
            <?php if ($sub_categorysev) { ?>
            <input type="checkbox" name="sub_categorysev" value="1" checked="checked" />
            <?php } else { ?>
            <input type="checkbox" name="sub_categorysev" value="1" />
            <?php } ?>
            <?php echo $text_sub_categorysev; ?></label>
        </div>
      </div>
      <p>
        <label class="checkbox-inline">
          <?php if ($description) { ?>
          <input type="checkbox" name="description" value="1" id="description" checked="checked" />
          <?php } else { ?>
          <input type="checkbox" name="description" value="1" id="description" />
          <?php } ?>
          <?php echo $entry_description; ?></label>
      </p>
      <input type="button" value="<?php echo $button_searchsev; ?>" id="button-searchsev" class="btn btn-primary" />
      <h2><?php echo $text_searchsev; ?></h2>
      <?php if ($services) { ?>
      <div class="row">
        <div class="col-md-2 col-sm-6 hidden-xs">
          <div class="btn-group btn-group-sm">
            <button type="button" id="list-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_list; ?>"><i class="fa fa-th-list"></i></button>
            <button type="button" id="grid-view" class="btn btn-default" data-toggle="tooltip" title="<?php echo $button_grid; ?>"><i class="fa fa-th"></i></button>
          </div>
        </div>
        <div class="col-md-3 col-sm-6">
          <div class="form-group">
            <a href="<?php echo $compare; ?>" id="compare-total" class="btn btn-link"><?php echo $text_compare; ?></a>
          </div>
        </div>
        <div class="col-md-4 col-xs-6">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-sort"><?php echo $text_sort; ?></label>
            <select id="input-sort" class="form-control" onchange="location = this.value;">
              <?php foreach ($sorts as $sorts) { ?>
              <?php if ($sorts['value'] == $sort . '-' . $order) { ?>
              <optionsev value="<?php echo $sorts['href']; ?>" selected="selected"><?php echo $sorts['text']; ?></optionsev>
              <?php } else { ?>
              <optionsev value="<?php echo $sorts['href']; ?>"><?php echo $sorts['text']; ?></optionsev>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-3 col-xs-6">
          <div class="form-group input-group input-group-sm">
            <label class="input-group-addon" for="input-limit"><?php echo $text_limit; ?></label>
            <select id="input-limit" class="form-control" onchange="location = this.value;">
              <?php foreach ($limits as $limits) { ?>
              <?php if ($limits['value'] == $limit) { ?>
              <optionsev value="<?php echo $limits['href']; ?>" selected="selected"><?php echo $limits['text']; ?></optionsev>
              <?php } else { ?>
              <optionsev value="<?php echo $limits['href']; ?>"><?php echo $limits['text']; ?></optionsev>
              <?php } ?>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="row">
        <?php foreach ($services as $service) { ?>
        <div class="service-layout service-list col-xs-12">
          <div class="service-thumb">
            <div class="image"><a href="<?php echo $service['href']; ?>"><img src="<?php echo $service['thumb']; ?>" alt="<?php echo $service['name']; ?>" title="<?php echo $service['name']; ?>" class="img-responsive" /></a></div>
            <div>
              <div class="caption">
                <h4><a href="<?php echo $service['href']; ?>"><?php echo $service['name']; ?></a></h4>
                <p><?php echo $service['description']; ?></p>
                <?php if ($service['price']) { ?>
                <p class="price">
                  <?php if (!$service['special']) { ?>
                  <?php echo $service['price']; ?>
                  <?php } else { ?>
                  <span class="price-new"><?php echo $service['special']; ?></span> <span class="price-old"><?php echo $service['price']; ?></span>
                  <?php } ?>
                  <?php if ($service['tax']) { ?>
                  <span class="price-tax"><?php echo $text_tax; ?> <?php echo $service['tax']; ?></span>
                  <?php } ?>
                </p>
                <?php } ?>
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
              </div>
              <div class="button-group">
                <button type="button" onclick="cart.add('<?php echo $service['service_id']; ?>', '<?php echo $service['minimum']; ?>');"><i class="fa fa-shopping-cart"></i> <span class="hidden-xs hidden-sm hidden-md"><?php echo $button_cart; ?></span></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_wishlist; ?>" onclick="wishlist.add('<?php echo $service['service_id']; ?>');"><i class="fa fa-heart"></i></button>
                <button type="button" data-toggle="tooltip" title="<?php echo $button_compare; ?>" onclick="compare.add('<?php echo $service['service_id']; ?>');"><i class="fa fa-exchange"></i></button>
              </div>
            </div>
          </div>
        </div>
        <?php } ?>
      </div>
      <div class="row">
        <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
        <div class="col-sm-6 text-right"><?php echo $results; ?></div>
      </div>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<script type="text/javascript"><!--
$('#button-searchsev').bind('click', function() {
	url = 'index.php?route=service/searchsev';

	var searchsev = $('#content input[name=\'searchsev\']').prop('value');

	if (searchsev) {
		url += '&searchsev=' + encodeURIComponent(searchsev);
	}

	var categorysev_id = $('#content select[name=\'categorysev_id\']').prop('value');

	if (categorysev_id > 0) {
		url += '&categorysev_id=' + encodeURIComponent(categorysev_id);
	}

	var sub_categorysev = $('#content input[name=\'sub_categorysev\']:checked').prop('value');

	if (sub_categorysev) {
		url += '&sub_categorysev=true';
	}

	var filter_description = $('#content input[name=\'description\']:checked').prop('value');

	if (filter_description) {
		url += '&description=true';
	}

	location = url;
});

$('#content input[name=\'searchsev\']').bind('keydown', function(e) {
	if (e.keyCode == 13) {
		$('#button-searchsev').trigger('click');
	}
});

$('select[name=\'categorysev_id\']').on('change', function() {
	if (this.value == '0') {
		$('input[name=\'sub_categorysev\']').prop('disabled', true);
	} else {
		$('input[name=\'sub_categorysev\']').prop('disabled', false);
	}
});

$('select[name=\'categorysev_id\']').trigger('change');
--></script>
<?php echo $footer; ?>