<div class="modal-dialog modal-lg" style="width: 90%;">
  <div class="modal-content" style="border-radius: 0px; border:0px;">
    <div class="modal-body" style="padding:0px;overflow:hidden;">
<?php $insertfiles=(isset($_GET['bulk_insert'])==true)?"'insertfiles',":""; ?> 
<?php $mutiimage=(isset($_GET['editor']) && $_GET['editor']=='tinymce')?"'mutiimage',":""; ?> 
	 <?php       
     $image_command=(!empty($image_manager_plus_command))?$image_manager_plus_command:array();
            $commands=array(
                'mkdir',	
                'mkfile',	
                'upload',	
                'reload',	
                'up',	
                'download',	
                'rm',	
                'duplicate',	
                'rename',	
                'copy',	
                'cut',	
                'paste',	
                'edit',	
                'extract',	
                'archive',	
                'view',	
                'sort',	
                'search'
                );  
           $cmd = "commands: [";
            if($user_group_id){
                 foreach ($commands as $command=>$value) { 
                     if(!empty($image_command[$user_group_id][$command])){
                        $cmd .="'".$command."',";
                     }
                  } 
              }
            $cmd .=$insertfiles;
            $cmd .=$mutiimage;
            $cmd .="],";     
        ?> 
    <div id="elfinder" style="width:100%;"></div>  
    <div class="modal-footer" style="background: #f3f3f3;">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Đóng lại</button>
    </div>
  </div><!--//modal-body --> 
  </div>
</div>
<script type="text/javascript"><!--
      $(document).ready(function() {
             $('#elfinder').elfinder({
                 url: 'index.php?routes=extension/feed/image_manager_plus/popup&token=<?php echo $token; ?>',
                 lang: 'vi',
                 height: 500,
                 resizable: true,
                 commands: [<?php if($user_group_id){
				foreach ($commands as $command) { ?>
				  <?php echo (!empty($image_command[$user_group_id][$command]))?'\''.$command.'\',':''; ?>
				 <?php } } ?><?php echo $insertfiles;  ?><?php echo $mutiimage;  ?> 
                             ],
                 contextmenu: {
                     // navbarfolder menu
                     navbar: ['open', '|', 'copy', 'cut', 'paste', 'duplicate', '|', 'rm', '|', 'info'],
                     // current directory menu
                     cwd: ['reload', 'back', '|', 'upload', 'mkdir', 'mkfile', 'paste', '|', 'info'],
                     // current directory file menu
                     files: [<?php echo $mutiimage;  ?><?php echo $insertfiles;?> 'getfile', '|', 'open', 'quicklook', '|', 'download', '|', 'copy', 'cut', 'paste', 'duplicate', '|','rm', '|', 'edit', 'rename', '|', 'archive', 'extract', '|', 'info']
                 },
		 dirimage: '<?php echo $http_image;?>',
		 getFileCallback: function (a) { 		
					 <?php if (isset($_GET['target'])==true){ 
						 $field = $_GET['target']; ?>
						   var b = decodeURIComponent(a.replace('<?php echo $http_image;?>',''));
							$('#<?php echo $field;?>').attr('value', b);
							 <?php if (isset($_GET['thumb'])==true){
								 $thumb = $_GET['thumb']; ?>
									$.ajax({
											url: 'index.php?routes=extension/feed/image_manager_plus/thumb&token=<?php echo $token; ?>&image=' + encodeURIComponent(b),
											dataType: 'text',
											success: function(data) {									
												$('#<?php echo $thumb;?>>img').attr('src', data);
												$('#<?php echo $thumb;?>>img').attr('class',"img-reponsive"); 
											}
										});
						
							<?php } ?>
					<?php }?>
					<?php 	$bulk_insert = isset($_GET['bulk_insert'])?true:false;
                                                $thumb_insert = isset($_GET['thumb'])?true:false;
                                                $target_insert = isset($_GET['target'])?true:false;
					 if ($bulk_insert==false && $thumb_insert==false && $thumb_insert==false && !isset($_GET['editor'])){ ?> 
							var range, sel = window.getSelection(); 
							if (sel.rangeCount) { 
								var img = document.createElement('img');
								img.className = 'img_insert';
								img.style = 'max-width:100%; height:auto';
								img.src = a;
								range = sel.getRangeAt(0); 
								range.insertNode(img);  
							} 
                                    	<?php } ?> 
                                        <?php if(isset($_GET['editor'])) { ?> 
                                            if(tinymce!=undefined && tinymce.settings.app_default=='cdv'){ 
                                                    tinymce.activeEditor.execCommand('mceInsertContent',false,"<img src='"+a+"'/>");
                                            }
                                        <?php } ?>
					if($('#modal-image').length){
					$('#modal-image').modal('hide');
					}
				}//getFileCallback
                });
         })	;	
//--></script>