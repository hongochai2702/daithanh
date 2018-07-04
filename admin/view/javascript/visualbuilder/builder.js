$(document).ready(function() {

$('.edit-container').each(function(){
	$(this).find('.module').sort(sort_li).appendTo($(this));
	
});

function sort_li(a, b){
    return ($(b).data('sort')) < ($(a).data('sort')) ? 1 : -1;    
}

$("[data-toggle='popover']").popover(); 

$(".add-module").click(function(e) {
	e.preventDefault();	
});

$('body').on('click', function (e) {
    $('[data-toggle="popover"]').each(function () {
        if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover').has(e.target).length === 0) {
            $(this).popover('hide');
        }
    });
});

    $(".builder-grid, .panel").on("click", '.edit', function(e) {
        e.preventDefault();
   
          var target = $(this).attr("href");

        $('#moduleModal').on('hide.bs.modal', function() {
            $('#modalFrame').attr("src", "");
        });

        $('#moduleModal').on('show.bs.modal', function() {
        	 $("#loader").show();
            var elem = $('#modalFrame').addClass('hidden');

            elem.attr("src", target);
            elem.load(function() {
                elem.contents().find("#header").remove();
                elem.contents().find("#footer").remove();
                elem.contents().find(".breadcrumb").remove();
                elem.contents().find("#column-left").remove();
                elem.contents().find("#content").css({"background":"none","padding-top":"40px"});
                elem.find('.page-header').find('button').on('click', function(){
                		alert('foo');
                });

                if (GetURLParameter(this.contentWindow.location, 'route') == "extension/module") {
                    $('#moduleModal').modal('hide');
                    $('#module-ajax-success').removeClass('hidden');

                }
                $("#loader").hide();
            });
			
			
           elem.removeClass('hidden');
        });

        $('#moduleModal').modal('show');
    });




    initSort();
    confirm();

    $('body').on('hidden.bs.modal', '.modal', function() {
    	$(this).removeData('bs.modal');
     });


    $(document).on('submit', '#excluded-form', function(e) {
        $.ajax({
            beforeSend: function(request) {},
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                $("#settingsModal").modal('hide');
                data = $.parseJSON(data);

                $.each(data, function(i, item) {
                    $.each(item, function(key, val) {
                        $(".list-group-item." + val).remove();
                    });
                });

                $('#module-ajax-success').removeClass('hidden');
                  }
        });
        return false;
    });



    $('.page-header').on('click', 'button[type="submit"]', function() {
        $('#confirmleave').val('0');
        confirm();
    });
    $('.btn-save').on('click', function() {
        $('input[name="redirect"]').val('save');
        $('#form').submit();
    });


    $('#settingsModal').find("button[type='reset']").on('click', function() {
        $("#settingsModal").modal('hide');
    });

	var positions = [];
	$('.edit-container').each(function() {
		
		 positions.push({
            code: $(this).data('position'), 
            title: $(this).data('text')
        });
		

	});
	$('#module-list').find('.module-wrapper').find('.add-module').each(function() {
		var output = [];
		$.each(positions, function (index, value) {
			output.push('<option value="', value.code, '">', value.title, '</option>'); 
		});
		$(this).attr('data-content','<select class="form-control input-sm" data-module="'+$(this).data('code')+'">'+output.join('')+'</select><button class="margin-xs-top btn btn-primary btn-block btn-sm"><i class="fa fa-plus-circle"></i> Thêm </button>');

	});
    function initSort() {
        $('.builder-grid').find('.edit-container').sortable({
            connectWith: '.builder-grid .edit-container',
            forceHelperSize: true,
            forcePlaceholderSize: true,
            placeholder: 'placeholder',
            opacity: 0.5,
            cursorAt: {
                top: 20,
                left: 20
            },
            tolerance: "pointer",
            handle: ".edit-module",
            activate: function(event, ui) {

            },
            start: function(e, ui) {
               $(ui.item).width(300);
            },
            stop: function(e, ui) {

                $("#confirmleave").val("1");
                $(this).find('.module').each(function(event) {

                    $(event).data("position", $(event).parent().data('position'));
                    var sort = event;

                    $(this).find('input').each(function() {
                        var str = $(this).attr("name");
                        var pos = str.lastIndexOf("[") + 1;
                        var name = str.slice(pos, -1);
                        if (name === "position") $(this).val($(this).closest('.ui-sortable').data('position'));
                        if (name === "sort_order") $(this).val(sort);
                    });
                });
                resizeRightColumn();
            },
            receive: function(e, ui) {
                $(this).find('.module').each(function(event) {
                    $(event).data("position", $(event).parent().data('position'));
                    var sort = event;

                    $(this).find('input').each(function() {
                        var str = $(this).attr("name");
                        var pos = str.lastIndexOf("[") + 1;
                        var name = str.slice(pos, -1);
                        if (name === "position") $(this).val($(this).closest('.ui-sortable').data('position'));
                        if (name === "sort_order") $(this).val(sort);
                    });
                });
            },
            over: function(event, ui) {
                $(".placeholder").parent().addClass('placeholderHover');
                resizeRightColumn();
            },
            out: function(event, ui) {
                $(".placeholder").parent().removeClass('placeholderHover');
            },
        });


    };

    function confirm() {
        window.onbeforeunload = function(e) {
            if ($("#confirmleave").val() == "1") {
                var message = window.event;
                if (e) {
                    e.returnValue = message;
                }
                return message;
            }
        };
    }


    $('#switch-me').switchy();

    $('.builder-mode').on('click', function() {

        $('#switch-me').val($(this).attr('buildermode')).change();

        return false;
    });

    $('#switch-me').on('change', function() {

        // Toggle between Build and View mode
        var bgColor = '#5bc0de';

        if ($(this).val() == 'builder') {

            bgColor = '#7fcbea';

            $("#preview").addClass('hidden');
            $("#builder").removeClass('hidden');

        } else if ($(this).val() == 'preview') {

            bgColor = '#5bc0de';

            $("#preview").removeClass('hidden');
            $("#builder").addClass('hidden');

            $('#idIframe').attr('src', $('#changeLayout option:selected').data('route'));

            iframeLoaded();
        }

        $('.switchy-bar').animate({
            backgroundColor: bgColor
        });

        return false;
    });
});

function iframeLoaded(id) {
    var iFrameID = document.getElementById(id);
    if (iFrameID) {
        iFrameID.height = "";
        iFrameID.height = iFrameID.contentWindow.document.body.scrollHeight + "px";
    }
}

function GetURLParameter(url, sParam) {
    var sPageURL = url.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}