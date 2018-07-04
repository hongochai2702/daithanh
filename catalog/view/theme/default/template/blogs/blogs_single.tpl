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
      <div class="story">
        <h1 class="heading"><?php echo $heading_title; ?></h1>
          <div class="post-meta">
            <ul class="meta">
              <li><a href="#author"><img src="catalog/view/theme/default/images/theme/blogs/user-silhouette.png" alt=""> Văn Chót</a></li>
              <li><a href="#date"><img src="catalog/view/theme/default/images/theme/blogs/calendar.png" alt=""> 15/3/2017</a></li>
              <li><a href="#comment"><img src="catalog/view/theme/default/images/theme/blogs/comments.png" alt=""> 2 bình luận</a></li>
            </ul>
            <div class="social-custom">
              <?php echo $content_top; ?>
            </div>
          </div>
          <!-- .post-meta -->
          <div class="blogs-info">
            <?php echo $description; ?>
             <div class="tags">
              <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
              <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
              <a href="#tags"><div class="item">KHÍ THẢI MÔI TRƯỜNG</div></a>
            </div>
            <!-- .tag -->
            <div class="author-information">
              <div class="author-wrap">
                <div class="author-image">
                  <a href="#link-author" class="author-link"><img src="image/catalog/demo/blogs/author.png" alt="Tác giả" /></a>
                </div>
                <div class="author-content">
                  <div class="header">
                    <a href="#link-author" class="author-link"><h4>KS. Lê Văn Chót</h4></a>
                    <div class="social">
                      <ul class="social-wrap">
                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-facebook"></i></a></li>
                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-twitter"></i></a></li>
                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                          <li class="social-item"><a href="#link_social" target="_blank"><i class="fa fa-youtube"></i></a></li>
                       </ul>
                    </div>
                  </div>
                  <div class="body"><p class="desc">Với nhiều năm kinh nghiệm trong ngành tôi sẽ tư vấn cho bạn những giải pháp thi công an toàn và hiệu quả nhất</p></div>
                </div>
              </div>
            </div>
            <!-- .author-information -->
          </div>
          <!-- .blogs-info -->
      </div>

      <div class="comments-blogs">
        <div class="comment-wrapper">
          <div class="header">
            <div class="icon-comment"><img src="image/catalog/demo/blogs/blogs-comment.png" alt="Comment image" /></div>
            <h3 class="heading">Bình luận: </h3>
          </div>
          <div class="body">
            <form class="form-horizontal" action="index.php?routes=catalog/review" method="post" enctype="multipart/form-data" id="form-review">
             <div id="review">
                <link href="catalog/view/theme/default/stylesheet/comments.css" rel="stylesheet" />
                <!-- Contenedor Principal -->
                <div class="comments-container">
                   <div class="comment-head">
                      <h4 class="head-title">Ý KIẾN KHÁCH HÀNG <strong>(22)</strong></h4>
                      <ul class="head-sorting">
                         <li class="sort-featured active">Nổi bật</li>
                         <li class="sort-time">Mới nhất</li>
                      </ul>
                   </div>
                   <ul id="comments-list" class="comments-list">
                      <li>
                         <div class="comment-main-level">
                            <!-- Avatar -->
                            <div class="comment-meta">
                               <img src="catalog/view/theme/default/images/theme/blogs/avatar_silkhouse.gif" alt="Avatar Default" class="avatar-img">
                               <p class="comment-author"><a href="http://creaticode.com/blog">Hồ Ngọc Hải</a></p>
                               <div class="comment-content">
                                  Bình luận cha !              
                               </div>
                            </div>
                            <!-- Contenedor del Comentario -->
                            <div class="comment-box">
                               <div class="comment-actions">
                                  <a href="#" class="btnReply">Trả lời</a>
                                  <span class="separator">•</span>
                                  <a class="btnLike" href="#"><i class="fa fa-thumbs-o-up"></i> <strong>24</strong> Thích</a>
                                  <span class="separator">•</span>
                                  <a class="btnShare" href="#"><i class="fa fa-facebook-square"></i></a>
                                  <div class="time">1 giờ trước</div>
                               </div>
                            </div>
                         </div>
                         <!-- Respuestas de los comentarios -->
                         <ul class="comments-list reply-list">
                            <li>
                               <!-- Avatar -->
                               <div class="comment-meta">
                                  <img src="catalog/view/theme/default/images/theme/blogs/avatar_silkhouse.gif" alt="Avatar Default" class="avatar-img">
                                  <p class="comment-author"><a href="http://creaticode.com/blog">Chili Super</a></p>
                                  <div class="comment-content">
                                     hải trả lời oke                  
                                  </div>
                               </div>
                               <!-- Contenedor del Comentario -->
                               <div class="comment-box">
                                  <div class="comment-actions">
                                     <a href="#" class="btnReply">Trả lời</a>
                                     <span class="separator">•</span>
                                     <a class="btnLike" href="#"><i class="fa fa-thumbs-o-up"></i> <strong>24</strong> Thích</a>
                                     <span class="separator">•</span>
                                     <a class="btnShare" href="#"><i class="fa fa-facebook-square"></i></a>
                                     <div class="time">1 giờ trước</div>
                                  </div>
                               </div>
                            </li>
                            <li>
                               <!-- Avatar -->
                               <div class="comment-meta">
                                  <img src="catalog/view/theme/default/images/theme/blogs/avatar_silkhouse.gif" alt="Avatar Default" class="avatar-img">
                                  <p class="comment-author"><a href="http://creaticode.com/blog">Chili Super</a></p>
                                  <div class="comment-content">
                                     faaaaaaaaaaaaaaaaaaaaaa                  
                                  </div>
                               </div>
                               <!-- Contenedor del Comentario -->
                               <div class="comment-box">
                                  <div class="comment-actions">
                                     <a href="#" class="btnReply">Trả lời</a>
                                     <span class="separator">•</span>
                                     <a class="btnLike" href="#"><i class="fa fa-thumbs-o-up"></i> <strong>24</strong> Thích</a>
                                     <span class="separator">•</span>
                                     <a class="btnShare" href="#"><i class="fa fa-facebook-square"></i></a>
                                     <div class="time">1 giờ trước</div>
                                  </div>
                               </div>
                            </li>
                         </ul>
                      </li>
                      <li>
                         <div class="comment-main-level">
                            <!-- Avatar -->
                            <div class="comment-meta">
                               <img src="catalog/view/theme/default/images/theme/blogs/avatar_silkhouse.gif" alt="Avatar Default" class="avatar-img">
                               <p class="comment-author"><a href="http://creaticode.com/blog">TRAN ANH</a></p>
                               <div class="comment-content">
                                  Bình luận của Trần Anh ! Thôi nè, cần gì phải kiểm tra              
                               </div>
                            </div>
                            <!-- Contenedor del Comentario -->
                            <div class="comment-box">
                               <div class="comment-actions">
                                  <a href="#" class="btnReply">Trả lời</a>
                                  <span class="separator">•</span>
                                  <a class="btnLike" href="#"><i class="fa fa-thumbs-o-up"></i> <strong>24</strong> Thích</a>
                                  <span class="separator">•</span>
                                  <a class="btnShare" href="#"><i class="fa fa-facebook-square"></i></a>
                                  <div class="time">1 giờ trước</div>
                               </div>
                            </div>
                         </div>
                         <!-- Respuestas de los comentarios -->
                         <ul class="comments-list reply-list">
                            <li>
                               <!-- Avatar -->
                               <div class="comment-meta">
                                  <img src="catalog/view/theme/default/images/theme/blogs/avatar_silkhouse.gif" alt="Avatar Default" class="avatar-img">
                                  <p class="comment-author"><a href="http://creaticode.com/blog"></a></p>
                                  <div class="comment-content">
                                     hehelloo hello                  
                                  </div>
                               </div>
                               <!-- Contenedor del Comentario -->
                               <div class="comment-box">
                                  <div class="comment-actions">
                                     <a href="#" class="btnReply">Trả lời</a>
                                     <span class="separator">•</span>
                                     <a class="btnLike" href="#"><i class="fa fa-thumbs-o-up"></i> <strong>24</strong> Thích</a>
                                     <span class="separator">•</span>
                                     <a class="btnShare" href="#"><i class="fa fa-facebook-square"></i></a>
                                     <div class="time">1 giờ trước</div>
                                  </div>
                               </div>
                            </li>
                         </ul>
                      </li>
                   </ul>
                </div>
             </div>
             <div id="comment-form" class="comments-form-blogs">
                <fieldset>
                  <div class="form-group">
                    <div class="col-md-6">
                      <div class="required field-phone">
                          <input type="text" name="name" value="" id="input-name" class="form-control" placeholder="Tên/Doanh nghiệp*" />
                          
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="required field-email">
                        <input type="text" name="email" value="" id="input-email" class="form-control" placeholder="Địa chỉ email"/>
                      </div>
                    </div>
                  </div>
                  <div class="form-group required field-enquiry">
                    <div class="col-sm-12">
                      <textarea name="enquiry" rows="10" id="input-enquiry" class="form-control" placeholder="Nội dung bình luận*"></textarea>
                      
                    </div>
                  </div>
                </fieldset>
                <div class="buttons">
                  <p class="result-success"></p>
                  <div class="comment-submit">
                    <input class="btn btn-primary" type="submit" value="Gởi bình luận" id="submit-form"/>
                    <input type="reset" id="configreset" value="Reset" style="display: none">
                  </div>
                </div>
              </form>
            </div>

            <script type="text/javascript">
              jQuery(document).ready(function($) {
                var button_submit = "#submit-form";
                $(button_submit).on('click', function(e) {
                  e.preventDefault();
                  var actionUrl = $("#form-review").attr('action'); 
                  var formData = $("#form-review").serialize(); 
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
          </form>


          </div>
        </div>
      </div>
      <?php echo $content_bottom; ?></div>

    <?php echo $column_right; ?></div>
</div>
<?php echo $footer; ?>