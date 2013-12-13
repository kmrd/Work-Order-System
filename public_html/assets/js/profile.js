// hide the upload box until we want it
// have the uploader dialog behaviour
$(function(){
	$('#uploader').hide();
	$('#uploader_btn').addClass('button small');
	$('#uploader_btn').css({ display : 'inline-block' });//,
//							 cursor : 'pointer' });
	$('#uploader_btn').click(function(e){
		$( "#uploader" ).dialog({
			width: 600
		});
	});
});

// Convert divs to queue widgets when the DOM is ready
$(function() {
	// Setup html5 version
	$("#uploader").pluploadQueue({
		// General settings
		runtimes : 'html5,flash,silverlight,html4',
		url : '/member/uploadavatar',
		chunk_size: '1mb',
		rename : true,
		dragdrop: true,
		
		filters : {
			// Maximum file size
			max_file_size : '10mb',
			// Specify what files to browse for
			mime_types: [
				{title : "Image files", extensions : "jpg,gif,png"}//,
				//{title : "Zip files", extensions : "zip"}
			]
		},

		// Resize images on clientside if we can
		resize : {width : 1200, height : 1200, quality : 90},

		flash_swf_url : 'plupload/Moxie.swf',
		silverlight_xap_url : 'plupload/Moxie.xap',

		init : {
			FileUploaded : function(up, file, info) {
                // Called when a file has finished uploading
                //log('[FileUploaded] File:', file, "Info:", info);
                $.ajax('', {
                	cache : false,
                	success : function(response, status) {
                		var avatar = $(response).find('#avatar');
                		$('#avatar').attr('src' , $(avatar).attr('src'));
                	}
                });

				$('#uploader').dialog('close');
            }
        }
	});

});


/*
$(document).ready(initUploader);

function initUploader() {
	var thumbuploader = new plupload.Uploader({
		runtimes : 'gears,html5,flash,silverlight,browserplus',
		browse_button : 'thumbpickfiles',
		container : 'thumbcontainer',
		max_file_size : '10mb',
		url : '/upload/uploadimage/',
		flash_swf_url : '/assets/js/plupload.flash.swf',
		silverlight_xap_url : '/assets/js/plupload.silverlight.xap',
		filters : [
			{ title : "Image files", extensions : "jpg,gif,png" }
		],
		resize : {width : 800, height : 800, quality : 90},
		init: {
			Init: function(up) {
				//alert('ok');
				//$('#filelist').html('');
				//$(up).find('#filelist').html('');
			},
			PostInit : function(up){
				//$('#filelist').html('');
				//alert('ok');
				// $('#avatarupload').accordion('resize');
			},
			FilesAdded : function(up, files){
				// ensure only one image file will be uploaded
				while(up.files.length > 1) {
					up.removeFile(up.files[0]);
				}

				$.each(files, function(i, file) {
					$('#thumbfilelist').append(
						'<div id="' + file.id + '">' +
						file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
					'</div>');
				});

				up.refresh();

				// automatically upload the file
				up.start();
			},
			FilesRemoved : function(up, files) {
			},
			FileUploaded : function(up, file, info) {
				$('[name=thumbnail]').val(file.name);
				//$('#' + file.id + " b").html("100%");
				$('#' + file.id + " b").html("Saved");

				$('#' + up.settings.container).parent().find('.imagecontainer img').attr('src', '/imgs.uploads/' + file.name);
			},
			UploadProgress : function(up, file) {
				$('#' + file.id + " b").html(file.percent + "%");
			},
			Error : function(up, err) {
				$('#thumbfilelist').append("<div>Error: " + err.code +
					", Message: " + err.message +
					(err.file ? ", File: " + err.file.name : "") +
					"</div>"
				);

				up.refresh(); // Reposition Flash/Silverlight
			}
		}
	});

	thumbuploader.init();

	$('#thumbuploadfiles').click(function(e) {
		thumbuploader.start();
		e.preventDefault();
	});

	$('#thumbfilelist').html('');

	$('#thumbremove').click(function(e){
		e.preventDefault();

		$('[name=thumbnail]').val('');
		$(this).parents('.imagesection').find('.imagecontainer').html('<div class="imgplaceholder"></div>');
	});
}
*/