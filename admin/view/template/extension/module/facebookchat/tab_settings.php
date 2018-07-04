<div class="panel-body">
    <div class="form-group"> 

        <lable class="col-sm-4 control-label">
            <h5><strong><?php echo $text_user_contact; ?></strong></h5>
            <span class="help"><i class="fa fa-info-circle"></i>&nbsp;<?php echo $text_user_contact_help; ?></span>
        </lable>
        <div class="col-sm-8">
            <div class="input-group" style="width:428px;margin:14px">               
                <input type="text" class="form-control" name="<?php echo $moduleNameSmall; ?>[username]" value="<?php if(isset($moduleData['username'])) { echo $moduleData['username']; }?>"  required />
            </div>
        </div>
    </div> 
    <ul class="nav nav-tabs">
        <?php foreach ($languages as $language) { ?>
        <li data-toggle="tooltip"  data-original-title="<?php echo $language['name']; ?>"><a href="#welcome-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="view/image/flags/<?php echo $language['image']; ?>" title="<?php echo $language['name']; ?>" /></a></li>
        <?php } ?>
    </ul>

    <div class="form-group">
        <lable class="col-sm-4 control-label">
            <h5><strong><?php echo $text_welcome; ?></strong></h5>
        </lable>
        <div class="col-sm-8">
            <div class="tab-content">
                <?php foreach($languages as $language) { ?>
                <div class="tab-pane" id="welcome-<?php echo $language['language_id']; ?>">
                    <div class="input-group" style="width:428px;margin:14px">   
                        <div class="form-group" style="overflow: hidden;">            
                            <input type="text" class="form-control" name="<?php echo $moduleNameSmall; ?>[welcom1][<?php echo $language['language_id'] ?>]" value="<?php if(isset($moduleData['welcom1'][$language['language_id']])) { echo $moduleData['welcom1'][$language['language_id']];} ?>" required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="<?php echo $moduleNameSmall; ?>[welcom2][<?php echo $language['language_id'] ?>]" value="<?php if(isset($moduleData['welcom2'][$language['language_id']])) {
                                   echo $moduleData['welcom2'][$language['language_id']];} ?>" required>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

    </div>
</div>

