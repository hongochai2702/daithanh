<div id="contact-form-id-<?php echo $module_id; ?>" class="contact-form">
  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
    <fieldset>
      <div class="form-group required field-company_name">
        <div class="col-sm-12">
          <input type="text" name="company_name" value="<?php echo $company_name; ?>" id="input-company_name" class="form-control" placeholder="<?php echo $entry_company_name; ?>" />
          
        </div>
      </div>
      <div class="form-group">
        <div class="col-md-4">
          <div class="required field-phone">
              <input type="text" name="phone" value="<?php echo $phone; ?>" id="input-phone" class="form-control" placeholder="<?php echo $entry_phone; ?>"/>
              
          </div>
        </div>
        <div class="col-md-8">
          <div class="required field-email">
            <input type="text" name="email" value="<?php echo $email; ?>" id="input-email" class="form-control" placeholder="<?php echo $entry_email ?>"/>
          </div>
        </div>
      </div>
      <div class="form-group required field-enquiry">
        <div class="col-sm-12">
          <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control" placeholder="<?php echo $entry_enquiry; ?>"><?php echo $enquiry; ?></textarea>
          
        </div>
      </div>
      <?php echo $captcha; ?>
    </fieldset>
    <div class="buttons">
      <p class="result-success"></p>
      <div class="pull-left">
        <input class="btn btn-primary" type="submit" value="<?php echo $button_submit; ?>" id="submit-form<?php echo $module_id; ?>"/>
        <input type="reset" id="configreset" value="Reset" style="display: none">
      </div>
    </div>
  </form>
</div>

<script type="text/javascript">
  jQuery(document).ready(function($) {
    var button_submit = "#submit-form<?php echo $module_id; ?>";
    $(button_submit).on('click', function(e) {
      e.preventDefault();
      var actionUrl = $(".form-horizontal").attr('action'); 
      var formData = $(".form-horizontal").serialize(); 
      $(".result-success").hide();
      $.ajax({
        url: actionUrl,
        type: 'POST',
        dataType: 'json',
        data: formData,
        beforeSend: function( xhr ) {
          $(button_submit).button('loading');
        }
      })
      .done(function(res) {
        $(button_submit).button('reset');
        if ( !res.error ) {
          $(".result-success").text(res.success);
          $(".result-success").fadeIn('slow');
          $("#configreset").trigger('click');
          $(".contact-form .form-group .alert").delay(10000).fadeOut('slow');
        } else{
          $.each(res.error, function(index, el) {
            $(".field-" + index).append('<div class="alert alert-danger"> <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a><strong>Danger!</strong> ' + el + '</div>');
          });
          $(".contact-form .form-group .alert").delay(3000).fadeOut('slow');
        }
      })
      .fail(function(res) {
        $(button_submit).button('reset');
        alert('Có lỗi trong quá trình gửi thông tin ! Xin vui lòng liên hệ quản trị !');
      });
    });
  });
</script>