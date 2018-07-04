<?php echo str_replace('/jquery-ui.js','/jquery-ui.min.js',$header); ?>
<?php echo $column_left; ?>
<div id="content">
   <div class="page-header">
      <div class="container-fluid">
         <div class="pull-right"></div>
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
      <ul class="nav nav-tabs">
         <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $text_image;?></a></li>
         <li><a href="#tab-log" data-toggle="tab"><?php echo $text_log;?></a></li>
         <li><a href="#tab-setting" data-toggle="tab"><?php echo $text_setting;?></a></li>
      </ul>
      <div class="tab-content">
         <div class="tab-pane active" id="tab-general">
            <?php $image_command=(!empty($image_manager_plus_command))?$image_manager_plus_command:array();
               $commands = array(
               'mkdir'      =>$text_mkdir,
               'mkfile'   =>$text_mkfile,
               'upload'   =>$text_upload,
               'reload'   =>$text_reload,
               'getfile'    =>$text_getfile,
               'up'     =>$text_up,
               'download'   =>$text_download,
               'rm'     =>$text_rm,
               'duplicate'    =>$text_duplicate,
               'rename'   =>$text_rename,
               'copy'     =>$text_copy,
               'cut'      =>$text_cut,
               'paste'      =>$text_paste,
               'edit'     =>$button_edit,
               'extract'    =>$text_extract,
               'archive'    =>$text_archive,
               'view'     =>$text_view,
               'resize'   =>$text_resize,
               'sort'     =>$text_sort,
               'search'   =>$text_search
               );  
               $cmd = "commands: [";
               foreach ($commands as $command=>$value) { 
               if(!empty($image_command[$user_group_id][$command])){
               $cmd .="'".$command."',";
               }
               } 
               $cmd .="],";
               ?> 
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $heading_title; ?></h3>
                  <a href="<?php echo $clear_cache;?> " class="btn btn-danger btn-xs pull-right"><i class="fa fa-eraser"></i> <?php echo $text_clear_cache;?> </a>
               </div>
               <div class="panel-body">
                  <div class="content" id="elfinder" style="min-height:550px; width:100%;"></div>
               </div>
            </div>
            <!--panel --> 
         </div>
         <div class="tab-pane" id="tab-log">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_log; ?></h3>
                  <a href="<?php echo $clear;?>" class="btn btn-primary btn-xs pull-right"><span><i class="fa fa-save"></i> <?php echo $text_clear; ?></span></a>
               </div>
               <div class="panel-body">
                  <iframe style="min-height:500px; width:100%;" frameborder="0" src="<?php echo $log_url;?>"></iframe>
               </div>
            </div>
            <!-- panel--> 
         </div>
         <div class="tab-pane" id="tab-setting">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_setting; ?></h3>
                  <a onclick="$('#form').submit();" class="btn btn-primary btn-xs pull-right"><span><i class="fa fa-save"></i> <?php echo $button_save; ?></span></a>
               </div>
               <div class="panel-body">
                  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form" name="form">
                     <div class="form-group">
                        <label class="col-sm-3 control-label" for=""><?php echo $entry_manager_status; ?></label>
                        <div class="col-sm-9">
                           <select name="image_manager_plus_status" class="form-control">
                              <option value="1" <?php echo ($image_manager_plus_status=='1')?'selected="selected"':'';?>><?php echo $text_enabled;?></option>
                              <option value="0" <?php echo ($image_manager_plus_status=='0')?'selected="selected"':'';?>><?php echo $text_disabled;?></option>
                           </select>
                        </div>
                     </div>
                     <!-- form-group--> 
                     <br/><br/>  
                     <ul class="nav nav-tabs">
                        <?php $i=0; foreach ($user_groups as $user_group) { ?>
                        <li <?php if($i==0){?>class="active"<?php } ?>> <a  href="#user_group_<?php echo $user_group['user_group_id']; ?>" data-toggle="tab"><?php echo $user_group['name']; ?></a></li>
                        <?php $i++; } ?>   
                     </ul>
                     <div class="tab-content">
                        <?php $i=0;
                           foreach ($user_groups as $user_group) { ?>
                        <div class="tab-pane <?php if($i==0){?>active<?php } ?> in" id="user_group_<?php echo $user_group['user_group_id']; ?>">
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for=""><?php echo $user_group['name']; ?></label>
                              <div class="col-sm-10">
                                 <a onclick="$(this).parent().find(':checkbox').prop('checked',true);"><?php echo $text_select_all; ?></a> / <a onclick="$(this).parent().find(':checkbox').prop('checked', false);"><?php echo $text_unselect_all; ?></a><br><br> 
                                 <div class="well well-sm" style="min-height:300px;overflow: auto;">
                                    <?php foreach ($commands as $command=>$label) { ?>
                                    <div class="checkbox">
                                       <label>
                                       <input type="checkbox" name="image_manager_plus_command[<?php echo $user_group['user_group_id']; ?>][<?php echo $command; ?>]" value="1" 
                                          <?php echo (!empty($image_manager_plus_command[$user_group['user_group_id']][$command]))?'checked="checked"':''; ?>/>
                                       <?php echo ucwords($label); ?>
                                       </label>
                                    </div>
                                    <?php } ?>
                                 </div>
                              </div>
                              <!--col --> 
                           </div>
                           <!-- form-group--> 
                        </div>
                        <?php $i++; } ?>
                     </div>
                     <!--tab-content --> 
                  </form>
               </div>
            </div>
            <!--panel --> 
         </div>
      </div>
      <!--tab-content --> 
   </div>
   <!--//container-fluid --> 
</div>
<script type="text/javascript"><!--
   $(document).ready(function() {
   $('#elfinder').elfinder({
   url: '<?php echo str_replace('&amp;','&',$filemanager);?>',  
   lang: 'vi',
   resizable: false,
   <?php echo str_replace(',]',']',$cmd);?> 
   contextmenu: {
   navbar: ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
   cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
   files: ['getfile', '|', 'open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|','rm', '|', 'edit', 'rename', 'resize', '|', 'archive', 'extract', '|', 'info']
   },
   });
   
   });  
   //-->
</script>
<?php echo $footer; ?>