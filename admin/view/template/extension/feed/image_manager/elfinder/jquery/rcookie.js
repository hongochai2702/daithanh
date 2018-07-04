/*jslint browser: true */
/*global jQuery: true */
/**
 * jQuery Cookie plugin
 * Copyright (c) 2010 Klaus Hartl (stilbuero.de)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
 jQuery.rcookie=function(key,value,options){if(arguments.length>1&&String(value)!=="[object Object]"){options=jQuery.extend({},options);if(value===null||value===undefined){options.expires=-1}if(typeof options.expires==="number"){var days=options.expires,t=options.expires=new Date();t.setDate(t.getDate()+days)}value=String(value);return(document.cookie=[encodeURIComponent(key),"=",options.raw?value:encodeURIComponent(value),options.expires?"; expires="+options.expires.toUTCString():"",options.path?"; path="+options.path:"",options.domain?"; domain="+options.domain:"",options.secure?"; secure":""].join(""))}options=value||{};var result,decode=options.raw?function(s){return s}:decodeURIComponent;return(result=new RegExp("(?:^|; )"+encodeURIComponent(key)+"=([^;]*)").exec(document.cookie))?decode(result[1]):null};
function filemanager() {
	$('#modal-image').remove();
	$.ajax({
		url: 'index.php?routes=common/filemanager&bulk_insert=1&token=' + getURLVar('token'),
		dataType: 'html',
		beforeSend: function() {
			$('#button-image i').replaceWith('<i class="fa fa-circle-o-notch fa-spin"></i>');
			$('#button-image').prop('disabled', true);
		},
		complete: function() {
			$('#button-image i').replaceWith('<i class="fa fa-upload"></i>');
			$('#button-image').prop('disabled', false);
		},
		success: function(html) {
			$('body').append('<div id="modal-image" class="modal">' + html + '</div>');
			$('#modal-image').modal('show');
		}
	});	
};
function changePrimaryImage(id) {  	
	var image= $('#input-image'+id).val();
	$('#input-image').val(image);
	var thumb= $('#thumb-image'+id+' img').attr('src');
	$('#thumb-image img').attr('src',thumb);
	$('#thumb-image img').attr('width',100);
}
$(document).ready(function() {
	$('#images').sortable({
		items: 'tr.image-row', 
	   forcePlaceholderSize:true,     
	   cursor: "move", 
	   helper: function(event) {
		return $('<div class="drag-row" style="border:1px dashed #ccc;padding:5px;"><table></table></div>').find('table').append($(event.target).closest('tr').clone()).end(); 
		},
	   forceHelperSize: true,
	   forcePlaceholderSize: true,
	   scroll: true,
	   scrollSensitivity: 30,
	   scrollSpeed: 30
   });
})	;	