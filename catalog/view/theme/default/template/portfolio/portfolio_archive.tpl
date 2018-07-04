<?php echo $header; ?>
<div class="container">
  <ul class="breadcrumb">
    <?php foreach ($breadcrumbs as $breadcrumb) { ?>
    <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
    <?php } ?>
  </ul>
</div>
  <div class="row"><?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div id="content" class="<?php echo $class; ?> portfolio-category portfolio-page"><?php echo $content_top; ?>
     	<h1 class="hidden"><?php echo $heading_title; ?></h1>
		<div class="portfolio-category-wrapper">
			<div class="container">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<?php if ( !empty($categories) ) { ?>	
							<ul class="list-cate">
								<?php foreach ($categories as $cat) { ?>
									<li><a href="<?php echo $cat['href']; ?>"><?php echo $cat['name'] ?></a></li>
								<?php } ?>
							</ul>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="list-portfolio">
						<div class="grid-layout">
							<?php if( !empty($portfolios) ) { ?>
								<?php foreach ($portfolios as $portfolio) { ?>
									<div class="post-item col-md-4 post-id-<?php echo $portfolio['portfolio_id'] ?>">
									   <div class="media-image">
									      <a href="<?php echo $portfolio['href']; ?>" class="post-link">
									      <img class="owl-lazy" src="<?php echo $portfolio['thumb']; ?>" alt="<?php echo $portfolio['name']; ?>" >
									      </a>
									   </div>
									   <div class="media-body">
									      <a href="<?php echo $portfolio['href']; ?>" class="post-link">
									         <h3 class="heading"><?php echo $portfolio['name']; ?></h3>
									      </a>
									      <div class="meta-info">
									         <div class="cat-item"><a href="#cat-link">Đồng Nai</a></div>
									      </div>
									      <p class="excerpt">
									      </p>
									      <p><?php echo $portfolio['short_description']; ?><br></p>
									      <p></p>
									   </div>
									</div>
								<?php } ?>
							<?php } ?>
						</div>
					</div>
					
					<div id="pagination-wrapper">
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>
		</div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
<?php echo $footer; ?>