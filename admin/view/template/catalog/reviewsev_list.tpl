<?php echo $header; ?><?php echo $column_left; ?>

<div id="content">

  <div class="page-header">

    <div class="container-fluid">

      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>

        <button type="button" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger" onclick="confirm('<?php echo $text_confirm; ?>') ? $('#form-reviewsev').submit() : false;"><i class="fa fa-trash-o"></i></button>

      </div>

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

    <?php if ($success) { ?>

    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>

      <button type="button" class="close" data-dismiss="alert">&times;</button>

    </div>

    <?php } ?>

    <div class="panel panel-default">

      <div class="panel-heading">

        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>

      </div>

      <div class="panel-body">

        <div class="well">

          <div class="row">

            <div class="col-sm-6">

              <div class="form-group">

                <label class="control-label" for="input-service"><?php echo $entry_service; ?></label>

                <input type="text" name="filter_service" value="<?php echo $filter_service; ?>" placeholder="<?php echo $entry_service; ?>" id="input-service" class="form-control" />

              </div>

              <div class="form-group">

                <label class="control-label" for="input-author"><?php echo $entry_author; ?></label>

                <input type="text" name="filter_author" value="<?php echo $filter_author; ?>" placeholder="<?php echo $entry_author; ?>" id="input-author" class="form-control" />

              </div>

            </div>

            <div class="col-sm-6">

              <div class="form-group">

                <label class="control-label" for="input-status"><?php echo $entry_status; ?></label>

                <select name="filter_status" id="input-status" class="form-control">

                  <option value="*"></option>

                  <?php if ($filter_status) { ?>

                  <option value="1" selected="selected"><?php echo $text_enabled; ?></option>

                  <?php } else { ?>

                  <option value="1"><?php echo $text_enabled; ?></option>

                  <?php } ?>

                  <?php if (!$filter_status && !is_null($filter_status)) { ?>

                  <option value="0" selected="selected"><?php echo $text_disabled; ?></option>

                  <?php } else { ?>

                  <option value="0"><?php echo $text_disabled; ?></option>

                  <?php } ?>

                </select>

              </div>

              <div class="form-group">

                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>

                <div class="input-group date">

                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />

                  <span class="input-group-btn">

                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>

                  </span></div>

              </div>

              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-filter"></i> <?php echo $button_filter; ?></button>

            </div>

          </div>

        </div>

        <form action="<?php echo $delete; ?>" method="post" enctype="multipart/form-data" id="form-reviewsev">

          <div class="table-responsive">

            <table class="table table-bordered table-hover">

              <thead>

                <tr>

                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>

                  <td class="text-left"><?php if ($sort == 'pd.name') { ?>

                    <a href="<?php echo $sort_service; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_service; ?></a>

                    <?php } else { ?>

                    <a href="<?php echo $sort_service; ?>"><?php echo $column_service; ?></a>

                    <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'r.author') { ?>

                    <a href="<?php echo $sort_author; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_author; ?></a>

                    <?php } else { ?>

                    <a href="<?php echo $sort_author; ?>"><?php echo $column_author; ?></a>

                    <?php } ?></td>

                  <td class="text-right"><?php if ($sort == 'r.rating') { ?>

                    <a href="<?php echo $sort_rating; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_rating; ?></a>

                    <?php } else { ?>

                    <a href="<?php echo $sort_rating; ?>"><?php echo $column_rating; ?></a>

                    <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'r.status') { ?>

                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>

                    <?php } else { ?>

                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>

                    <?php } ?></td>

                  <td class="text-left"><?php if ($sort == 'r.date_added') { ?>

                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>

                    <?php } else { ?>

                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>

                    <?php } ?></td>

                  <td class="text-right"><?php echo $column_action; ?></td>

                </tr>

              </thead>

              <tbody>

                <?php if ($reviewsevs) { ?>

                <?php foreach ($reviewsevs as $reviewsev) { ?>

                <tr>

                  <td class="text-center"><?php if (in_array($reviewsev['reviewsev_id'], $selected)) { ?>

                    <input type="checkbox" name="selected[]" value="<?php echo $reviewsev['reviewsev_id']; ?>" checked="checked" />

                    <?php } else { ?>

                    <input type="checkbox" name="selected[]" value="<?php echo $reviewsev['reviewsev_id']; ?>" />

                    <?php } ?></td>

                  <td class="text-left"><?php echo $reviewsev['name']; ?></td>

                  <td class="text-left"><?php echo $reviewsev['author']; ?></td>

                  <td class="text-right"><?php echo $reviewsev['rating']; ?></td>

                  <td class="text-left"><?php echo $reviewsev['status']; ?></td>

                  <td class="text-left"><?php echo $reviewsev['date_added']; ?></td>

                  <td class="text-right"><a href="<?php echo $reviewsev['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>

                </tr>

                <?php } ?>

                <?php } else { ?>

                <tr>

                  <td class="text-center" colspan="7"><?php echo $text_no_results; ?></td>

                </tr>

                <?php } ?>

              </tbody>

            </table>

          </div>

        </form>

        <div class="row">

          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>

          <div class="col-sm-6 text-right"><?php echo $results; ?></div>

        </div>

      </div>

    </div>

  </div>

  <script type="text/javascript"><!--

$('#button-filter').on('click', function() {

	url = 'index.php?route=catalog/reviewsev&token=<?php echo $token; ?>';

	

	var filter_service = $('input[name=\'filter_service\']').val();

	

	if (filter_service) {

		url += '&filter_service=' + encodeURIComponent(filter_service);

	}

	

	var filter_author = $('input[name=\'filter_author\']').val();

	

	if (filter_author) {

		url += '&filter_author=' + encodeURIComponent(filter_author);

	}

	

	var filter_status = $('select[name=\'filter_status\']').val();

	

	if (filter_status != '*') {

		url += '&filter_status=' + encodeURIComponent(filter_status); 

	}		

			

	var filter_date_added = $('input[name=\'filter_date_added\']').val();

	

	if (filter_date_added) {

		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);

	}



	location = url;

});

//--></script> 

  <script type="text/javascript"><!--

$('.date').datetimepicker({

	pickTime: false

});

//--></script></div>

<?php echo $footer; ?>