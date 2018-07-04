<!DOCTYPE html>

<!--[if IE]><![endif]-->

<!--[if IE 8 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8"><![endif]-->

<!--[if IE 9 ]><html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9"><![endif]-->

<!--[if (gt IE 9)|!(IE)]><!-->

<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" ng-app="myApp">

<!--<![endif]-->

<head>

<meta charset="UTF-8" />

<meta name="viewport" content="width=device-width, initial-scale=1">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<title><?php echo $title; ?></title>

<base href="<?php echo $base; ?>" />

<?php if ($description) { ?>

<meta name="description" content="<?php echo $description; ?>" />

<?php } ?>

<?php if ($keywords) { ?>

<meta name="keywords" content= "<?php echo $keywords; ?>" />

<?php } ?>
<link rel="stylesheet" href="catalog/view/theme/hitech/angular/library/loading-bar.min.css">

<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/library/angular.min.1.5.8.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/library/ocLazyLoad.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/library/angular-ui-router.min.js" type="text/javascript"></script>


<link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
<script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/library/loading-bar.min.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/app.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/controller/appCtrl.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/js/main.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/controller/controller.js" type="text/javascript"></script>
<!-- <script src="catalog/view/theme/hitech/angular/library/angular-moment.min.js"></script> -->
<script src="catalog/view/theme/hitech/angular/config.constant.js" type="text/javascript"></script>
<script src="catalog/view/theme/hitech/angular/router.js" type="text/javascript"></script>
<link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />

<link href="catalog/view/theme/hitech/stylesheet/line-icons.css" rel="stylesheet" type="text/css" />

<link href="catalog/view/theme/default/stylesheet/stylesheet.css" rel="stylesheet">

<link href="catalog/view/theme/hitech/stylesheet/header-v6.css" rel="stylesheet">

<link href="catalog/view/theme/hitech/stylesheet/quick-auth.css" rel="stylesheet">

<link href="catalog/view/theme/hitech/stylesheet/blocks.css" rel="stylesheet">

<link href="catalog/view/theme/hitech/stylesheet/app.css" rel="stylesheet">

<link href="catalog/view/theme/hitech/stylesheet/footer-v6.css" rel="stylesheet">

<?php foreach ($styles as $style) { ?>

<link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />

<?php } ?>

<script src="catalog/view/javascript/common.js" type="text/javascript"></script>

<?php foreach ($links as $link) { ?>

<link href="<?php echo $link['href']; ?>" rel="<?php echo $link['rel']; ?>" />

<?php } ?>

<?php foreach ($scripts as $script) { ?>

<script src="<?php echo $script; ?>" type="text/javascript"></script>

<?php } ?>

<?php foreach ($analytics as $analytic) { ?>

<?php echo $analytic; ?>

<?php } ?>


	


<script type="text/javascript">
	// $(document).ready(function(){
	// var s = $('.common-home');
	// var pos = s.position();			
	// // s.addClass("header-fixed");		   
	// $(window).scroll(function() {
	// 	var windowpos = $(window).scrollTop();
	// 	if (windowpos > 20) {
	// 		s.addClass("header-fixed");
	// 	} else {
	// 		s.removeClass("header-fixed");	
	// 	}
	// });
	// });

</script>
</head>

<body  ng-controller="appCtrl" class="{{cssClassName}}">

<?php echo $header_top; ?>

<div class="header-v6 header-dark-transparent header-sticky">



<div class="navbar mega-menu" role="navigation">

<div class="container">



<div class="menu-container">

<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">

<span class="sr-only">Toggle navigation</span>

<span class="icon-bar"></span>

<span class="icon-bar"></span>

<span class="icon-bar"></span>

</button>



<div class="navbar-brand">

        <?php if ($logo) { ?>

          <a ui-sref="home"><img src="<?php echo $logo; ?>" title="<?php echo $name; ?>" alt="<?php echo $name; ?>" class="img-responsive" /></a>

          <?php } else { ?>

          <h1><a ui-sref="home"><?php echo $name; ?></a></h1>

          <?php } ?>

</div>





<div class="header-inner-right">

<ul class="menu-icons-list">

<li class="menu-icons">

<i class="menu-icons-style search search-btn fa fa-search"></i>
<?php echo $search; ?>
</li>
<?php echo $cart; ?>
 <?php if ($logged) { ?>
 <li class="dropdown menu-icons account">
 	<a href="" title="<?php echo $text_account; ?>" class="dropdown-toggle btn-u btn-brd btn-brd-hover btn-u-light-dark cd-signin text-uppercase hidden-sm hidden-xs" data-toggle="dropdown"><img src="image/catalog/author.png" style="width: 30px;">
          </a> <ul class="dropdown-menu dropdown-menu-right">
            <li><a ui-sref="account({code:'index.php?routes=account/account'})"><?php echo $text_account; ?></a></li>
            <li><a ui-sref="account({code:'index.php?routes=account/order'})"><?php echo $text_order; ?></a></li>
            <li><a ui-sref="account({code:'index.php?routes=account/transaction'})"><?php echo $text_transaction; ?></a></li>
            <li><a ui-sref="account({code:'index.php?routes=account/download'})"><?php echo $text_download; ?></a></li>
            <li><a ui-sref="account({code:'index.php?routes=account/logout'})"><?php echo $text_logout; ?></a></li>
          </ul>
         
        </li>
  <?php } else { ?>
<li class="menu-icons account cd-log-reg">
<a class="btn-u btn-brd btn-brd-hover btn-u-light-dark cd-signin text-uppercase hidden-sm hidden-xs" href="javascript:void(0);">Login</a>
</li>
<?php } ?>

<li class="menu-icons hidden">

<i class="menu-icons-style search search-close search-btn fa fa-times"></i>

</li>

</ul>

</div>



</div>



<div class="collapse navbar-collapse navbar-responsive-collapse">

<div class="menu-container">

<ul class="nav navbar-nav">
<li><a ui-sref="home">Trang chủ</a></li>
<li><a ui-sref="category({code:'kho-giao-dien'})">Kho giao diện</a></li>



<li class="dropdown">

<a ui-sref="category({code:'kho-ung-dung'})" class="dropdown-toggle" data-toggle="dropdown">Kho ứng dụng <i class="fa fa-angle-down"></i></a>

<ul class="dropdown-menu">


<li><a ui-sref="category({code:'web-ban-hang'})">Website bán hàng</a></li>

<li><a ui-sref="category({code:'web-gioi-thieu'})">Website giới thiệu</a></li>

<li><a ui-sref="category({code:'web-tin-tuc'})">Website tin tức</a></li>

</ul>

</li>

<li><a ui-sref="information.about({code:'dich-vu'})">Dịch vụ</a></li>
<li><a ui-sref="information.about({code:'about'})">Tin tức</a></li>


</ul>

</div>

</div>

</div>

</div>



</div>


<div class="container-fluid no-padding" id="page-home">

<div class="row no-margin">

<div id="content" class="col-sm-12 no-padding">

	<?php if (!$logged) { ?>
    <?php echo $loginajax; ?>
	<?php } ?>
	<div ui-view class="main ui-resolve"></div>
<?php echo $footer; ?>