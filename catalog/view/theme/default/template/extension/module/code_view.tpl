<div id="module-html-<?php echo $module_id; ?>">
	<?php if( !empty($heading_title) ) { ?>
		<div class="heading">
		  <h2><?php echo $heading_title ?></h2>
		  <div class="line"></div>
		</div>
	<?php } ?>
	<?php if( !empty($html) ) { ?>
		<div class="excerpt"><?php echo $html; ?></div>
	<?php } ?>
</div>

