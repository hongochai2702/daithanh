<div class="panel panel-default">
  <div class="panel-heading"><?php echo $heading_title; ?></div>
  <div class="list-group">
    <?php foreach ($filtersev_groups as $filtersev_group) { ?>
    <a class="list-group-item"><?php echo $filtersev_group['name']; ?></a>
    <div class="list-group-item">
      <div id="filtersev-group<?php echo $filtersev_group['filtersev_group_id']; ?>">
        <?php foreach ($filtersev_group['filtersev'] as $filtersev) { ?>
        <div class="checkbox">
          <label>
            <?php if (in_array($filtersev['filtersev_id'], $filtersev_category)) { ?>
            <input type="checkbox" name="filtersev[]" value="<?php echo $filtersev['filtersev_id']; ?>" checked="checked" />
            <?php echo $filtersev['name']; ?>
            <?php } else { ?>
            <input type="checkbox" name="filtersev[]" value="<?php echo $filtersev['filtersev_id']; ?>" />
            <?php echo $filtersev['name']; ?>
            <?php } ?>
          </label>
        </div>
        <?php } ?>
      </div>
    </div>
    <?php } ?>
  </div>
  <div class="panel-footer text-right">
    <button type="button" id="button-filtersev" class="btn btn-primary"><?php echo $button_filtersev; ?></button>
  </div>
</div>
<script type="text/javascript"><!--
$('#button-filtersev').on('click', function() {
	filtersev = [];

	$('input[name^=\'filtersev\']:checked').each(function(element) {
		filtersev.push(this.value);
	});

	location = '<?php echo $action; ?>&filtersev=' + filtersev.join(',');
});
//--></script>
