<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">

  <div class="page-header">

    <div class="container-fluid">

      <div class="pull-right">

        <button type="submit" form="form-service" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>

        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>

      <h1><?php echo $heading_title; ?></h1>

      <ul class="breadcrumb">

        <?php foreach ($breadcrumbs as $breadcrumb) { ?>

        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>

        <?php } ?>

      </ul>

    </div>

  </div>

  <div class="container-fluid">

    <?php if ($error_warning) { ?>

    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>

      <button type="button" class="close" data-dismiss="alert">&times;</button>

    </div>

    <?php } ?>

    <div class="panel panel-default">

      <div class="panel-heading">

        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>

      </div>

      <div class="panel-body">

        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-service" class="form-horizontal">

          <ul class="nav nav-tabs">

            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>

            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>

            <li><a href="#tab-links" data-toggle="tab"><?php echo $tab_links; ?></a></li>

            <li><a href="#tab-attributesev" data-toggle="tab"><?php echo $tab_attributesev; ?></a></li>

            <li><a href="#tab-optionsev" data-toggle="tab"><?php echo $tab_optionsev; ?></a></li>

            <li><a href="#tab-recurring" data-toggle="tab"><?php echo $tab_recurring; ?></a></li>

            <li><a href="#tab-discount" data-toggle="tab"><?php echo $tab_discount; ?></a></li>

            <li><a href="#tab-special" data-toggle="tab"><?php echo $tab_special; ?></a></li>

            <li><a href="#tab-image" data-toggle="tab"><?php echo $tab_image; ?></a></li>

            <li><a href="#tab-reward" data-toggle="tab"><?php echo $tab_reward; ?></a></li>

            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>

          </ul>

          <div class="tab-content">

            <div class="tab-pane active" id="tab-general">

              <ul class="nav nav-tabs" id="language">

                <?php foreach ($languages as $language) { ?>

                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>

                <?php } ?>

              </ul>

              <div class="tab-content">

                <?php foreach ($languages as $language) { ?>

                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">

                  <div class="form-group required">

                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>

                    <div class="col-sm-10">

                      <input type="text" name="service_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />

                      <?php if (isset($error_name[$language['language_id']])) { ?>

                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>

                      <?php } ?>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>

                    <div class="col-sm-10">

                       <textarea data-toggle="summernote" data-lang="<?php echo $language['code']; ?>" name="service_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="editor_chili"><?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['description'] : ''; ?></textarea>

                    </div>

                  </div>

                  <div class="form-group required">

                    <label class="col-sm-2 control-label" for="input-meta-title<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>

                    <div class="col-sm-10">

                      <input type="text" name="service_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['language_id']; ?>" class="form-control" />

                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>

                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>

                      <?php } ?>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>

                    <div class="col-sm-10">

                      <textarea name="service_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['meta_description'] : ''; ?></textarea>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>

                    <div class="col-sm-10">

                      <textarea name="service_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>

                    </div>

                  </div>

                  <div class="form-group">

                    <label class="col-sm-2 control-label" for="input-tag<?php echo $language['language_id']; ?>"><span data-toggle="tooltip" title="<?php echo $help_tag; ?>"><?php echo $entry_tag; ?></span></label>

                    <div class="col-sm-10">

                      <input type="text" name="service_description[<?php echo $language['language_id']; ?>][tag]" value="<?php echo isset($service_description[$language['language_id']]) ? $service_description[$language['language_id']]['tag'] : ''; ?>" placeholder="<?php echo $entry_tag; ?>" id="input-tag<?php echo $language['language_id']; ?>" class="form-control" />

                    </div>

                  </div>

                </div>

                <?php } ?>

              </div>

            </div>

            <div class="tab-pane" id="tab-data">

              <div class="form-group required">

                <label class="col-sm-2 control-label" for="input-model"><?php echo $entry_model; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="model" value="<?php echo $model; ?>" placeholder="<?php echo $entry_model; ?>" id="input-model" class="form-control" />

                  <?php if ($error_model) { ?>

                  <div class="text-danger"><?php echo $error_model; ?></div>

                  <?php } ?>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-sku"><span data-toggle="tooltip" title="<?php echo $help_sku; ?>"><?php echo $entry_sku; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="sku" value="<?php echo $sku; ?>" placeholder="<?php echo $entry_sku; ?>" id="input-sku" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-upc"><span data-toggle="tooltip" title="<?php echo $help_upc; ?>"><?php echo $entry_upc; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="upc" value="<?php echo $upc; ?>" placeholder="<?php echo $entry_upc; ?>" id="input-upc" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-ean"><span data-toggle="tooltip" title="<?php echo $help_ean; ?>"><?php echo $entry_ean; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="ean" value="<?php echo $ean; ?>" placeholder="<?php echo $entry_ean; ?>" id="input-ean" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-jan"><span data-toggle="tooltip" title="<?php echo $help_jan; ?>"><?php echo $entry_jan; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="jan" value="<?php echo $jan; ?>" placeholder="<?php echo $entry_jan; ?>" id="input-jan" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-isbn"><span data-toggle="tooltip" title="<?php echo $help_isbn; ?>"><?php echo $entry_isbn; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="isbn" value="<?php echo $isbn; ?>" placeholder="<?php echo $entry_isbn; ?>" id="input-isbn" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-mpn"><span data-toggle="tooltip" title="<?php echo $help_mpn; ?>"><?php echo $entry_mpn; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="mpn" value="<?php echo $mpn; ?>" placeholder="<?php echo $entry_mpn; ?>" id="input-mpn" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-location"><?php echo $entry_location; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="location" value="<?php echo $location; ?>" placeholder="<?php echo $entry_location; ?>" id="input-location" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-price"><?php echo $entry_price; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="price" value="<?php echo $price; ?>" placeholder="<?php echo $entry_price; ?>" id="input-price" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-tax-class"><?php echo $entry_tax_class; ?></label>

                <div class="col-sm-10">

                  <select name="tax_class_id" id="input-tax-class" class="form-control">

                    <option value="0"><?php echo $text_none; ?></option>

                    <?php foreach ($tax_classes as $tax_class) { ?>

                    <?php if ($tax_class['tax_class_id'] == $tax_class_id) { ?>

                    <option value="<?php echo $tax_class['tax_class_id']; ?>" selected="selected"><?php echo $tax_class['title']; ?></option>

                    <?php } else { ?>

                    <option value="<?php echo $tax_class['tax_class_id']; ?>"><?php echo $tax_class['title']; ?></option>

                    <?php } ?>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-quantity"><?php echo $entry_quantity; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="quantity" value="<?php echo $quantity; ?>" placeholder="<?php echo $entry_quantity; ?>" id="input-quantity" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-minimum"><span data-toggle="tooltip" title="<?php echo $help_minimum; ?>"><?php echo $entry_minimum; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="minimum" value="<?php echo $minimum; ?>" placeholder="<?php echo $entry_minimum; ?>" id="input-minimum" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-subtract"><?php echo $entry_subtract; ?></label>

                <div class="col-sm-10">

                  <select name="subtract" id="input-subtract" class="form-control">

                    <?php if ($subtract) { ?>

                    <option value="1" selected="selected"><?php echo $text_yes; ?></option>

                    <option value="0"><?php echo $text_no; ?></option>

                    <?php } else { ?>

                    <option value="1"><?php echo $text_yes; ?></option>

                    <option value="0" selected="selected"><?php echo $text_no; ?></option>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-stock-status"><span data-toggle="tooltip" title="<?php echo $help_stock_status; ?>"><?php echo $entry_stock_status; ?></span></label>

                <div class="col-sm-10">

                  <select name="stock_status_id" id="input-stock-status" class="form-control">

                    <?php foreach ($stock_statuses as $stock_status) { ?>

                    <?php if ($stock_status['stock_status_id'] == $stock_status_id) { ?>

                    <option value="<?php echo $stock_status['stock_status_id']; ?>" selected="selected"><?php echo $stock_status['name']; ?></option>

                    <?php } else { ?>

                    <option value="<?php echo $stock_status['stock_status_id']; ?>"><?php echo $stock_status['name']; ?></option>

                    <?php } ?>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label"><?php echo $entry_shipping; ?></label>

                <div class="col-sm-10">

                  <label class="radio-inline">

                    <?php if ($shipping) { ?>

                    <input type="radio" name="shipping" value="1" checked="checked" />

                    <?php echo $text_yes; ?>

                    <?php } else { ?>

                    <input type="radio" name="shipping" value="1" />

                    <?php echo $text_yes; ?>

                    <?php } ?>

                  </label>

                  <label class="radio-inline">

                    <?php if (!$shipping) { ?>

                    <input type="radio" name="shipping" value="0" checked="checked" />

                    <?php echo $text_no; ?>

                    <?php } else { ?>

                    <input type="radio" name="shipping" value="0" />

                    <?php echo $text_no; ?>

                    <?php } ?>

                  </label>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />

                  <?php if ($error_keyword) { ?>

                  <div class="text-danger"><?php echo $error_keyword; ?></div>

                  <?php } ?>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-date-available"><?php echo $entry_date_available; ?></label>

                <div class="col-sm-3">

                  <div class="input-group date">

                    <input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />

                    <span class="input-group-btn">

                    <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                    </span></div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-length"><?php echo $entry_dimension; ?></label>

                <div class="col-sm-10">

                  <div class="row">

                    <div class="col-sm-4">

                      <input type="text" name="length" value="<?php echo $length; ?>" placeholder="<?php echo $entry_length; ?>" id="input-length" class="form-control" />

                    </div>

                    <div class="col-sm-4">

                      <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />

                    </div>

                    <div class="col-sm-4">

                      <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />

                    </div>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-length-class"><?php echo $entry_length_class; ?></label>

                <div class="col-sm-10">

                  <select name="length_class_id" id="input-length-class" class="form-control">

                    <?php foreach ($length_classes as $length_class) { ?>

                    <?php if ($length_class['length_class_id'] == $length_class_id) { ?>

                    <option value="<?php echo $length_class['length_class_id']; ?>" selected="selected"><?php echo $length_class['title']; ?></option>

                    <?php } else { ?>

                    <option value="<?php echo $length_class['length_class_id']; ?>"><?php echo $length_class['title']; ?></option>

                    <?php } ?>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-weight"><?php echo $entry_weight; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="weight" value="<?php echo $weight; ?>" placeholder="<?php echo $entry_weight; ?>" id="input-weight" class="form-control" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-weight-class"><?php echo $entry_weight_class; ?></label>

                <div class="col-sm-10">

                  <select name="weight_class_id" id="input-weight-class" class="form-control">

                    <?php foreach ($weight_classes as $weight_class) { ?>

                    <?php if ($weight_class['weight_class_id'] == $weight_class_id) { ?>

                    <option value="<?php echo $weight_class['weight_class_id']; ?>" selected="selected"><?php echo $weight_class['title']; ?></option>

                    <?php } else { ?>

                    <option value="<?php echo $weight_class['weight_class_id']; ?>"><?php echo $weight_class['title']; ?></option>

                    <?php } ?>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>

                <div class="col-sm-10">

                  <select name="status" id="input-status" class="form-control">

                    <?php if ($status) { ?>

                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>

                    <option value="0"><?php echo $text_disabled; ?></option>

                    <?php } else { ?>

                    <option value="1"><?php echo $text_enabled; ?></option>

                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>

                    <?php } ?>

                  </select>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>

                <div class="col-sm-10">

                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />

                </div>

              </div>

            </div>

            <div class="tab-pane" id="tab-links">

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-manufacturersev"><span data-toggle="tooltip" title="<?php echo $help_manufacturersev; ?>"><?php echo $entry_manufacturersev; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="manufacturersev" value="<?php echo $manufacturersev; ?>" placeholder="<?php echo $entry_manufacturersev; ?>" id="input-manufacturersev" class="form-control" />

                  <input type="hidden" name="manufacturersev_id" value="<?php echo $manufacturersev_id; ?>" />

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-categorysev"><span data-toggle="tooltip" title="<?php echo $help_categorysev; ?>"><?php echo $entry_categorysev; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="categorysev" value="" placeholder="<?php echo $entry_categorysev; ?>" id="input-categorysev" class="form-control" />

                  <div id="service-categorysev" class="well well-sm" style="height: 150px; overflow: auto;">

                    <?php foreach ($service_categories as $service_categorysev) { ?>

                    <div id="service-categorysev<?php echo $service_categorysev['categorysev_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $service_categorysev['name']; ?>

                      <input type="hidden" name="service_categorysev[]" value="<?php echo $service_categorysev['categorysev_id']; ?>" />

                    </div>

                    <?php } ?>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />

                  <div id="service-filter" class="well well-sm" style="height: 150px; overflow: auto;">

                    <?php foreach ($service_filters as $service_filter) { ?>

                    <div id="service-filter<?php echo $service_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $service_filter['name']; ?>

                      <input type="hidden" name="service_filter[]" value="<?php echo $service_filter['filter_id']; ?>" />

                    </div>

                    <?php } ?>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>

                <div class="col-sm-10">

                  <div class="well well-sm" style="height: 150px; overflow: auto;">

                    <div class="checkbox">

                      <label>

                        <?php if (in_array(0, $service_store)) { ?>

                        <input type="checkbox" name="service_store[]" value="0" checked="checked" />

                        <?php echo $text_default; ?>

                        <?php } else { ?>

                        <input type="checkbox" name="service_store[]" value="0" />

                        <?php echo $text_default; ?>

                        <?php } ?>

                      </label>

                    </div>

                    <?php foreach ($stores as $store) { ?>

                    <div class="checkbox">

                      <label>

                        <?php if (in_array($store['store_id'], $service_store)) { ?>

                        <input type="checkbox" name="service_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />

                        <?php echo $store['name']; ?>

                        <?php } else { ?>

                        <input type="checkbox" name="service_store[]" value="<?php echo $store['store_id']; ?>" />

                        <?php echo $store['name']; ?>

                        <?php } ?>

                      </label>

                    </div>

                    <?php } ?>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-download"><span data-toggle="tooltip" title="<?php echo $help_download; ?>"><?php echo $entry_download; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="download" value="" placeholder="<?php echo $entry_download; ?>" id="input-download" class="form-control" />

                  <div id="service-download" class="well well-sm" style="height: 150px; overflow: auto;">

                    <?php foreach ($service_downloads as $service_download) { ?>

                    <div id="service-download<?php echo $service_download['download_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $service_download['name']; ?>

                      <input type="hidden" name="service_download[]" value="<?php echo $service_download['download_id']; ?>" />

                    </div>

                    <?php } ?>

                  </div>

                </div>

              </div>

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="related" value="" placeholder="<?php echo $entry_related; ?>" id="input-related" class="form-control" />

                  <div id="service-related" class="well well-sm" style="height: 150px; overflow: auto;">

                    <?php foreach ($service_relateds as $service_related) { ?>

                    <div id="service-related<?php echo $service_related['service_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $service_related['name']; ?>

                      <input type="hidden" name="service_related[]" value="<?php echo $service_related['service_id']; ?>" />

                    </div>

                    <?php } ?>

                  </div>

                </div>

              </div>

            </div>

            <div class="tab-pane" id="tab-attributesev">

              <div class="table-responsive">

                <table id="attributesev" class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_attributesev; ?></td>

                      <td class="text-left"><?php echo $entry_text; ?></td>

                      <td></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php $attributesev_row = 0; ?>

                    <?php foreach ($service_attributesevs as $service_attributesev) { ?>

                    <tr id="attributesev-row<?php echo $attributesev_row; ?>">

                      <td class="text-left" style="width: 40%;"><input type="text" name="service_attributesev[<?php echo $attributesev_row; ?>][name]" value="<?php echo $service_attributesev['name']; ?>" placeholder="<?php echo $entry_attributesev; ?>" class="form-control" />

                        <input type="hidden" name="service_attributesev[<?php echo $attributesev_row; ?>][attributesev_id]" value="<?php echo $service_attributesev['attributesev_id']; ?>" /></td>

                      <td class="text-left"><?php foreach ($languages as $language) { ?>

                        <div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span>

                          <textarea name="service_attributesev[<?php echo $attributesev_row; ?>][service_attributesev_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"><?php echo isset($service_attributesev['service_attributesev_description'][$language['language_id']]) ? $service_attributesev['service_attributesev_description'][$language['language_id']]['text'] : ''; ?></textarea>

                        </div>

                        <?php } ?></td>

                      <td class="text-left"><button type="button" onclick="$('#attributesev-row<?php echo $attributesev_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                    </tr>

                    <?php $attributesev_row++; ?>

                    <?php } ?>

                  </tbody>

                  <tfoot>

                    <tr>

                      <td colspan="2"></td>

                      <td class="text-left"><button type="button" onclick="addAttribute();" data-toggle="tooltip" title="<?php echo $button_attributesev_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                    </tr>

                  </tfoot>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-optionsev">

              <div class="row">

                <div class="col-sm-2">

                  <ul class="nav nav-pills nav-stacked" id="optionsev">

                    <?php $optionsev_row = 0; ?>

                    <?php foreach ($service_optionsevs as $service_optionsev) { ?>

                    <li><a href="#tab-optionsev<?php echo $optionsev_row; ?>" data-toggle="tab"><i class="fa fa-minus-circle" onclick="$('a[href=\'#tab-optionsev<?php echo $optionsev_row; ?>\']').parent().remove(); $('#tab-optionsev<?php echo $optionsev_row; ?>').remove(); $('#optionsev a:first').tab('show');"></i> <?php echo $service_optionsev['name']; ?></a></li>

                    <?php $optionsev_row++; ?>

                    <?php } ?>

                    <li>

                      <input type="text" name="optionsev" value="" placeholder="<?php echo $entry_optionsev; ?>" id="input-optionsev" class="form-control" />

                    </li>

                  </ul>

                </div>

                <div class="col-sm-10">

                  <div class="tab-content">

                    <?php $optionsev_row = 0; ?>

                    <?php $optionsev_value_row = 0; ?>

                    <?php foreach ($service_optionsevs as $service_optionsev) { ?>

                    <div class="tab-pane" id="tab-optionsev<?php echo $optionsev_row; ?>">

                      <input type="hidden" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_id]" value="<?php echo $service_optionsev['service_optionsev_id']; ?>" />

                      <input type="hidden" name="service_optionsev[<?php echo $optionsev_row; ?>][name]" value="<?php echo $service_optionsev['name']; ?>" />

                      <input type="hidden" name="service_optionsev[<?php echo $optionsev_row; ?>][optionsev_id]" value="<?php echo $service_optionsev['optionsev_id']; ?>" />

                      <input type="hidden" name="service_optionsev[<?php echo $optionsev_row; ?>][type]" value="<?php echo $service_optionsev['type']; ?>" />

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-required<?php echo $optionsev_row; ?>"><?php echo $entry_required; ?></label>

                        <div class="col-sm-10">

                          <select name="service_optionsev[<?php echo $optionsev_row; ?>][required]" id="input-required<?php echo $optionsev_row; ?>" class="form-control">

                            <?php if ($service_optionsev['required']) { ?>

                            <option value="1" selected="selected"><?php echo $text_yes; ?></option>

                            <option value="0"><?php echo $text_no; ?></option>

                            <?php } else { ?>

                            <option value="1"><?php echo $text_yes; ?></option>

                            <option value="0" selected="selected"><?php echo $text_no; ?></option>

                            <?php } ?>

                          </select>

                        </div>

                      </div>

                      <?php if ($service_optionsev['type'] == 'text') { ?>

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-10">

                          <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][value]" value="<?php echo $service_optionsev['value']; ?>" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value<?php echo $optionsev_row; ?>" class="form-control" />

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'textarea') { ?>

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-10">

                          <textarea name="service_optionsev[<?php echo $optionsev_row; ?>][value]" rows="5" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value<?php echo $optionsev_row; ?>" class="form-control"><?php echo $service_optionsev['value']; ?></textarea>

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'file') { ?>

                      <div class="form-group" style="display: none;">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-10">

                          <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][value]" value="<?php echo $service_optionsev['value']; ?>" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value<?php echo $optionsev_row; ?>" class="form-control" />

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'date') { ?>

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-3">

                          <div class="input-group date">

                            <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][value]" value="<?php echo $service_optionsev['value']; ?>" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="YYYY-MM-DD" id="input-value<?php echo $optionsev_row; ?>" class="form-control" />

                            <span class="input-group-btn">

                            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                            </span></div>

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'time') { ?>

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-10">

                          <div class="input-group time">

                            <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][value]" value="<?php echo $service_optionsev['value']; ?>" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="HH:mm" id="input-value<?php echo $optionsev_row; ?>" class="form-control" />

                            <span class="input-group-btn">

                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>

                            </span></div>

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'datetime') { ?>

                      <div class="form-group">

                        <label class="col-sm-2 control-label" for="input-value<?php echo $optionsev_row; ?>"><?php echo $entry_optionsev_value; ?></label>

                        <div class="col-sm-10">

                          <div class="input-group datetime">

                            <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][value]" value="<?php echo $service_optionsev['value']; ?>" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value<?php echo $optionsev_row; ?>" class="form-control" />

                            <span class="input-group-btn">

                            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>

                            </span></div>

                        </div>

                      </div>

                      <?php } ?>

                      <?php if ($service_optionsev['type'] == 'select' || $service_optionsev['type'] == 'radio' || $service_optionsev['type'] == 'checkbox' || $service_optionsev['type'] == 'image') { ?>

                      <div class="table-responsive">

                        <table id="optionsev-value<?php echo $optionsev_row; ?>" class="table table-striped table-bordered table-hover">

                          <thead>

                            <tr>

                              <td class="text-left"><?php echo $entry_optionsev_value; ?></td>

                              <td class="text-right"><?php echo $entry_quantity; ?></td>

                              <td class="text-left"><?php echo $entry_subtract; ?></td>

                              <td class="text-right"><?php echo $entry_price; ?></td>

                              <td class="text-right"><?php echo $entry_optionsev_points; ?></td>

                              <td class="text-right"><?php echo $entry_weight; ?></td>

                              <td></td>

                            </tr>

                          </thead>

                          <tbody>

                            <?php foreach ($service_optionsev['service_optionsev_value'] as $service_optionsev_value) { ?>

                            <tr id="optionsev-value-row<?php echo $optionsev_value_row; ?>">

                              <td class="text-left"><select name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][optionsev_value_id]" class="form-control">

                                  <?php if (isset($optionsev_values[$service_optionsev['optionsev_id']])) { ?>

                                  <?php foreach ($optionsev_values[$service_optionsev['optionsev_id']] as $optionsev_value) { ?>

                                  <?php if ($optionsev_value['optionsev_value_id'] == $service_optionsev_value['optionsev_value_id']) { ?>

                                  <option value="<?php echo $optionsev_value['optionsev_value_id']; ?>" selected="selected"><?php echo $optionsev_value['name']; ?></option>

                                  <?php } else { ?>

                                  <option value="<?php echo $optionsev_value['optionsev_value_id']; ?>"><?php echo $optionsev_value['name']; ?></option>

                                  <?php } ?>

                                  <?php } ?>

                                  <?php } ?>

                                </select>

                                <input type="hidden" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][service_optionsev_value_id]" value="<?php echo $service_optionsev_value['service_optionsev_value_id']; ?>" /></td>

                              <td class="text-right"><input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][quantity]" value="<?php echo $service_optionsev_value['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>

                              <td class="text-left"><select name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][subtract]" class="form-control">

                                  <?php if ($service_optionsev_value['subtract']) { ?>

                                  <option value="1" selected="selected"><?php echo $text_yes; ?></option>

                                  <option value="0"><?php echo $text_no; ?></option>

                                  <?php } else { ?>

                                  <option value="1"><?php echo $text_yes; ?></option>

                                  <option value="0" selected="selected"><?php echo $text_no; ?></option>

                                  <?php } ?>

                                </select></td>

                              <td class="text-right"><select name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][price_prefix]" class="form-control">

                                  <?php if ($service_optionsev_value['price_prefix'] == '+') { ?>

                                  <option value="+" selected="selected">+</option>

                                  <?php } else { ?>

                                  <option value="+">+</option>

                                  <?php } ?>

                                  <?php if ($service_optionsev_value['price_prefix'] == '-') { ?>

                                  <option value="-" selected="selected">-</option>

                                  <?php } else { ?>

                                  <option value="-">-</option>

                                  <?php } ?>

                                </select>

                                <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][price]" value="<?php echo $service_optionsev_value['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>

                              <td class="text-right"><select name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][points_prefix]" class="form-control">

                                  <?php if ($service_optionsev_value['points_prefix'] == '+') { ?>

                                  <option value="+" selected="selected">+</option>

                                  <?php } else { ?>

                                  <option value="+">+</option>

                                  <?php } ?>

                                  <?php if ($service_optionsev_value['points_prefix'] == '-') { ?>

                                  <option value="-" selected="selected">-</option>

                                  <?php } else { ?>

                                  <option value="-">-</option>

                                  <?php } ?>

                                </select>

                                <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][points]" value="<?php echo $service_optionsev_value['points']; ?>" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>

                              <td class="text-right"><select name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][weight_prefix]" class="form-control">

                                  <?php if ($service_optionsev_value['weight_prefix'] == '+') { ?>

                                  <option value="+" selected="selected">+</option>

                                  <?php } else { ?>

                                  <option value="+">+</option>

                                  <?php } ?>

                                  <?php if ($service_optionsev_value['weight_prefix'] == '-') { ?>

                                  <option value="-" selected="selected">-</option>

                                  <?php } else { ?>

                                  <option value="-">-</option>

                                  <?php } ?>

                                </select>

                                <input type="text" name="service_optionsev[<?php echo $optionsev_row; ?>][service_optionsev_value][<?php echo $optionsev_value_row; ?>][weight]" value="<?php echo $service_optionsev_value['weight']; ?>" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>

                              <td class="text-left"><button type="button" onclick="$(this).tooltip('destroy');$('#optionsev-value-row<?php echo $optionsev_value_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                            </tr>

                            <?php $optionsev_value_row++; ?>

                            <?php } ?>

                          </tbody>

                          <tfoot>

                            <tr>

                              <td colspan="6"></td>

                              <td class="text-left"><button type="button" onclick="addOptionValue('<?php echo $optionsev_row; ?>');" data-toggle="tooltip" title="<?php echo $button_optionsev_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                            </tr>

                          </tfoot>

                        </table>

                      </div>

                      <select id="optionsev-values<?php echo $optionsev_row; ?>" style="display: none;">

                        <?php if (isset($optionsev_values[$service_optionsev['optionsev_id']])) { ?>

                        <?php foreach ($optionsev_values[$service_optionsev['optionsev_id']] as $optionsev_value) { ?>

                        <option value="<?php echo $optionsev_value['optionsev_value_id']; ?>"><?php echo $optionsev_value['name']; ?></option>

                        <?php } ?>

                        <?php } ?>

                      </select>

                      <?php } ?>

                    </div>

                    <?php $optionsev_row++; ?>

                    <?php } ?>

                  </div>

                </div>

              </div>

            </div>

            <div class="tab-pane" id="tab-recurring">

              <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_recurring; ?></td>

                      <td class="text-left"><?php echo $entry_customer_group; ?></td>

                      <td class="text-left"></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php $recurring_row = 0; ?>

                    <?php foreach ($service_recurrings as $service_recurring) { ?>



                    <tr id="recurring-row<?php echo $recurring_row; ?>">

                      <td class="text-left"><select name="service_recurring[<?php echo $recurring_row; ?>][recurring_id]" class="form-control">

                          <?php foreach ($recurrings as $recurring) { ?>

                          <?php if ($recurring['recurring_id'] == $service_recurring['recurring_id']) { ?>

                          <option value="<?php echo $recurring['recurring_id']; ?>" selected="selected"><?php echo $recurring['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                      <td class="text-left"><select name="service_recurring[<?php echo $recurring_row; ?>][customer_group_id]" class="form-control">

                          <?php foreach ($customer_groups as $customer_group) { ?>

                          <?php if ($customer_group['customer_group_id'] == $service_recurring['customer_group_id']) { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                      <td class="text-left"><button type="button" onclick="$('#recurring-row<?php echo $recurring_row; ?>').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                    </tr>

                    <?php $recurring_row++; ?>

                    <?php } ?>

                  </tbody>

                  <tfoot>

                    <tr>

                      <td colspan="2"></td>

                      <td class="text-left"><button type="button" onclick="addRecurring()" data-toggle="tooltip" title="<?php echo $button_recurring_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                    </tr>

                  </tfoot>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-discount">

              <div class="table-responsive">

                <table id="discount" class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_customer_group; ?></td>

                      <td class="text-right"><?php echo $entry_quantity; ?></td>

                      <td class="text-right"><?php echo $entry_priority; ?></td>

                      <td class="text-right"><?php echo $entry_price; ?></td>

                      <td class="text-left"><?php echo $entry_date_start; ?></td>

                      <td class="text-left"><?php echo $entry_date_end; ?></td>

                      <td></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php $discount_row = 0; ?>

                    <?php foreach ($service_discounts as $service_discount) { ?>

                    <tr id="discount-row<?php echo $discount_row; ?>">

                      <td class="text-left"><select name="service_discount[<?php echo $discount_row; ?>][customer_group_id]" class="form-control">

                          <?php foreach ($customer_groups as $customer_group) { ?>

                          <?php if ($customer_group['customer_group_id'] == $service_discount['customer_group_id']) { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                      <td class="text-right"><input type="text" name="service_discount[<?php echo $discount_row; ?>][quantity]" value="<?php echo $service_discount['quantity']; ?>" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>

                      <td class="text-right"><input type="text" name="service_discount[<?php echo $discount_row; ?>][priority]" value="<?php echo $service_discount['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>

                      <td class="text-right"><input type="text" name="service_discount[<?php echo $discount_row; ?>][price]" value="<?php echo $service_discount['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>

                      <td class="text-left" style="width: 20%;"><div class="input-group date">

                          <input type="text" name="service_discount[<?php echo $discount_row; ?>][date_start]" value="<?php echo $service_discount['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />

                          <span class="input-group-btn">

                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                          </span></div></td>

                      <td class="text-left" style="width: 20%;"><div class="input-group date">

                          <input type="text" name="service_discount[<?php echo $discount_row; ?>][date_end]" value="<?php echo $service_discount['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />

                          <span class="input-group-btn">

                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                          </span></div></td>

                      <td class="text-left"><button type="button" onclick="$('#discount-row<?php echo $discount_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                    </tr>

                    <?php $discount_row++; ?>

                    <?php } ?>

                  </tbody>

                  <tfoot>

                    <tr>

                      <td colspan="6"></td>

                      <td class="text-left"><button type="button" onclick="addDiscount();" data-toggle="tooltip" title="<?php echo $button_discount_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                    </tr>

                  </tfoot>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-special">

              <div class="table-responsive">

                <table id="special" class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_customer_group; ?></td>

                      <td class="text-right"><?php echo $entry_priority; ?></td>

                      <td class="text-right"><?php echo $entry_price; ?></td>

                      <td class="text-left"><?php echo $entry_date_start; ?></td>

                      <td class="text-left"><?php echo $entry_date_end; ?></td>

                      <td></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php $special_row = 0; ?>

                    <?php foreach ($service_specials as $service_special) { ?>

                    <tr id="special-row<?php echo $special_row; ?>">

                      <td class="text-left"><select name="service_special[<?php echo $special_row; ?>][customer_group_id]" class="form-control">

                          <?php foreach ($customer_groups as $customer_group) { ?>

                          <?php if ($customer_group['customer_group_id'] == $service_special['customer_group_id']) { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>" selected="selected"><?php echo $customer_group['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                      <td class="text-right"><input type="text" name="service_special[<?php echo $special_row; ?>][priority]" value="<?php echo $service_special['priority']; ?>" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>

                      <td class="text-right"><input type="text" name="service_special[<?php echo $special_row; ?>][price]" value="<?php echo $service_special['price']; ?>" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>

                      <td class="text-left" style="width: 20%;"><div class="input-group date">

                          <input type="text" name="service_special[<?php echo $special_row; ?>][date_start]" value="<?php echo $service_special['date_start']; ?>" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" />

                          <span class="input-group-btn">

                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                          </span></div></td>

                      <td class="text-left" style="width: 20%;"><div class="input-group date">

                          <input type="text" name="service_special[<?php echo $special_row; ?>][date_end]" value="<?php echo $service_special['date_end']; ?>" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" />

                          <span class="input-group-btn">

                          <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>

                          </span></div></td>

                      <td class="text-left"><button type="button" onclick="$('#special-row<?php echo $special_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                    </tr>

                    <?php $special_row++; ?>

                    <?php } ?>

                  </tbody>

                  <tfoot>

                    <tr>

                      <td colspan="5"></td>

                      <td class="text-left"><button type="button" onclick="addSpecial();" data-toggle="tooltip" title="<?php echo $button_special_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                    </tr>

                  </tfoot>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-image">

              <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_image; ?></td>

                    </tr>

                  </thead>

                  

                  <tbody>

                    <tr>

                      <td class="text-left"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /></td>

                  </tr>

                  </tbody>

                </table>

              </div>

              <div class="table-responsive">

                <table id="images" class="table table-striped table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_additional_image; ?></td>

                      <td class="text-right"><?php echo $entry_sort_order; ?></td>

                      <td></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php $image_row = 0; ?>

                    <?php foreach ($service_images as $service_image) { ?>

                    <tr id="image-row<?php echo $image_row; ?>">

                      <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $service_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="service_image[<?php echo $image_row; ?>][image]" value="<?php echo $service_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>

                      <td class="text-right"><input type="text" name="service_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $service_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>

                      <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>

                    </tr>

                    <?php $image_row++; ?>

                    <?php } ?>

                  </tbody>

                  <tfoot>

                    <tr>

                      <td colspan="2"></td>

                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="<?php echo $button_image_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>

                    </tr>

                  </tfoot>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-reward">

              <div class="form-group">

                <label class="col-sm-2 control-label" for="input-points"><span data-toggle="tooltip" title="<?php echo $help_points; ?>"><?php echo $entry_points; ?></span></label>

                <div class="col-sm-10">

                  <input type="text" name="points" value="<?php echo $points; ?>" placeholder="<?php echo $entry_points; ?>" id="input-points" class="form-control" />

                </div>

              </div>

              <div class="table-responsive">

                <table class="table table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_customer_group; ?></td>

                      <td class="text-right"><?php echo $entry_reward; ?></td>

                    </tr>

                  </thead>

                  <tbody>

                    <?php foreach ($customer_groups as $customer_group) { ?>

                    <tr>

                      <td class="text-left"><?php echo $customer_group['name']; ?></td>

                      <td class="text-right"><input type="text" name="service_reward[<?php echo $customer_group['customer_group_id']; ?>][points]" value="<?php echo isset($service_reward[$customer_group['customer_group_id']]) ? $service_reward[$customer_group['customer_group_id']]['points'] : ''; ?>" class="form-control" /></td>

                    </tr>

                    <?php } ?>

                  </tbody>

                </table>

              </div>

            </div>

            <div class="tab-pane" id="tab-design">

              <div class="table-responsive">

                <table class="table table-bordered table-hover">

                  <thead>

                    <tr>

                      <td class="text-left"><?php echo $entry_store; ?></td>

                      <td class="text-left"><?php echo $entry_layout; ?></td>

                    </tr>

                  </thead>

                  <tbody>

                    <tr>

                      <td class="text-left"><?php echo $text_default; ?></td>

                      <td class="text-left"><select name="service_layout[0]" class="form-control">

                          <option value=""></option>

                          <?php foreach ($layouts as $layout) { ?>

                          <?php if (isset($service_layout[0]) && $service_layout[0] == $layout['layout_id']) { ?>

                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                    </tr>

                    <?php foreach ($stores as $store) { ?>

                    <tr>

                      <td class="text-left"><?php echo $store['name']; ?></td>

                      <td class="text-left"><select name="service_layout[<?php echo $store['store_id']; ?>]" class="form-control">

                          <option value=""></option>

                          <?php foreach ($layouts as $layout) { ?>

                          <?php if (isset($service_layout[$store['store_id']]) && $service_layout[$store['store_id']] == $layout['layout_id']) { ?>

                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>

                          <?php } else { ?>

                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>

                          <?php } ?>

                          <?php } ?>

                        </select></td>

                    </tr>

                    <?php } ?>

                  </tbody>

                </table>

              </div>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

    <link href="view/javascript/codemirror/lib/codemirror.css" rel="stylesheet" />
    <link href="view/javascript/codemirror/theme/monokai.css" rel="stylesheet" />
    <script type="text/javascript" src="view/javascript/codemirror/lib/codemirror.js"></script>
    <script type="text/javascript" src="view/javascript/codemirror/lib/xml.js"></script>
    <script type="text/javascript" src="view/javascript/codemirror/lib/formatting.js"></script>
    <script type="text/javascript" src="view/javascript/summernote/summernote.js"></script>
    <link href="view/javascript/summernote/summernote.css" rel="stylesheet" />

    <script type="text/javascript" src="view/javascript/summernote/summernote-image-attributes.js"></script>
    <script type="text/javascript" src="view/javascript/summernote/hitech.js"></script>

  <script type="text/javascript"><!--

// Manufacturer

$('input[name=\'manufacturersev\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/manufacturersev/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				json.unshift({

					manufacturersev_id: 0,

					name: '<?php echo $text_none; ?>'

				});



				response($.map(json, function(item) {

					return {

						label: item['name'],

						value: item['manufacturersev_id']

					}

				}));

			}

		});

	},

	'select': function(item) {

		$('input[name=\'manufacturersev\']').val(item['label']);

		$('input[name=\'manufacturersev_id\']').val(item['value']);

	}

});



// Category

$('input[name=\'categorysev\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/categorysev/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				response($.map(json, function(item) {

					return {

						label: item['name'],

						value: item['categorysev_id']

					}

				}));

			}

		});

	},

	'select': function(item) {

		$('input[name=\'categorysev\']').val('');



		$('#service-categorysev' + item['value']).remove();



		$('#service-categorysev').append('<div id="service-categorysev' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="service_categorysev[]" value="' + item['value'] + '" /></div>');

	}

});



$('#service-categorysev').delegate('.fa-minus-circle', 'click', function() {

	$(this).parent().remove();

});



// Filter

$('input[name=\'filter\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				response($.map(json, function(item) {

					return {

						label: item['name'],

						value: item['filter_id']

					}

				}));

			}

		});

	},

	'select': function(item) {

		$('input[name=\'filter\']').val('');



		$('#service-filter' + item['value']).remove();



		$('#service-filter').append('<div id="service-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="service_filter[]" value="' + item['value'] + '" /></div>');

	}

});



$('#service-filter').delegate('.fa-minus-circle', 'click', function() {

	$(this).parent().remove();

});



// Downloads

$('input[name=\'download\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/download/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				response($.map(json, function(item) {

					return {

						label: item['name'],

						value: item['download_id']

					}

				}));

			}

		});

	},

	'select': function(item) {

		$('input[name=\'download\']').val('');



		$('#service-download' + item['value']).remove();



		$('#service-download').append('<div id="service-download' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="service_download[]" value="' + item['value'] + '" /></div>');

	}

});



$('#service-download').delegate('.fa-minus-circle', 'click', function() {

	$(this).parent().remove();

});



// Related

$('input[name=\'related\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/service/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				response($.map(json, function(item) {

					return {

						label: item['name'],

						value: item['service_id']

					}

				}));

			}

		});

	},

	'select': function(item) {

		$('input[name=\'related\']').val('');



		$('#service-related' + item['value']).remove();



		$('#service-related').append('<div id="service-related' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="service_related[]" value="' + item['value'] + '" /></div>');

	}

});



$('#service-related').delegate('.fa-minus-circle', 'click', function() {

	$(this).parent().remove();

});

//--></script>

  <script type="text/javascript"><!--

var attributesev_row = <?php echo $attributesev_row; ?>;



function addAttribute() {

    html  = '<tr id="attributesev-row' + attributesev_row + '">';

	html += '  <td class="text-left" style="width: 20%;"><input type="text" name="service_attributesev[' + attributesev_row + '][name]" value="" placeholder="<?php echo $entry_attributesev; ?>" class="form-control" /><input type="hidden" name="service_attributesev[' + attributesev_row + '][attributesev_id]" value="" /></td>';

	html += '  <td class="text-left">';

	<?php foreach ($languages as $language) { ?>

	html += '<div class="input-group"><span class="input-group-addon"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /></span><textarea name="service_attributesev[' + attributesev_row + '][service_attributesev_description][<?php echo $language['language_id']; ?>][text]" rows="5" placeholder="<?php echo $entry_text; ?>" class="form-control"></textarea></div>';

    <?php } ?>

	html += '  </td>';

	html += '  <td class="text-left"><button type="button" onclick="$(\'#attributesev-row' + attributesev_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

    html += '</tr>';



	$('#attributesev tbody').append(html);



	attributesevautocomplete(attributesev_row);



	attributesev_row++;

}



function attributesevautocomplete(attributesev_row) {

	$('input[name=\'service_attributesev[' + attributesev_row + '][name]\']').autocomplete({

		'source': function(request, response) {

			$.ajax({

				url: 'index.php?routes=catalog/attributesev/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

				dataType: 'json',

				success: function(json) {

					response($.map(json, function(item) {

						return {

							categorysev: item.attributesev_group,

							label: item.name,

							value: item.attributesev_id

						}

					}));

				}

			});

		},

		'select': function(item) {

			$('input[name=\'service_attributesev[' + attributesev_row + '][name]\']').val(item['label']);

			$('input[name=\'service_attributesev[' + attributesev_row + '][attributesev_id]\']').val(item['value']);

		}

	});

}



$('#attributesev tbody tr').each(function(index, element) {

	attributesevautocomplete(index);

});

//--></script>

  <script type="text/javascript"><!--

var optionsev_row = <?php echo $optionsev_row; ?>;



$('input[name=\'optionsev\']').autocomplete({

	'source': function(request, response) {

		$.ajax({

			url: 'index.php?routes=catalog/optionsev/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),

			dataType: 'json',

			success: function(json) {

				response($.map(json, function(item) {

					return {

						categorysev: item['categorysev'],

						label: item['name'],

						value: item['optionsev_id'],

						type: item['type'],

						optionsev_value: item['optionsev_value']

					}

				}));

			}

		});

	},

	'select': function(item) {

		html  = '<div class="tab-pane" id="tab-optionsev' + optionsev_row + '">';

		html += '	<input type="hidden" name="service_optionsev[' + optionsev_row + '][service_optionsev_id]" value="" />';

		html += '	<input type="hidden" name="service_optionsev[' + optionsev_row + '][name]" value="' + item['label'] + '" />';

		html += '	<input type="hidden" name="service_optionsev[' + optionsev_row + '][optionsev_id]" value="' + item['value'] + '" />';

		html += '	<input type="hidden" name="service_optionsev[' + optionsev_row + '][type]" value="' + item['type'] + '" />';



		html += '	<div class="form-group">';

		html += '	  <label class="col-sm-2 control-label" for="input-required' + optionsev_row + '"><?php echo $entry_required; ?></label>';

		html += '	  <div class="col-sm-10"><select name="service_optionsev[' + optionsev_row + '][required]" id="input-required' + optionsev_row + '" class="form-control">';

		html += '	      <option value="1"><?php echo $text_yes; ?></option>';

		html += '	      <option value="0"><?php echo $text_no; ?></option>';

		html += '	  </select></div>';

		html += '	</div>';



		if (item['type'] == 'text') {

			html += '	<div class="form-group">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-10"><input type="text" name="service_optionsev[' + optionsev_row + '][value]" value="" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value' + optionsev_row + '" class="form-control" /></div>';

			html += '	</div>';

		}



		if (item['type'] == 'textarea') {

			html += '	<div class="form-group">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-10"><textarea name="service_optionsev[' + optionsev_row + '][value]" rows="5" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value' + optionsev_row + '" class="form-control"></textarea></div>';

			html += '	</div>';

		}



		if (item['type'] == 'file') {

			html += '	<div class="form-group" style="display: none;">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-10"><input type="text" name="service_optionsev[' + optionsev_row + '][value]" value="" placeholder="<?php echo $entry_optionsev_value; ?>" id="input-value' + optionsev_row + '" class="form-control" /></div>';

			html += '	</div>';

		}



		if (item['type'] == 'date') {

			html += '	<div class="form-group">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-3"><div class="input-group date"><input type="text" name="service_optionsev[' + optionsev_row + '][value]" value="" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="YYYY-MM-DD" id="input-value' + optionsev_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';

			html += '	</div>';

		}



		if (item['type'] == 'time') {

			html += '	<div class="form-group">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-10"><div class="input-group time"><input type="text" name="service_optionsev[' + optionsev_row + '][value]" value="" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="HH:mm" id="input-value' + optionsev_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';

			html += '	</div>';

		}



		if (item['type'] == 'datetime') {

			html += '	<div class="form-group">';

			html += '	  <label class="col-sm-2 control-label" for="input-value' + optionsev_row + '"><?php echo $entry_optionsev_value; ?></label>';

			html += '	  <div class="col-sm-10"><div class="input-group datetime"><input type="text" name="service_optionsev[' + optionsev_row + '][value]" value="" placeholder="<?php echo $entry_optionsev_value; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-value' + optionsev_row + '" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></div>';

			html += '	</div>';

		}



		if (item['type'] == 'select' || item['type'] == 'radio' || item['type'] == 'checkbox' || item['type'] == 'image') {

			html += '<div class="table-responsive">';

			html += '  <table id="optionsev-value' + optionsev_row + '" class="table table-striped table-bordered table-hover">';

			html += '  	 <thead>';

			html += '      <tr>';

			html += '        <td class="text-left"><?php echo $entry_optionsev_value; ?></td>';

			html += '        <td class="text-right"><?php echo $entry_quantity; ?></td>';

			html += '        <td class="text-left"><?php echo $entry_subtract; ?></td>';

			html += '        <td class="text-right"><?php echo $entry_price; ?></td>';

			html += '        <td class="text-right"><?php echo $entry_optionsev_points; ?></td>';

			html += '        <td class="text-right"><?php echo $entry_weight; ?></td>';

			html += '        <td></td>';

			html += '      </tr>';

			html += '  	 </thead>';

			html += '  	 <tbody>';

			html += '    </tbody>';

			html += '    <tfoot>';

			html += '      <tr>';

			html += '        <td colspan="6"></td>';

			html += '        <td class="text-left"><button type="button" onclick="addOptionValue(' + optionsev_row + ');" data-toggle="tooltip" title="<?php echo $button_optionsev_value_add; ?>" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>';

			html += '      </tr>';

			html += '    </tfoot>';

			html += '  </table>';

			html += '</div>';



            html += '  <select id="optionsev-values' + optionsev_row + '" style="display: none;">';



            for (i = 0; i < item['optionsev_value'].length; i++) {

				html += '  <option value="' + item['optionsev_value'][i]['optionsev_value_id'] + '">' + item['optionsev_value'][i]['name'] + '</option>';

            }



            html += '  </select>';

			html += '</div>';

		}



		$('#tab-optionsev .tab-content').append(html);



		$('#optionsev > li:last-child').before('<li><a href="#tab-optionsev' + optionsev_row + '" data-toggle="tab"><i class="fa fa-minus-circle" onclick=" $(\'#optionsev a:first\').tab(\'show\');$(\'a[href=\\\'#tab-optionsev' + optionsev_row + '\\\']\').parent().remove(); $(\'#tab-optionsev' + optionsev_row + '\').remove();"></i>' + item['label'] + '</li>');



		$('#optionsev a[href=\'#tab-optionsev' + optionsev_row + '\']').tab('show');

		

		$('[data-toggle=\'tooltip\']').tooltip({

			container: 'body',

			html: true

		});



		$('.date').datetimepicker({

			pickTime: false

		});



		$('.time').datetimepicker({

			pickDate: false

		});



		$('.datetime').datetimepicker({

			pickDate: true,

			pickTime: true

		});



		optionsev_row++;

	}

});

//--></script>

  <script type="text/javascript"><!--

var optionsev_value_row = <?php echo $optionsev_value_row; ?>;



function addOptionValue(optionsev_row) {

	html  = '<tr id="optionsev-value-row' + optionsev_value_row + '">';

	html += '  <td class="text-left"><select name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][optionsev_value_id]" class="form-control">';

	html += $('#optionsev-values' + optionsev_row).html();

	html += '  </select><input type="hidden" name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][service_optionsev_value_id]" value="" /></td>';

	html += '  <td class="text-right"><input type="text" name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';

	html += '  <td class="text-left"><select name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][subtract]" class="form-control">';

	html += '    <option value="1"><?php echo $text_yes; ?></option>';

	html += '    <option value="0"><?php echo $text_no; ?></option>';

	html += '  </select></td>';

	html += '  <td class="text-right"><select name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][price_prefix]" class="form-control">';

	html += '    <option value="+">+</option>';

	html += '    <option value="-">-</option>';

	html += '  </select>';

	html += '  <input type="text" name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';

	html += '  <td class="text-right"><select name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][points_prefix]" class="form-control">';

	html += '    <option value="+">+</option>';

	html += '    <option value="-">-</option>';

	html += '  </select>';

	html += '  <input type="text" name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][points]" value="" placeholder="<?php echo $entry_points; ?>" class="form-control" /></td>';

	html += '  <td class="text-right"><select name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][weight_prefix]" class="form-control">';

	html += '    <option value="+">+</option>';

	html += '    <option value="-">-</option>';

	html += '  </select>';

	html += '  <input type="text" name="service_optionsev[' + optionsev_row + '][service_optionsev_value][' + optionsev_value_row + '][weight]" value="" placeholder="<?php echo $entry_weight; ?>" class="form-control" /></td>';

	html += '  <td class="text-left"><button type="button" onclick="$(this).tooltip(\'destroy\');$(\'#optionsev-value-row' + optionsev_value_row + '\').remove();" data-toggle="tooltip" rel="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

	html += '</tr>';



	$('#optionsev-value' + optionsev_row + ' tbody').append(html);

	$('[rel=tooltip]').tooltip();



	optionsev_value_row++;

}

//--></script>

  <script type="text/javascript"><!--

var discount_row = <?php echo $discount_row; ?>;



function addDiscount() {

	html  = '<tr id="discount-row' + discount_row + '">';

    html += '  <td class="text-left"><select name="service_discount[' + discount_row + '][customer_group_id]" class="form-control">';

    <?php foreach ($customer_groups as $customer_group) { ?>

    html += '    <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';

    <?php } ?>

    html += '  </select></td>';

    html += '  <td class="text-right"><input type="text" name="service_discount[' + discount_row + '][quantity]" value="" placeholder="<?php echo $entry_quantity; ?>" class="form-control" /></td>';

    html += '  <td class="text-right"><input type="text" name="service_discount[' + discount_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';

	html += '  <td class="text-right"><input type="text" name="service_discount[' + discount_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';

    html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="service_discount[' + discount_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';

	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="service_discount[' + discount_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';

	html += '  <td class="text-left"><button type="button" onclick="$(\'#discount-row' + discount_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

	html += '</tr>';



	$('#discount tbody').append(html);



	$('.date').datetimepicker({

		pickTime: false

	});



	discount_row++;

}

//--></script>

  <script type="text/javascript"><!--

var special_row = <?php echo $special_row; ?>;



function addSpecial() {

	html  = '<tr id="special-row' + special_row + '">';

    html += '  <td class="text-left"><select name="service_special[' + special_row + '][customer_group_id]" class="form-control">';

    <?php foreach ($customer_groups as $customer_group) { ?>

    html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo addslashes($customer_group['name']); ?></option>';

    <?php } ?>

    html += '  </select></td>';

    html += '  <td class="text-right"><input type="text" name="service_special[' + special_row + '][priority]" value="" placeholder="<?php echo $entry_priority; ?>" class="form-control" /></td>';

	html += '  <td class="text-right"><input type="text" name="service_special[' + special_row + '][price]" value="" placeholder="<?php echo $entry_price; ?>" class="form-control" /></td>';

    html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="service_special[' + special_row + '][date_start]" value="" placeholder="<?php echo $entry_date_start; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';

	html += '  <td class="text-left" style="width: 20%;"><div class="input-group date"><input type="text" name="service_special[' + special_row + '][date_end]" value="" placeholder="<?php echo $entry_date_end; ?>" data-date-format="YYYY-MM-DD" class="form-control" /><span class="input-group-btn"><button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button></span></div></td>';

	html += '  <td class="text-left"><button type="button" onclick="$(\'#special-row' + special_row + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

	html += '</tr>';



	$('#special tbody').append(html);



	$('.date').datetimepicker({

		pickTime: false

	});



	special_row++;

}

//--></script>

  <script type="text/javascript"><!--

var image_row = <?php echo $image_row; ?>;



function addImage() {

	html  = '<tr id="image-row' + image_row + '">';

	html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="service_image[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';

	html += '  <td class="text-right"><input type="text" name="service_image[' + image_row + '][sort_order]" value="" placeholder="<?php echo $entry_sort_order; ?>" class="form-control" /></td>';

	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';

	html += '</tr>';



	$('#images tbody').append(html);



	image_row++;

}

//--></script>

  <script type="text/javascript"><!--

var recurring_row = <?php echo $recurring_row; ?>;



function addRecurring() {

	html  = '<tr id="recurring-row' + recurring_row + '">';

	html += '  <td class="left">';

	html += '    <select name="service_recurring[' + recurring_row + '][recurring_id]" class="form-control">>';

	<?php foreach ($recurrings as $recurring) { ?>

	html += '      <option value="<?php echo $recurring['recurring_id']; ?>"><?php echo $recurring['name']; ?></option>';

	<?php } ?>

	html += '    </select>';

	html += '  </td>';

	html += '  <td class="left">';

	html += '    <select name="service_recurring[' + recurring_row + '][customer_group_id]" class="form-control">>';

	<?php foreach ($customer_groups as $customer_group) { ?>

	html += '      <option value="<?php echo $customer_group['customer_group_id']; ?>"><?php echo $customer_group['name']; ?></option>';

	<?php } ?>

	html += '    <select>';

	html += '  </td>';

	html += '  <td class="left">';

	html += '    <a onclick="$(\'#recurring-row' + recurring_row + '\').remove()" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></a>';

	html += '  </td>';

	html += '</tr>';



	$('#tab-recurring table tbody').append(html);

	

	recurring_row++;

}

//--></script>

  <script type="text/javascript"><!--

$('.date').datetimepicker({

	pickTime: false

});



$('.time').datetimepicker({

	pickDate: false

});



$('.datetime').datetimepicker({

	pickDate: true,

	pickTime: true

});

//--></script>

  <script type="text/javascript"><!--

$('#language a:first').tab('show');

$('#optionsev a:first').tab('show');

//--></script></div>

<?php echo $footer; ?>

