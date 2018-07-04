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
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
     	<h1 class="hidden"><?php echo $heading_title; ?></h1>
		<div class="blogs-category-wrapper">
			<div class="row">
				<?php foreach ( $blogss as $key => $blogs ) { ?>
				<?php if( $key == 0 ) { ?>
					<div class="featured-post post-item post-id-<?php echo $blogs['blogs_id']; ?> col-md-12 col-xs-12">
						<div class="post-wrapper">
							<div class="media-image">
								<a href="<?php echo $blogs['href']; ?>" class="image-link">
									<img src="<?php echo $blogs['image']; ?>" alt="<?php echo $blogs['name']; ?>">
								</a>
							</div>
							<!-- /.media-image -->
							<div class="post-body">
								<a href="<?php echo $blogs['href']; ?>" class="post-link"><h3 class="heading"><?php echo $blogs['name']; ?></h3></a>
								<!-- .heading -->
								<div class="post-meta">
									<ul class="meta">
										<li><a href="#author"><img src="catalog/view/theme/default/images/theme/blogs/user-silhouette.png" alt=""> Văn Chót</a></li>
										<li><a href="#date"><img src="catalog/view/theme/default/images/theme/blogs/calendar.png" alt=""> 15/3/2017</a></li>
										<li><a href="#comment"><img src="catalog/view/theme/default/images/theme/blogs/comments.png" alt=""> 2 bình luận</a></li>
									</ul>
								</div>
								<!-- .post-meta -->
								<p class="post-descriptions">
									Trước tiên bạn cần quan tâm đến nồng độ ô nhiễm khí thải phát ra trong quá trình sản xuất của bạn cao hay thấp như vậy bạn sẽ có một công nghệ xử lý tương thích . Sau đây công nghệ xử lý khí thải lò hơi cơ bản bạn có thể tham khảo…
									<?php //echo $blogs['description']; ?>
								</p>
								<!-- /.post-descriptions -->
							</div>
							<!-- .post-body -->
						</div>
					</div>
				<?php } else { ?>
					<div class="post-item post-id-<?php echo $blogs['blogs_id']; ?> col-md-6 col-xs-12">
						<div class="post-wrapper">
							<div class="media-image">
								<a href="<?php echo $blogs['href']; ?>" class="image-link">
									<img src="<?php echo $blogs['image']; ?>" alt="<?php echo $blogs['name']; ?>">
								</a>
							</div>
							<!-- /.media-image -->
							<div class="post-body">
								<a href="<?php echo $blogs['href']; ?>" class="post-link"><h3 class="heading"><?php echo $blogs['name']; ?></h3></a>
								<!-- .heading -->
								<div class="post-meta">
									<ul class="meta">
										<li><a href="#author"><img src="catalog/view/theme/default/images/theme/blogs/user-silhouette.png" alt=""> Văn Chót</a></li>
										<li><a href="#date"><img src="catalog/view/theme/default/images/theme/blogs/calendar.png" alt=""> 15/3/2017</a></li>
										<li><a href="#comment"><img src="catalog/view/theme/default/images/theme/blogs/comments.png" alt=""> 2 bình luận</a></li>
									</ul>
								</div>
								<!-- .post-meta -->
								<p class="post-descriptions">
									<?php echo $blogs['description']; ?>
								</p>
								<!-- /.post-descriptions -->
							</div>
							<!-- .post-body -->
						</div>
					</div>
				<?php } ?>
				<?php } //foreach ?>
				<div id="paginate">
					<?php echo $pagination; ?>
				</div>
			</div>
		</div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>