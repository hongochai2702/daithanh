<table class="table">
 <tr>
    <td class="col-xs-3">
    	<h5><span class="required">* </span><strong><?php echo $entry_code; ?></strong></h5>
        <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $entry_code_help; ?></span></td>
    <td class="col-xs-9">
        <div class="col-xs-4">
        	<select id="Checker" name="<?php echo $moduleNameSmall; ?>[Enabled]" class="form-control">
                  <option value="yes" <?php echo (!empty($moduleData['Enabled']) && $moduleData['Enabled'] == 'yes') ? 'selected=selected' : '' ?>><?php echo $text_enabled; ?></option>
                  <option value="no"  <?php echo (empty($moduleData['Enabled']) || $moduleData['Enabled']== 'no') ? 'selected=selected' : '' ?>><?php echo $text_disabled; ?></option>
            </select>
        </div>
    </td>
    </tr>
</table>
<script>
$(function() {
    var $typeSelector = $('#Checker');
	var $toggleArea2 = $('#mainSettingsTab');
	 if ($typeSelector.val() === 'yes') {
			$toggleArea2.show();
        }
        else {
			$toggleArea2.hide();
        }
    $typeSelector.change(function(){
        if ($typeSelector.val() === 'yes') {
			$toggleArea2.show(300);
        }
        else {
			$toggleArea2.hide(300);
        }
    });
});
</script>
