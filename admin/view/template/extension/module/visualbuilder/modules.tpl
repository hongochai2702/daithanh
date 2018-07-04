 <div class="panel panel-default"  id="module-list">
         <div class="panel-heading">
            <div class="panel-title"><?php echo $text_available_modules; ?>
            	<a class="pull-right" href="#settingsModal" id="module-settings-btn" data-toggle="modal"><em class="fa fa-gears"></em> <small><?php echo $text_settings; ?></small></a>
            </div>
         </div>
         <div class="list-group">
           <?php foreach ($modules as $module) { ?>
           		<?php if(!in_array($module['group'],$excluded_modules)) { ?>
		            <div class="list-group-item <?php echo $module['group']?>">
		               <div class="media">
		  
		                  <div class="clearfix">
		                     <div class="media-heading text-success">
		                    <span class="fa-stack">
		                        <em class="fa fa-circle fa-stack-2x text-success"></em>
		                        <em class="fa fa-cube fa-stack-1x fa-inverse text-white"></em>
		                     </span>
		                     <?php echo $module['name']; ?>
		                   	<?php if($module['hasSettings']) { ?>
		                  		<span class="text-muted pull-right"><a class="edit" href="<?php echo $module['module_link']?>"><span class="badge"><i class="fa fa-plus"></i> Thêm mới </span></a></span>
		                     <?php } ?>
		                     </div>
		                     <p class="remove-margin">
		                       <?php foreach ($module['module'] as $moduleSetting) { ?>
		                       	<div class="module-wrapper">
			                      <small> <a href="#" class="add-module<?php echo ($moduleSetting['setting']['status'] == 0 ) ? " text-danger":""; ?>" data-html="true" data-url="<?php echo $moduleSetting['href']; ?>" data-code="<?php echo $moduleSetting['code']; ?>" data-code="<?php echo $moduleSetting['code']; ?>" data-trigger="click" data-toggle="popover" data-content="" data-placement="left" title="Chọn vị trí cho chức năng"><em class="fa fa-plus-circle"></em> <?php echo $moduleSetting['name']; ?> <?php echo ($moduleSetting['setting']['status'] == 0 ) ? "(".$text_disabled.")":""; ?></a></small>
			                     <span class="text-muted pull-right"><a class="edit" href="<?php echo $moduleSetting['href']?>" data-toggle="tooltip" data-placement="left" title="Nhấp chuột vào để thiết lập chức năng này"><i class="fa fa-edit"></i></a></span>
			                    </div> 
			                    <?php } ?>	
		                     </p>
		                  </div>
		  
		
		               </div>
		            </div>
            	<?php } ?>
            <?php } ?>
           </div>
      </div>