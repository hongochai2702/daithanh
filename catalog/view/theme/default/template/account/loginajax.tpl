<div class="cd-user-modal" ng-controller="loginCtrl">
<div class="cd-user-modal-container">
<ul class="cd-switcher">
<li><a href="javascript:void(0);" class=""><?php echo $button_login; ?></a></li>
<li><a href="javascript:void(0);" class="selected"><?php echo $text_register; ?></a></li>
</ul>
<div id="cd-login"> 
<form method="post" enctype="multipart/form-data" id="at_loginform" class="cd-form">
  <div id="login_load" style="    text-align: center;margin-bottom: 10px;display: none;position: absolute;top: 17px;"><img src="catalog/view/theme/hitech/image/login_load.gif"></div>
<p class="social-login">
<span class="social-login-facebook"><a href="javascript:void(0);" class="ocx-fb-login-trigger fb-login-uid-0" fb-login-uid="0"><i class="fa fa-facebook"></i> Login with Facebook</a></span>
</p>
<div class="lined-text alert_login"><span><?php echo $text_returning_customer; ?></span><hr></div>
<p class="fieldset">
<label class="image-replace cd-email" for="login-email"><?php echo $entry_email; ?></label>
<input type="text" name="email" id="input-email" placeholder="<?php echo $entry_email; ?>" class="full-width has-padding has-border">
</p>
<p class="fieldset">
<label class="image-replace cd-password" for="login-password"><?php echo $entry_password; ?></label>
<input type="password" name="password" id="input-password" placeholder="<?php echo $entry_password; ?>" class="full-width has-padding has-border">
<a href="javascript:void(0);" class="show-hide-password">Show</a>
</p>
<input type="hidden" name="login_stay_here" id="login-stay-here" value="0">
<p class="fieldset">
<button type="button" id="button-customer" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $button_login; ?>..." class="full-width btn-buttom" ng-click="login();"><i class="fa fa-arrow-right"></i> <?php echo $button_login; ?></button>
</p>
</form>
<p class="cd-form-bottom-message"><a href="<?php echo $forgotten; ?>"><?php echo $text_forgotten; ?></a></p>
</div> 
<div id="cd-signup" class="is-selected"> 
<form class="cd-form">
<div id="register_load" style="    text-align: center;margin-bottom: 10px;display: none;position: absolute;top: 17px;"><img src="catalog/view/theme/hitech/image/login_load.gif"></div>
<p class="social-login">
<span class="social-login-facebook"><a href="javascript:void(0);" class="ocx-fb-login-trigger fb-login-uid-1" fb-login-uid="1"><i class="fa fa-facebook"></i> Register with Facebook</a></span>
</p>
<div class="lined-text alert_register"><span><?php echo $text_register; ?></span><hr></div>
<p class="fieldset">
<label class="image-replace cd-email" for="signup-email">Email</label>
<input type="text" name="signup_email" id="signup-email" placeholder="Email" class="full-width has-padding has-border">
</p>
<p class="fieldset">
<label class="image-replace cd-password" for="signup-password"></label>
<input type="password" name="signup_password" id="signup-password" placeholder="Password" class="full-width has-padding has-border">
<a href="javascript:void(0);" class="show-hide-password">Show</a>
</p>
<p class="fieldset">
<label class="image-replace cd-password" for="signup-confirm-password"></label>
<input type="password" name="signup_confirm_password" id="signup-confirm-password" placeholder="Confirm Password" class="full-width has-padding has-border">
<a href="javascript:void(0);" class="show-hide-password">Show</a>
</p>
<p class="fieldset">
<button class="full-width has-padding btn-buttom" type="submit" value="" ng-click="register();" id="button-register" data-loading-text="<i class='fa fa-spinner fa-spin '></i> <?php echo $button_login; ?>...">Create account</button>
</p>
</form>

</div> 

 
<div class="loading-mask-overlay">
<div class="loading-mask-loading">
<div class="uil-ripple-css"><div></div><div></div></div>
</div>
</div>
</div> 
</div>