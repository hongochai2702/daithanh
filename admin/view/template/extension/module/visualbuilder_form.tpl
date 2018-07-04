<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-layout" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><i class="fa fa-cubes"></i> <?php echo $heading_title; ?></h1>
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
    <div class="alert alert-success alert-dismissable hidden" id="module-ajax-success">
    	<button type="button" class="close" data-dismiss="alert">×</button>
        <i class="fa fa-check"></i>&nbsp;&nbsp;
        <?php echo $text_module_success; ?>
    </div>
    <div class="panel panel-default">
            <?php if ($layouts) { ?>
            	<div class="panel-heading">
            	<div class="row builder-actions">
            		
	            	<div class="col-md-2">
		            	<form>
		            		<b><?php echo $text_choose_layout; ?>:</b>
		            	<select class="form-control input-sm" id="changeLayout" onchange="window.location.href=this.value">
		                <?php foreach ($layouts as $layout) { ?>
		              <?php if ($layout['layout_id'] == $selected_layout) { ?>
		        
		                    <option data-route="/index.php?routes=<?php echo $layout['route']; ?>" name="layout_id" value="<?php echo $layout['edit']; ?>" selected="selected" />
		                    <?php } else { ?>
		                    <option data-route="/index.php?routes=<?php echo $layout['route']; ?>" name="layout_id" value="<?php echo $layout['edit']; ?>" />
		                    <?php } ?>
		                  <?php echo $layout['name']; ?></option>
		                  
		                <?php } ?>
		               </select>
		               </form>
	               </div>
	               <div class="col-md-10">
						<div id="preview-slider" class="toggle-slider">
							<div class="offtext builder-mode" buildermode='builder' /><?php echo $text_build; ?></div>
							<select id='switch-me'>
								<option value='builder'><?php echo $text_build; ?></option>
								<option value='preview'><?php echo $text_view; ?></option>
							</select>
							<div class="ontext builder-mode" buildermode="preview"><?php echo $text_view; ?></div>
						</div>
					</div>
               </div>
               </div>
               <?php } ?>
      	<div class="panel-body builder-grid">
    	<div class="row" id="builder">
    		<?php $adminBuilderViewDir = DIR_TEMPLATE . 'extension/module/visualbuilder/'; $adminLayoutDir=DIR_TEMPLATE . 'extension/module/visualbuilder/layouts/'; $adminPositionsDir=DIR_TEMPLATE . 'extension/module/visualbuilder/positions/'; ?>
				<?php $module_row = 0; ?>	
    	      <div class="col-md-9">
    	      	<div class="">
	    	      	<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-layout" class="form-horizontal">
	                	<?php if (file_exists($adminLayoutDir.strtolower($name). '.tpl' )) { include ($adminLayoutDir.strtolower($name). '.tpl' ); } else { include ($adminLayoutDir . "main.tpl"); } ?>
	            		<input type="hidden" id="confirmleave" name="confirmleave" value="0">
	            	</form>
            	</div>
            </div>
            <div class="col-md-3">
                <?php include ($adminBuilderViewDir . "modules.tpl"); ?>
            </div>
       </div>
		<div id="preview" class="hidden">
		    <iframe width="100%" src="/" id="idIframe" onload="iframeLoaded('idIframe')" frameborder="0"></iframe>
		</div>
 	</div>
 	</div>
  </div>
  <script type="text/javascript"><!--

function resizeRightColumn(){
	$('#module-list').height($('#builder').height()+30);
	
}
resizeRightColumn();

var module_row = <?php echo $module_row; ?>;

$('.module-wrapper').on('click','.popover button', function() {
	
	var elem = $(this);
	
	var link = elem.closest(".module-wrapper").find('.add-module');
	var pos = elem.closest(".module-wrapper").find('select').val();

	html  = '<div id="module-row' + module_row + '" class="module">';
	html += '	<div class="edit-module panel ui-sortable-handle">';
	html += '		<div class="row row-flush row-table">';
	html += '			<div class="col-md-2 text-center bg-primary">';
	html += '		    	<em class="fa fa-arrows fa-inverse text-white"></em>';
	html += '			</div>';
	html += '		    <div class="col-md-8 border-right">';
	html += '		    	<div class="panel-body">';
	html += '					<a href="' + link.data('url') + '" target="_blank" class="edit">' + link.text() + ' <em class="fa fa-edit"></em></a>';
	html += '  					<input type="hidden" name="layout_module[' + module_row + '][code]" value="' + link.data('code') + '">';
	html += '  					<input type="hidden" name="layout_module[' + module_row + '][position]" value="' + pos + '">';
	html += '  					<input type="hidden" name="layout_module[' + module_row + '][sort_order]" value="' +  module_row + '">';
	html += '				</div>';
	html += '			</div>';
	html += '			<div class="col-md-2 text-center">';
	html += '				<span style="cursor: pointer;" class="text-danger" title="Remove" data-toggle="tooltip" onclick="$(\'#module-row' + module_row + '\').remove();"><i class="fa fa-minus-circle"></i></span>';
	html += '  			</div>';
	html += '  		</div>';
	html += '  	</div>';
	html += '</div>';

	
	$('.builder-grid .' +pos ).append(html);
	elem.closest('.popover').popover('hide');
	$("#confirmleave").val("1");
	module_row++;
	resizeRightColumn();
});

//--></script></div>

<div id="moduleModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<div id="loader" class="text-center">
</div>

                <iframe src="" class="hidden" frameborder="0" width="100%" id="modalFrame" onload="iframeLoaded('modalFrame')"></iframe>

            </div>
            <div class="modal-footer">
            	<button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>
<div id="settingsModal" class="modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $text_settings; ?></h4>
            </div>
            <div class="modal-body">
                <div class="help-block">
                    <?php echo $text_module_settings_help; ?>
                </div>
                <hr>
                <?php if ($modules) { ?>
                <form id="excluded-form" name="excluded-form" action="<?php echo $saveModulePositions; ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12">

                            <select multiple="multiple" id="excluded-modules" name="visualbuilder_excluded[]">
     
                                <?php foreach ($modules as $module) {
                       				 	if(!in_array($module['group'],$excluded_modules)) { 
									 	?>
                                <option value="<?php echo $module['group']; ?>">
                                    <?php echo $module[ 'name']; ?>
                                </option>
                               
                                <?php } else { ?>
                                
                                 <option selected="selected" value="<?php echo $module['group']; ?>">
                                    <?php echo $module[ 'name']; ?>
                                </option>
                                <?php } } ?>   	

                                

                            </select>
                            <script>
                                $('#module-settings-btn').on('click', function() {
                                    $('#excluded-modules').multiSelect({
                                        selectableHeader: "<h4><?php echo $text_active_modules; ?></h4>",
                                        selectionHeader: "<h4><?php echo $text_excluded_modules; ?></h4>"
                                    });
                                    $('#excluded-modules').multiSelect('refresh');
                                });
                            </script>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <hr>
                            <button class="btn btn-sm btn-success" rel="">
                                <?php echo $button_save; ?>
                            </button>
                            <button type="reset" class="btn btn-sm btn-danger">
                                <?php echo $button_cancel; ?>
                            </button>
                </form>
                </div>
                </div>


                <?php } 
                
                ?>


            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>