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

				<div class="section-services">

					<div id="layers-widget-posts" class="layers-widget-posts widget widget-service">

				      <div class="container clearfix">

				         <div class="row post-layout-list">

				          <?php foreach ($services as $key => $service) { ?>

				            <div class="post-item col-md-4 post-id-<?php echo $service['service_id']; ?> <?php echo ($key == 0) ? 'first-item-service' : ''; ?>">

				               <div class="media-image">

				                  <a href="<?php echo $service['href']; ?>" class="post-link">

				                  <img src="<?php echo $service['image']; ?>" alt="<?php echo $service['name']; ?>">

				                  </a>

				               </div>

				               <div class="media-body">

				                  <a href="#link_service">

				                     <h3 class="heading"><?php echo $service['name']; ?></h3>

				                     <div class="lead"><?php echo $service['description']; ?></div>

				                  </a>

				               </div>

				            </div>

				          <?php } ?>

				         </div>

				      </div>

				   </div>

				</div>

				

				<div id="paginate">

					<?php echo $pagination; ?>

				</div>

			</div>

		</div>

      <?php echo $content_bottom; ?></div>

    <?php echo $column_right; ?></div>

</div>

<?php echo $footer; ?>