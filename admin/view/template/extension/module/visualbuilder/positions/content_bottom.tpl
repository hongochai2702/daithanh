<?php 
//Change these when creating new position
$position="content_bottom"; 
$position_text=$text_content_bottom; 

?>

<span class="area-heading bg-primary"><?php echo $position_text ?></span>
<div class="<?php echo $position; ?> edit-container" data-position="<?php echo $position; ?>" data-text="<?php echo $position_text; ?>">
	<?php foreach ($layout_modules as $layout_module) { ?>
		<?php if ($layout_module['position'] == $position ) { ?>
			<div class="module" id="module-row<?php echo $module_row; ?>" data-sort="<?php echo $layout_module['sort_order']; ?>">
				<div class="edit-module panel">
					      	<div class="row row-flush row-table">
			            	<div class="col-md-2 text-center bg-primary">
			            		<em class="fa fa-arrows fa-inverse text-white"></em>
					       	</div>
			            	<div class="col-md-8 border-right">
			            		<div class="panel-body">
					<?php foreach ($modules as $module) { ?>
			            <?php foreach ($module['module'] as $module) { ?>
			      			 <?php if ($module['code'] == $layout_module['code']) { ?>
							 	<a class="edit<?php echo ($module['setting']['status'] == 0 ) ? ' text-danger" data-toggle="tooltip" data-placement="top" data-original-title="'.$text_module_disabled.'"':'"'; ?> target="_blank" href="<?php echo $module['href']; ?>"><?php echo $module['name']; ?> <em class="fa fa-edit"></em></a>
								<input type="hidden" value="<?php echo $module['code']; ?>" name="layout_module[<?php echo $module_row; ?>][code]" />
							 <?php } ?>
				      	<?php } ?>
				    <?php } ?>
						<input type="hidden" name="layout_module[<?php echo $module_row; ?>][position]" value="<?php echo $position; ?>" />
						<input type="hidden" name="layout_module[<?php echo $module_row; ?>][sort_order]" value="<?php echo $layout_module['sort_order']; ?>" />
						</div>
					</div>
					<div class="col-md-2 text-center">
						<span style="cursor: pointer;" onclick="$('#module-row<?php echo $module_row; ?>').remove();" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="text-danger"><i class="fa fa-minus-circle"></i></button>
				 	</div>
				  <?php $module_row++; ?>	
				 </div>	
				</div>
			</div>	
		<?php } ?>					
	<?php } ?>					
</div>