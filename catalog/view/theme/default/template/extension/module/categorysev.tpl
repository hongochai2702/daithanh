<div class="list-group">
  <?php foreach ($categories as $categorysev) { ?>
  <?php if ($categorysev['categorysev_id'] == $categorysev_id) { ?>
  <a href="<?php echo $categorysev['href']; ?>" class="list-group-item active"><?php echo $categorysev['name']; ?></a>
  <?php if ($categorysev['children']) { ?>
  <?php foreach ($categorysev['children'] as $child) { ?>
  <?php if ($child['categorysev_id'] == $child_id) { ?>
  <a href="<?php echo $child['href']; ?>" class="list-group-item active">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
  <?php } else { ?>
  <a href="<?php echo $child['href']; ?>" class="list-group-item">&nbsp;&nbsp;&nbsp;- <?php echo $child['name']; ?></a>
  <?php } ?>
  <?php } ?>
  <?php } ?>
  <?php } else { ?>
  <a href="<?php echo $categorysev['href']; ?>" class="list-group-item"><?php echo $categorysev['name']; ?></a>
  <?php } ?>
  <?php } ?>
</div>
