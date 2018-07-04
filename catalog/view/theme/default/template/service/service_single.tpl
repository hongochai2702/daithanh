<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
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
    <div id="content" class="blogs-single-wrap <?php echo $class; ?>">
      <h1 class="heading"><?php echo $heading_title; ?></h1>
      <div class="post-meta">
        <ul class="meta">
          <li><a href="#author"><img src="catalog/view/theme/default/images/theme/blogs/user-silhouette.png" alt=""> Văn Chót</a></li>
          <li><a href="#date"><img src="catalog/view/theme/default/images/theme/blogs/calendar.png" alt=""> 15/3/2017</a></li>
          <li><a href="#comment"><img src="catalog/view/theme/default/images/theme/blogs/comments.png" alt=""> 2 bình luận</a></li>
        </ul>
        
      </div>
      <!-- .post-meta -->
      <div class="blogs-info">
        <?php echo $description; ?>
        <div class="tags">
          <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
          <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
          <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>