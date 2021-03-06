<?php echo $header; ?>
<?php echo $column_left; ?>
<div id="content" class="simple">
    <div class="page-header">
        <div class="container-fluid">
            <div class="pull-right">
                <button type="submit" form="form-portfolio"  title="<?php echo $button_save; ?>" class="btn btn-primary"><?php echo $button_save; ?></button>           
                <a href="<?php echo $cancel; ?>" title="<?php echo $button_cancel; ?>" class="btn btn-default"><?php echo $button_cancel; ?></a>
            </div>
            <h1><?php echo $heading_title; ?></h1>
        </div>
    </div>
    <div class="container-fluid">
        <?php if ($error_warning) { ?>
        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
        <?php } ?>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-portfolio" class="form-horizontal">
            <div class="row">
                <div class="left-col col-lg-8">
                    <div class="panel panel-default">
                    <div class="panel-body">
                    <div class="general">
                        <ul class="nav nav-tabs" id="language">
                            <?php foreach ($languages as $language) { ?>
                            <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                            <?php } ?>
                        </ul>
                        <div class="tab-content">
                            <?php foreach ($languages as $language) { ?>
                            <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                                <div class="form-group required">
                                    <label class="col-sm-12" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                                    <div class="col-sm-12">
                                     <?php if(isset($action_add)) { ?>
                                        <input type="text" name="portfolio_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($portfolio_description[$language['language_id']]) ? $portfolio_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" onkeyup="ChangeToSlug();" id="input-name<?php echo $language['code']; ?>" class="form-control"/>
                                      <?php } else { ?>
                                        <input type="text" name="portfolio_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($portfolio_description[$language['language_id']]) ? $portfolio_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['code']; ?>" class="form-control"/>
                                      <?php } ?>
                                        <?php if (isset($error_name[$language['language_id']])) { ?>
                                        <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-sm-12" for="input-short_description<?php echo $language['language_id']; ?>"><?php echo $entry_short_description; ?></label>
                                  <div class="col-sm-12">
                                    <textarea placeholder="<?php echo $entry_short_description; ?>" id="input-short_description<?php echo $language['language_id']; ?>" class="form-control" name="portfolio_description[<?php echo $language['language_id']; ?>][short_description]"><?php echo isset($portfolio_description[$language['language_id']]) ? $portfolio_description[$language['language_id']]['short_description'] : ''; ?></textarea>
                                  </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12" for="input-description<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                    <div class="col-sm-12">
                                        <textarea data-toggle="summernote" data-lang="<?php echo $language['code']; ?>" name="portfolio_description[<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description<?php echo $language['language_id']; ?>" class="editor_chili"><?php echo isset($portfolio_description[$language['language_id']]) ? $portfolio_description[$language['language_id']]['description'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-12" for="input-challenge_description<?php echo $language['language_id']; ?>"><?php echo $entry_challenge_description; ?></label>
                                    <div class="col-sm-12">
                                        <textarea data-toggle="summernote" data-lang="<?php echo $language['code']; ?>" name="portfolio_description[<?php echo $language['language_id']; ?>][challenge_description]" placeholder="<?php echo $entry_challenge_description; ?>" id="input-challenge_description<?php echo $language['language_id']; ?>" class="editor_chili"><?php echo isset($portfolio_description[$language['language_id']]) ? $portfolio_description[$language['language_id']]['challenge_description'] : ''; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-md-12" for="input-meta-title<?php echo $language['code']; ?>"><?php echo $entry_meta_title; ?></label>
                                    <div class="col-sm-12">
                                      <input type="text" name="product_description[<?php echo $language['language_id']; ?>][meta_title]" value="<?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_title'] : ''; ?>" placeholder="<?php echo $entry_meta_title; ?>" id="input-meta-title<?php echo $language['code']; ?>" class="form-control" />
                                      <?php if (isset($error_meta_title[$language['language_id']])) { ?>
                                      <div class="text-danger"><?php echo $error_meta_title[$language['language_id']]; ?></div>
                                      <?php } ?>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-12" for="input-meta-description<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                    <div class="col-sm-12">
                                      <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_description]" rows="5" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta-description<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_description'] : ''; ?></textarea>
                                    </div>
                                  </div>
                                  <div class="form-group">
                                    <label class="col-md-12" for="input-meta-keyword<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                    <div class="col-sm-12">
                                      <textarea name="product_description[<?php echo $language['language_id']; ?>][meta_keyword]" rows="5" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta-keyword<?php echo $language['language_id']; ?>" class="form-control"><?php echo isset($product_description[$language['language_id']]) ? $product_description[$language['language_id']]['meta_keyword'] : ''; ?></textarea>
                                    </div>
                                  </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                    </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $entry_image; ?></h3>
                            <div class="pull-right">
                                <div class="panel-chevron"><i class="fa fa-chevron-up rotate-reset"></i></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="images">
                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                                        <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                                    </div>
                                    <div class="col-sm-10">
                                    <div class="table-responsive">
                                        <table id="images" class="table table-striped table-bordered">
                                          <thead>
                                            <tr>
                                              <td class="text-left"><?php echo $entry_image; ?></td>
                                              <td class="text-center"><?php echo $text_choose_avatar; ?></td>
                                              <td hidden><?php echo $entry_sort_order; ?></td>
                                              <td class="text-center">
                                                <?php if($image_manager_plus_status == 1){ ?>
                                                <button type="button" onclick="filemanager();" class="btn btn-primary">
                                                <?php echo $button_image_add; ?>
                                                </button>
                                                <?php } ?>
                                              </td>
                                            </tr>
                                          </thead>
                                          <tbody>
                                            <?php $image_row = 0; ?>
                                              <?php foreach ($portfolio_images as $portfolio_image) { ?>
                                              <tr class="image-row" id="image-row<?php echo $image_row; ?>">
                                                <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $portfolio_image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="portfolio_image[<?php echo $image_row; ?>][image]" value="<?php echo $portfolio_image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                                                <td class="text-center"><input type="radio" name="primary_image" onclick="changePrimaryImage(<?php echo $image_row; ?>)"></td><td class="text-right" hidden><input type="text" name="portfolio_image[<?php echo $image_row; ?>][sort_order]" value="<?php echo $portfolio_image['sort_order']; ?>" placeholder="<?php echo $entry_sort_order; ?>" class="form-control sort_order" /></td>
                                                <td class="text-center"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();"  title="" class="btn btn-danger"><?php echo $button_remove; ?></button></td>
                                              </tr>
                                              <?php $image_row++; ?>
                                              <?php } ?>
                                          </tbody>
                                        </table>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="right-col col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $tab_general; ?></h3>
                            <div class="pull-right">
                                <div class="panel-chevron"><i class="fa fa-chevron-up rotate-reset"></i></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="publish">
                             <div class="form-group">
                                <label for="input-keyword" class="col-sm-12"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                                     <?php if(!isset($action_add)) { ?>
                                      <button type="button" data-toggle="tooltip" title="" class="btn btn-custom btn-primary" onclick="ChangeToSlug();"><i class="fa fa-check"></i></button>
                                    <?php } ?>
                                    <?php if ($error_keyword) { ?>
                                    <div class="text-danger"><?php echo $error_keyword; ?></div>
                                    <?php } ?>  
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12" for="input-date-available"><?php echo $entry_date_available; ?></label>
                                <div class="col-sm-12">
                                    <div class="input-group date">
                                        <input type="text" name="date_available" value="<?php echo $date_available; ?>" placeholder="<?php echo $entry_date_available; ?>" data-date-format="YYYY-MM-DD" id="input-date-available" class="form-control" />
                                        <span class="input-group-btn"><button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button></span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-12" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                                <div class="col-sm-12">
                                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="text_left">
                                    <label class="col-sm-12"><?php echo $entry_status; ?></label>
                                    <div class="col-sm-12">
                                        <label class="radio-inline">
                                            <?php if ($status) { ?>
                                            <input type="radio" name="status" value="1" checked="checked" />
                                            <?php echo $text_enabled; ?>
                                            <?php } else { ?>
                                            <input type="radio" name="status" value="1" />
                                            <?php echo $text_enabled; ?>
                                            <?php } ?>
                                        </label>
                                        <label class="radio-inline">
                                            <?php if (!$status) { ?>
                                            <input type="radio" name="status" value="0" checked="checked" />
                                            <?php echo $text_disabled; ?>
                                            <?php } else { ?>
                                            <input type="radio" name="status" value="0" />
                                            <?php echo $text_disabled; ?>
                                            <?php } ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                     <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $tab_option; ?></h3>
                            <div class="pull-right">
                                <div class="panel-chevron"><i class="fa fa-chevron-up rotate-reset"></i></div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs" id="ops-language">
                                <?php foreach ($languages as $language) { ?>
                                <li><a href="#ops-language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                                <?php } ?>
                            </ul>
                            <div class="tab-content">
                                <?php foreach ($languages as $language) { ?>
                                    <div class="tab-pane" id="ops-language<?php echo $language['language_id']; ?>">
                                        <div class="form-group">
                                            <label class="col-sm-12" for="input-categories"><?php echo $entry_categories; ?></span></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="portfolio_options[<?php echo $language['language_id'] ?>][categories]" placeholder="<?php echo $entry_categories; ?>" class="form-control input-full-width" value="<?php echo $portfolio_options[$language['language_id']]['categories']; ?>" />
                                            </div>
                                        </div>
                                        <!-- Nước sản xuất -->
                                        <div class="form-group">
                                            <label class="col-sm-12" for="input-design"><?php echo $entry_design; ?></span></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="portfolio_options[<?php echo $language['language_id'] ?>][design]" placeholder="<?php echo $entry_design; ?>" class="form-control input-full-width" value="<?php echo $portfolio_options[$language['language_id']]['design']; ?>" />
                                            </div>
                                        </div>
                                        <!-- Loại bộ lọc -->
                                        <div class="form-group">
                                            <label class="col-sm-12" for="input-construction"><?php echo $entry_construction; ?></span></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="portfolio_options[<?php echo $language['language_id'] ?>][construction]" placeholder="<?php echo $entry_construction; ?>" class="form-control input-full-width" value="<?php echo $portfolio_options[$language['language_id']]['construction']; ?>" />
                                            </div>
                                        </div>
                                        <!-- Phương pháp loại bỏ -->
                                        <div class="form-group">
                                            <label class="col-sm-12" for="input-investor"><?php echo $entry_investor; ?></span></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="portfolio_options[<?php echo $language['language_id'] ?>][investor]" placeholder="<?php echo $entry_investor; ?>" class="form-control input-full-width" value="<?php echo $portfolio_options[$language['language_id']]['investor']; ?>" />
                                            </div>
                                        </div>
                                        <!-- Khu vực xử dụng -->
                                        <div class="form-group">
                                            <label class="col-sm-12" for="input-construction_time"><?php echo $entry_construction_time; ?></span></label>
                                            <div class="col-sm-12">
                                                <input type="text" name="portfolio_options[<?php echo $language['language_id'] ?>][construction_time]" placeholder="<?php echo $entry_construction_time; ?>" class="form-control input-full-width" value="<?php echo $portfolio_options[$language['language_id']]['construction_time']; ?>" />
                                            </div>
                                        </div>      
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title"><?php echo $tab_links; ?></h3>
                            <div class="pull-right">
                                <div class="panel-chevron"><i class="fa fa-chevron-up rotate-reset"></i></div>
                            </div>
                        </div>
                        <div class="panel-body">
                         
                          <div class="form-group">
                              <label class="col-sm-12" for="input-portfolio_category"><span data-toggle="tooltip" title="<?php echo $help_category; ?>"><?php echo $entry_category; ?></span></label>
                              <div class="col-sm-12">
                                  <input type="text" name="portfolio_category" value="" placeholder="<?php echo $entry_category; ?>" id="input-portfolio_category" class="form-control input-full-width" style="margin-bottom: 5px !important;"/>
                                  <?php if (!empty($portfolio_categories)) { ?>
                                  <div id="portfolio_category" class="well well-sm" style="overflow: auto;">
                                      <?php foreach ($portfolio_categories as $portfolio_category) { ?>
                                      <div id="portfolio_category<?php echo $portfolio_category['portfolio_category_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $portfolio_category['name']; ?>
                                          <input type="hidden" name="portfolio_category[]" value="<?php echo $portfolio_category['portfolio_category_id']; ?>" />
                                      </div>
                                      <?php } ?>
                                  </div>
                                  <?php } ?>
                              </div>
                          </div>

                          <div class="form-group">
                              <label class="col-sm-12" for="input-portfolio_related"><span data-toggle="tooltip" title="<?php echo $help_related; ?>"><?php echo $entry_related; ?></span></label>
                              <div class="col-sm-12">
                                  <input type="text" name="portfolio_related" value="" placeholder="<?php echo $entry_related; ?>" id="input-portfolio_related" class="form-control input-full-width" style="margin-bottom: 5px !important;"/>
                                  <?php if (!empty($portfolio_relateds)) { ?>
                                  <div id="portfolio_related" class="well well-sm" style="overflow: auto;">
                                      <?php foreach ($portfolio_relateds as $portfolio_related) { ?>
                                      <div id="portfolio_related<?php echo $portfolio_related['portfolio_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $portfolio_related['name']; ?>
                                          <input type="hidden" name="portfolio_related[]" value="<?php echo $portfolio_related['portfolio_id']; ?>" />
                                      </div>
                                      <?php } ?>
                                  </div>
                                  <?php } ?>
                              </div>
                          </div>
                         
                        </div>
                    </div>
                   
                </div>
            </div>

            <input type="hidden" name="portfolio_id" value="<?php echo $portfolio_id; ?>"/>
            <?php if (in_array(0, $portfolio_store)) { ?>
            <input type="hidden" name="portfolio_store[]" value="0" checked="checked" />
            <?php } else { ?>
            <input type="hidden" name="portfolio_store[]" value="0" />
            <?php } ?>
            <?php foreach ($stores as $store) { ?>
            <?php if (in_array($store['store_id'], $portfolio_store)) { ?>
            <input type="hidden" name="portfolio_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
            <?php } else { ?>
            <input type="hidden" name="portfolio_store[]" value="<?php echo $store['store_id']; ?>" />
            <?php } ?>
            <?php } ?>
           
            <?php foreach ($stores as $store) { ?>
            <select name="portfolio_layout[<?php echo $store['store_id']; ?>]" class="hidden">
                <option value=""></option>
                <?php foreach ($layouts as $layout) { ?>
                <?php if (isset($portfolio_layout[$store['store_id']]) && $portfolio_layout[$store['store_id']] == $layout['layout_id']) { ?>
                <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                <?php } else { ?>
                <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                <?php } ?>
                <?php } ?>
            </select>
            <?php } ?>
        </form>
    </div>
    
    <script type="text/javascript"><!--
    $('#language a:first').tab('show');
    //--></script></div>
    <script type="text/javascript"><!--
    
    <?php if (!empty($tag_key)) { ?>
    var tag_key = '<?php echo $tag_key; ?>';
    <?php } else  { ?>
    var tag_key = 0;
    <?php } ?>
    // Tag
    $('.tag-select').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?routes=portfolio/portfolio/autocomplete&token=<?php echo $token; ?>&tag_name=' +  encodeURIComponent(request),
                type: 'post',
                data: { tag_text: $(this).parent().parent().find('.tags-multi-select').serializeArray() },
                dataType: 'json',
                success: function(json) {
                    response($.map(json, function(item) {
                        return {
                            label: item['tag'],
                            value: item['tag_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            var tag_value = item['label'];
            $(this).parent().parent().find('.tags-multi-select').append('<option data-tag-remove="' + tag_key + '" value="' + tag_value +'" selected="selected">' + tag_value + '</option>');
            $(this).before('<span class="tag-choice">' + item['label'] + '<a class="tag-choice-close" onclick="removeTag(this);" data-tag-remove-index="' + tag_key + '"><i class="fa fa-times"></i></a></span>');
            $(this).val('');
            tag_key = tag_key + 1 ;
        }
    });
    function removeTag(tag) {
        var tag_value = $(tag).data('tag-remove-index');
        $(tag).parent().parent().parent().parent().find('.tags-multi-select option[data-tag-remove="' + tag_value + '"]').remove();
        $(tag).parent().remove();
    }
    $('.tag-select').keypress(function(event) {
        if(event.keyCode == 13){
            event.preventDefault();
            label = $(this).val();
            var add_tag = 1;
            var error = '';
            if (label == '') {
                add_tag = 0;
                error  = '<div class="alert alert-danger tag-error"><i class="fa fa-exclamation-circle"></i>';
                error += '    <button type="button" class="close" data-dismiss="alert">&times;</button>';
                error += '</div>';
            }
            $(this).parent().parent().find( '.tags-multi-select option:selected' ).each(function() {
                if ($(this).val() == label) {
                    add_tag = 0;
                    error  = '<div class="alert alert-danger tag-error"><i class="fa fa-exclamation-circle"></i>';
                    error += '    <button type="button" class="close" data-dismiss="alert">&times;</button>';
                    error += '</div>';
                }
            });
            if (add_tag == 1) {
                $(this).parent().parent().find('.tags-multi-select').append('<option data-tag-remove="' + tag_key + '" value="' + label +'" selected="selected">' + label + '</option>');
                $(this).before('<span class="tag-choice">' + label + '<a class="tag-choice-close" onclick="removeTag(this);" data-tag-remove-index="' + tag_key + '"><i class="fa fa-times"></i></a></span>');
                $(this).val('');
                tag_key = tag_key + 1 ;
            } else {
                $(this).parent().after(error);
                $('.tag-error').delay(5000).fadeOut('slow');
            }
        }
    });
    $(".tags-select").click(function () {
        $(this).children('.form-control').find('.tag-select').focus();
    });

    // Portfolio related
    $('input[name=\'portfolio_related\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?routes=portfolio/portfolio/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    if ((typeof(json) != 'undefined' || typeof(json) != 'object') && (json == null || json == '')) {
                        $('.btn-category-add').remove();
                        $('.tooltip.fade.top.in').removeClass('in');
                    }
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['portfolio_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'portfolio_related\']').val('');
            if (!$('#portfolio_related').length) {
                $('input[name=\'portfolio_related\']').after('<div id="portfolio_related" class="well well-sm" style="overflow: auto;"></div>');
            }
            $('#portfolio_related' + item['value']).remove();
            $('#portfolio_related').append('<div style="width:100%" id="portfolio_related' + item['value'] + '"><i style="color: #f41f1f;" class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="portfolio_related[]" value="' + item['value'] + '" /></div>');
        }
    });
    $(document).on('click', '#portfolio_related .fa-minus-circle', function() {
        $(this).parent().remove();
        if (!$("div[id^='portfolio_related'] i").hasClass('fa-minus-circle')) {
            $('#portfolio_related').remove();
        }
    });
    // Category
    $('input[name=\'portfolio_category\']').autocomplete({
        'source': function(request, response) {
            $.ajax({
                url: 'index.php?routes=portfolio/portfolio_category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                dataType: 'json',
                success: function(json) {
                    if ((typeof(json) != 'undefined' || typeof(json) != 'object') && (json == null || json == '')) {
                        $('.btn-category-add').remove();
                        $('.tooltip.fade.top.in').removeClass('in');
                    }
                    response($.map(json, function(item) {
                        return {
                            label: item['name'],
                            value: item['portfolio_category_id']
                        }
                    }));
                }
            });
        },
        'select': function(item) {
            $('input[name=\'portfolio_category\']').val('');
            if (!$('#portfolio_category').length) {
                $('input[name=\'portfolio_category\']').after('<div id="portfolio_category" class="well well-sm" style="overflow: auto;"></div>');
            }
            $('#portfolio_category' + item['value']).remove();
            $('#portfolio_category').append('<div id="portfolio_category' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="portfolio_category[]" value="' + item['value'] + '" /></div>');
        }
    });
    $(document).on('click', '#portfolio_category .fa-minus-circle', function() {
        $(this).parent().remove();
        if (!$("div[id^='portfolio_category'] i").hasClass('fa-minus-circle')) {
            $('#portfolio_category').remove();
        }
    });
    $(document).on('click', '.btn-category-add', function() {
        $.ajax({
            url: 'index.php?routes=portfolio/portfolio/quick&token=<?php echo $token; ?>',
            type: 'post',
            data: {name: $('#input-portfolio_category').val(), sort_order: '0', status: '1', column: '1', parent_id: '0'},
            dataType: 'json',
            success: function(json) {
                if (json['success']) {
                    $('.btn-category-add').remove();
                    $('.tooltip.fade.top.in').removeClass('in');
                    if (!$('#portfolio_category').length) {
                        $('input[name=\'portfolio_category\']').after('<div id="portfolio_category" class="well well-sm" style="overflow: auto;"></div>');
                    }
                    html  = '<div id="portfolio_category' + json['portfolio_category_id'] + '">';
                    html += '    <i class="fa fa-minus-circle"></i> ' + $('#input-portfolio_category').val();
                    html += '    <input type="hidden" name="portfolio_category[]" value="' + json['portfolio_category_id'] + '">';
                    html += '</div>';
                    $('#input-portfolio_category').val('');
                    $('#portfolio_category').append(html);
                    $('#input-portfolio_category').after('<p id="quick-category-success" class="text-success">' + json['success'] + '</p>').fadeIn(3000);
                }
            }
        }).done(function() {
            setTimeout(function(){
                $('#quick-category-success').fadeOut();
                $('#quick-category-success').remove();
            }, 3000);
        });
    });
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
</script>

<script type="text/javascript">
    var text_yes = '<?php echo $text_yes; ?>';
    var text_no = '<?php echo $text_no; ?>';
    var text_enabled = '<?php echo $text_enabled; ?>';
    var text_disabled = '<?php echo $text_disabled; ?>';
    $("input:radio[name='status']").each(function () {
            if ($(this).parent().hasClass('radio-inline')) {
                var r_name = $(this).attr("name");
                var r_value = $(this).attr("value");
                var r_text = $(this).text();
                if ($(':radio[name="'+r_name+'"]').length != 2) {
                    return;
                }
                if ((r_value != 0) && (r_value != 1)) {
                    return;
                }
                if ((r_text.localeCompare(text_enabled) == 1) && (r_text.localeCompare(text_disabled) == 1)) {
                    return;
                }
                var r_checked = $(this).is(':checked');
                var r_div = $(this).parent().parent();
                var html = '';
                var a_class = 'btn-default';
                var d_class = 'btn-default';
                var a_checked = '';
                var d_checked = '';
                if (r_value == 1 && r_checked == true) {
                    a_class = 'btn-primary active';
                    a_checked = 'checked="checked"';
                }
                else {
                    d_class = 'btn-danger active';
                    d_checked = 'checked="checked"';
                }
                html += '<div class="btn-group" data-toggle="buttons">';
                html += '   <label for="' + r_name + '1" class="btn ' + a_class + '">';
                html += '       <input type="radio" ' + a_checked + ' value="' + r_value + '" name="' + r_name + '" id="' + r_name + '1">';
                html += '       <span class="radiotext">' + text_enabled + '</span>';
                html += '   </label>';
                html += '   <label for="' + r_name + '0" class="btn ' + d_class + '">';
                html += '       <input type="radio" ' + d_checked + ' value="0" name="' + r_name + '" id="' + r_name + '0">';
                html += '       <span class="radiotext">' + text_disabled + '</span>';
                html += '   </label>';
                html += '</div>';
                r_div.html(html);
            }
        });
    
        $(document).on('click', '.btn-group label:not(.active)', function (e) {
            var d_label = $(this);
            var d_input = $('#' + d_label.attr('for'));
            if (d_input.attr('type') != 'radio') {
                return;
            }
            if (!d_input.is(':checked')) {
                var a_input = $('input[name="' + d_input.attr('name') + '"]:checked');
                var a_label = a_input.parent();
                a_label.removeClass('btn-primary active');
                a_label.removeClass('btn-danger active');
                a_input.removeAttr('checked');
                a_label.addClass('btn btn-default');
                d_label.removeClass('btn-default');
                if (d_input.val() == 0) {
                    d_label.addClass('btn-danger active');
                } else {
                    d_label.addClass('btn-primary active');
                }
                d_input.attr('checked', 'checked');
                a_input.trigger('change');
                d_input.trigger('change');
            }
        });
 
        $(document).on('click', '.panel-chevron', function(e) {
        e.preventDefault();
        var content =  $(this).parent().parent().parent().find('.panel-body');
        $(content).slideToggle();
        $(this).toggleClass('rotate');
    });
</script>
<script type="text/javascript">
$('#ops-language a:first, #language a:first').tab('show');
</script>
    
<script type="text/javascript"><!--
<?php if($image_manager_plus_status==1){?>
  function insertImage(fileName) {  
      if ($.rcookie('portfolio<?php echo $portfolio_id; ?>_image_row')==null||$.rcookie('portfolio<?php echo $portfolio_id; ?>_image_row')=='') {
        var cookie_add_row = <?php echo $image_row; ?>; 
      }else{  
        var cookie_add_row = $.rcookie('portfolio<?php echo $portfolio_id; ?>_image_row');
      }         
      var add_row = cookie_add_row;
      $.rcookie('portfolio<?php echo $portfolio_id; ?>_image_row',null);
      html  = '<tr class="image-row" id="image-row' + add_row + '">';
      html += '  <td class="text-left"><a href="" id="thumb-image' + add_row + '"data-toggle="image" class="img-thumbnail"><img style="width:50px;" src="../image/' + fileName + '" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="portfolio_image[' + add_row + '][image]" value="' + fileName + '" id="input-image' + add_row + '" /></td>';
      html += '<td class="text-center"><input type="radio" name="primary_image" onclick="changePrimaryImage(' + add_row + ')"/></td>';
      html += '<td class="text-right" hidden><input type="text" name="portfolio_image[' + add_row + '][sort_order]" value="' + add_row + '" placeholder="<?php echo $entry_sort_order; ?>" class="form-control sort_order" /></td>';
      html += '  <td class="text-center"><button type="button" onclick="$(\'#image-row' + add_row  + '\').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
      html += '</tr>';
      $('#images tbody').append(html);    
      $('#images').sortable('refresh');
      var numrow= parseInt(add_row)+1;
      $.rcookie('portfolio<?php echo $portfolio_id; ?>_image_row',numrow);  
      add_row++;    
  };
<?php } ?>
$('#images').bind('sortupdate', function(event, ui) {
  var sort_order = 0;
   $('#images>tbody>tr').each(function() {    
    sort_order += 1;       
    var so = $(this).find('.sort_order');
    so.attr('value',sort_order);
  });
});   
//--></script>
<style type="text/css">
    #container {
        background-color: #ebeef0;
    }
</style>
<script language="javascript">
var slugs = "input-name<?php echo $lagcode; ?>";
var slug_val = "input-keyword";
var _html = '.html';
var meta_title = "input-meta-title<?php echo $lagcode; ?>";
</script>
</div>
<?php echo $footer; ?>