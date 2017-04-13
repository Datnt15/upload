jQuery(function($) {

	$('[data-rel=tooltip]').tooltip({container:'body'});
	$('[data-rel=popover]').popover({container:'body'});

	$('#id-input-file-3').ace_file_input({
		style: 'well',
		btn_choose: 'Drop images here or click to choose',
		btn_change: null,
		no_icon: 'ace-icon fa fa-picture-o',
		droppable: true,
		thumbnail: 'small',
		allowExt: ["jpeg", "jpg", "png", "gif" , "bmp"],
		allowMime: ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"],
		preview_error : function(filename, error_code) {
		}

	}).on('change', function(){
	}).off('file.error.ace')
	.on('file.error.ace', function(e, info) {
		console.log(info.file_count);//number of selected files
		console.log(info.invalid_count);//number of invalid files
		console.log(info.error_list.ext);//a list of errors in the following format
		
		if( !info.dropped ) {
			//perhapse reset file field if files have been selected, and there are invalid files among them
			//when files are dropped, only valid files will be added to our file array
			e.preventDefault();//it will rest input
		}
		

	});
	
	
	var tag_input = $('#form-field-tags');
	try{
		tag_input.tag({
			placeholder:tag_input.attr('placeholder'),
			//enable typeahead by specifying the source array
			source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
			/**
			//or fetch data from database, fetch those that match "query"
			source: function(query, process) {
			  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
			  .done(function(result_items){
				process(result_items);
			  });
			}
			*/
	  	})

		//programmatically add/remove a tag
		var $tag_obj = $('#form-field-tags').data('tag');
		$tag_obj.add('Nhập từ khóa vào đây');
		
		var index = $tag_obj.inValues('some tag');
		$tag_obj.remove(index);
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
		autosize($('#form-field-tags'));
	}

	try {
	  	Dropzone.autoDiscover = true;
	
	  	var myDropzone = new Dropzone('#dropzone', {
			    previewTemplate: $('#preview-template').html(),
			    
				thumbnailHeight: 120,
			    thumbnailWidth: 120,
			    maxFilesize: 0.5,
				
				// addRemoveLinks : true,
				// dictRemoveFile: 'Remove',
				
				dictDefaultMessage :
				'<span class="bigger-150 bolder">Drop files</span> to upload \
				<span class="smaller-80 grey">(or click)</span> <br /> \
				<i class="upload-icon ace-icon fa fa-cloud-upload blue fa-3x"></i>'
			,
			
		    thumbnail: function(file, dataUrl) {
		      	if (file.previewElement) {
			        $(file.previewElement).removeClass("dz-file-preview");
			        var images = $(file.previewElement).find("[data-dz-thumbnail]").each(function() {
						var thumbnailElement = this;
						thumbnailElement.alt = file.name;
						thumbnailElement.src = dataUrl;
					});
			        setTimeout(function() { $(file.previewElement).addClass("dz-image-preview"); }, 1);
		      	}
		    }
		});
	
	
	  //simulating upload progress
	  var minSteps = 6,
	      maxSteps = 60,
	      timeBetweenSteps = 100,
	      bytesPerStep = 100000;
	
	  myDropzone.uploadFiles = function(files) {
	    var self = this;
	
	    for (var i = 0; i < files.length; i++) {
	      var file = files[i];
	          totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
	
	      for (var step = 0; step < totalSteps; step++) {
	        var duration = timeBetweenSteps * (step + 1);
	        setTimeout(function(file, totalSteps, step) {
	          return function() {
	            file.upload = {
	              progress: 100 * (step + 1) / totalSteps,
	              total: file.size,
	              bytesSent: (step + 1) * file.size / totalSteps
	            };
	
	            self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
	            if (file.upload.progress == 100) {
	              file.status = Dropzone.SUCCESS;
	              self.emit("success", file, 'success', null);
	              self.emit("complete", file);
	              self.processQueue();
	            }
	          };
	        }(file, totalSteps, step), duration);
	      }
	    }
	   }
	
	   
	   //remove dropzone instance when leaving this page in ajax mode
	   $(document).one('ajaxloadstart.page', function(e) {
			try {
				myDropzone.destroy();
			} catch(e) {}
	   });
	
	} catch(e) {
	  alert('Dropzone.js does not support older browsers!');
	}
	
});