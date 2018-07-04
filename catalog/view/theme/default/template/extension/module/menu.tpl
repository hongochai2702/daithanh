<div class="fl-page-nav-wrap">
  <nav class="fl-page-nav fl-nav navbar navbar-default" itemscope="itemscope" itemtype="http://schema.org/SiteNavigationElement">
     <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".fl-page-nav-collapse">
      <span><i class="fa fa-bars"></i></span>
     </button>
     <?php if( $type != "vertical" ) { ?>
         <div class="fl-page-nav-collapse collapse navbar-collapse">
            <ul id="<?php echo $code . '-' . $info['menu_id']; ?>" class="nav navbar-nav navbar-left menu">
                <?php foreach ($menus as $menu1) { ?>
                <li class="menu-item menu-type-<?php echo $menu1['module_type']; ?> menu-style-<?php echo $menu1['style']; ?> menu-item-<?php echo $menu1['id'] ?>">
                    <a href="<?php echo $menu1['url'] ?>"><?php echo $menu1['title'] ?></a>
                </li>
                <?php } ?>
            </ul>
         </div>
    <?php } else { ?>
        <div class="fl-page-nav-collapse collapse navbar-collapse menu-horizontal">
            <ul id="<?php echo $code . '-' . $info['menu_id']; ?>" class="nav navbar-nav menu">
                <?php foreach ($menus as $menu1) { ?>
                <li class="menu-item menu-type-<?php echo $menu1['module_type']; ?> menu-style-<?php echo $menu1['style']; ?> menu-item-<?php echo $menu1['id'] ?>">
                    <a href="<?php echo $menu1['url'] ?>"><?php echo $menu1['title'] ?></a>
                </li>
                <?php } ?>
            </ul>
         </div>
    <?php } ?>
  </nav>
</div>