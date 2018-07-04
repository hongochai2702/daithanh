<!DOCTYPE html>
<!--[if IE]><![endif]-->
<!--[if IE 8 ]>
<html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie8">
   <![endif]-->
   <!--[if IE 9 ]>
   <html dir="<?php echo $direction; ?>" lang="<?php echo $lang; ?>" class="ie9">
      <![endif]-->
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
            <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
             <script src="catalog/view/javascript/angular/1.5/angular.min.1.5.8.js" type="text/javascript"></script>
            <link href="catalog/view/javascript/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen" />
            <script src="catalog/view/javascript/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
            <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed%3A400%2C700%7COpen+Sans%3A400%2C600%2C700&subset=latin%2Clatin-ext" rel="stylesheet" type="text/css" />
            <link href="catalog/view/javascript/jquery/owl-carousel/assets/owl.carousel.css" type="text/css" rel="stylesheet" media="screen" />
            <script src="catalog/view/javascript/jquery/owl-carousel/owl.carousel.min.js" type="text/javascript"></script>
            <link rel='stylesheet' id='swiper-css'  href='catalog/view/theme/default/stylesheet/swiper/css/swiper.css' type='text/css' media='all' />
            <script type="text/javascript" src="catalog/view/theme/default/stylesheet/swiper/js/swiper.min.js"></script>
            <link href="catalog/view/javascript/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="catalog/view/theme/default/stylesheet/style.css" rel="stylesheet">
            <link href="catalog/view/theme/default/stylesheet/important.css" rel="stylesheet">
            <script src="catalog/view/theme/default/javascript/main.js" type="text/javascript"></script>
            <?php foreach ($styles as $style) { ?>
            <link href="<?php echo $style['href']; ?>" type="text/css" rel="<?php echo $style['rel']; ?>" media="<?php echo $style['media']; ?>" />
            <?php } ?>
            <script src="catalog/view/javascript/angular/app.js" type="text/javascript"></script>
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
         </head>
         <body class="<?php echo $class; ?> home page-template-default page page-id-2 fl-builder fl-preset-default fl-full-width fl-scroll-to-top">
            <div class="fl-page">
            <div class="fl-page-header">
               <!-- .fl-page-header-fixed -->
               <header class="fl-page-header fl-page-header-primary fl-page-nav-right fl-page-nav-toggle-icon fl-page-nav-toggle-visible-mobile" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
                  <div class="fl-page-header-wrap">
                     <div class="fl-page-header-container container">
                        <div class="fl-page-header-row row">
                           <div class="col-md-3 col-sm-12 fl-page-header-logo-col">
                              <div class="fl-page-header-logo" itemscope="itemscope" itemtype="http://schema.org/Organization">
                                 <a href="<?php echo $home; ?>" itemprop="url">
                                 <img class="fl-logo-img" itemscope="" itemtype="http://schema.org/ImageObject" src="<?php echo $logo; ?>" data-retina="<?php echo $logo; ?>" alt="<?php echo $name; ?>">
                                 </a>
                              </div>
                           </div>
                           <div class="fl-page-nav-col col-md-9 col-sm-12">
                              <div class="fl-page-bar">
                                 <div class="fl-page-bar-container">
                                    <div class="fl-page-bar-row row">
                                       <div class="col-md-10 col-sm-10 text-left clearfix top_wl">
                                          <div class="content-top">
                                             <div class="item-content">
                                                <div class="title">
                                                   <i class="fa fa-calendar-o"></i>
                                                   <strong>Ngày làm việc</strong>
                                                </div>
                                                <p class="lead">
                                                   <?php echo $open_day; ?>
                                                </p>
                                             </div>
                                             <div class="item-content">
                                                <div class="title">
                                                   <i class="fa fa-clock-o"></i>
                                                   <strong>Giờ làm việc</strong>
                                                </div>
                                                <p class="lead"><?php echo $open_hour; ?></p>
                                             </div>
                                             <div class="item-content hotline">
                                                <div class="title">
                                                   <i class="fa fa-headphones"></i>
                                                   <strong>Hotline <a href="tel:<?php echo trim($telephone); ?>" class="phone-number"><?php echo $telephone; ?></a></strong>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="col-md-2 col-sm-2 text-right clearfix lg-2">
                                          <div class="list-languages pull-right">
                                             <div class="dropdown">
                                                <a class="dropdown-toggle" type="button" data-toggle="dropdown">VIE
                                                <span class="fa fa-chevron-down"></span></a>
                                                <ul class="dropdown-menu">
                                                   <li><a href="#">EN</a></li>
                                                </ul>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <!-- .fl-page-bar -->
                           </div>
                        </div>
                     </div>
                  </div>
               </header>
               <div class="header-nav-bottom">
                  <div class="container">
                     <div class="col-sm-3"></div>
                     <div class="col-sm-9 col-menu"><?php echo $main_menu; ?></div>
                  </div>
               </div>
               <!-- .fl-page-header -->
            </div>
            <!-- /.fl-page-header -->
            <div class="fl-page-content">