<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li> <a href="<?php echo $breadcrumb['href']; ?>"> <?php echo $breadcrumb['text']; ?> </a> </li>
    <?php } ?>
  </ul>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <h1><?php echo $heading_title; ?></h1>
      <?php if ($categories) { ?>
      <p><strong><?php echo $text_index; ?></strong>
        <?php foreach ($categories as $categorysev) { ?>
        &nbsp;&nbsp;&nbsp;<a href="index.php?route=product/manufacturersev#<?php echo $categorysev['name']; ?>"><?php echo $categorysev['name']; ?></a>
        <?php } ?>
      </p>
      <?php foreach ($categories as $categorysev) { ?>
      <h2 id="<?php echo $categorysev['name']; ?>"><?php echo $categorysev['name']; ?></h2>
      <?php if ($categorysev['manufacturersev']) { ?>
      <?php foreach (array_chunk($categorysev['manufacturersev'], 4) as $manufacturersevs) { ?>
      <div class="row">
        <?php foreach ($manufacturersevs as $manufacturersev) { ?>
        <div class="col-sm-3"><a href="<?php echo $manufacturersev['href']; ?>"><?php echo $manufacturersev['name']; ?></a></div>
        <?php } ?>
      </div>
      <?php } ?>
      <?php } ?>
      <?php } ?>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary"><?php echo $button_continue; ?></a></div>
      </div>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>