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
		multiple: true,
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
	
	// Tag input cho phần upload
	var tag_input = $('#form-field-tags');
	try{
		tag_input.tag({
			placeholder:tag_input.attr('placeholder'),
			//enable typeahead by specifying the source array
			// source: keywords,//defined in ace.js >> ace.enable_search_ahead
			
			//or fetch data from database, fetch those that match "query"
			source: function(query, process) {
			  	$.ajax({
		  			url: $('base').attr('href') +"upload/get_keywords/"+encodeURIComponent(query),
		  		})
			  	.done(function(result){
			  		result = JSON.parse(result);
			  		process(result);
			  	});
			}
			
	  	})
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
		autosize($('#form-field-tags'));
	}

	//typeahead.js
	//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
	var substringMatcher = function() {
		var strs = [];
		$.ajax({
  			url: $('base').attr('href') +"upload/get_titles/",
  		})
	  	.done(function(result){
	  		strs = JSON.parse(result);
	  	});
		return function findMatches(q, cb) {
			var matches, substringRegex;
		 
			// an array that will be populated with substring matches
			matches = [];
		 
			// regex used to determine if a string contains the substring `q`
			substrRegex = new RegExp(q, 'i');
		 
			// iterate through the pool of strings and for any string that
			// contains the substring `q`, add it to the `matches` array
			$.each(strs, function(i, str) {
				if (substrRegex.test(str)) {
					// the typeahead jQuery plugin expects suggestions to a
					// JavaScript object, refer to typeahead docs for more info
					matches.push({ value: str });
				}
			});

			cb(matches);
		}
	};

	$('input.typeahead').typeahead(
		{
			hint: true,
			highlight: true,
			minLength: 1
		}, {
			displayKey: 'value',
			source: substringMatcher(),
			limit: 10
		}
	).parent('.twitter-typeahead').css('display', 'block');

	// tag input cho phần tìm kiếm
	var tag_input = $('#search-tags');
	try{
		tag_input.tag({
			placeholder:tag_input.attr('placeholder'),
			source: function(query, process) {
			  	$.ajax({
		  			url: $('base').attr('href') +"upload/get_keywords/"+encodeURIComponent(query),
		  		})
			  	.done(function(result){
			  		result = JSON.parse(result);
			  		process(result);
			  	});
			}
	  	});
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
		autosize($('#search-tags'));
	}


	// tag input cho phần tìm kiếm
	var tag_input = $('#edit_image_keys');
	try{
		tag_input.tag({
			placeholder:tag_input.attr('placeholder'),
			source: function(query, process) {
			  	$.ajax({
		  			url: $('base').attr('href') +"upload/get_keywords/"+encodeURIComponent(query),
		  		})
			  	.done(function(result){
			  		result = JSON.parse(result);
			  		process(result);
			  	});
			}
	  	});
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
		autosize($('#edit_image_keys'));
	}

	// Submit form
	$("#upload-form").submit(function() {
		var this_form = $(this);
		var input = document.getElementById("id-input-file-3"), formdata = false;
    
		if (window.FormData) {
		    formdata = new FormData();
			var i = 0, len = input.files.length, file;
		    formdata.append("action", "upload-image");
		    formdata.append("keywords", $("#form-field-tags").val());
		    for ( ; i < len; i++ ) {
		      	file = input.files[i];
		      	if (!!file.type.match(/image.*/)) {
		      		if (formdata) {
					  	formdata.append("images[]", file);
					}
		      	} 
		    }
		    if (formdata) {
		  		$.ajax({
				    url: $('base').attr('href') +"upload/do_upload",
				    type: "POST",
				    data: formdata,
				    processData: false,
				    contentType: false,
				    success: function () {
				    	reload_images( get_current_page() );
				    	$("#myTab a[href='#gallery-area']").click();
			      		this_form.reset();
				    }
				});
				return false;
			}
		}
		return false;
	});


	$("#gallery-content").on('click', '.delete-img', function(event) {
		event.preventDefault();
		delete_image($(this).attr('data-img-id'));
		$(this).parents('.single-image').remove();
		reload_images( get_current_page() );
	});

	$("#gallery-content").on('click', '.edit-img', function(event) {
		event.preventDefault();
		load_image_info($(this).attr('data-img-id'));
		$("#edit-modal").modal('show');
	});


	$("#save_change_image").click(function(){
		$.post(
			$('base').attr('href') +"upload/update_image", 
			{
				action: 'update_image',
				image_id : $("#edit_image_id").val(),
				title : $("#edit_image_title").val(),
				keys : $("#edit_image_keys").val()
			}, function() {
				$("#edit-modal").modal('hide');
				reload_images( get_current_page() );
			}
		);
	});

	var delete_image = function(id){
		$.post(
			$('base').attr('href') +"upload/delete_image", 
			{
				action: 'delete_image',
				image_id : id
			}, function() {

			}
		);
	};


	var load_image_info = function(id){
		$.post(
			$('base').attr('href') +"upload/get_image", 
			{
				action: 'get_image',
				image_id : id
			}, function(data) {
				data = JSON.parse(data);
				$("#edit_image_title").val(data.title);
				$("#edit_image_url").attr('src',data.url);
				$("#edit_image_id").val(data.image_id);
				var $tag_obj = $('#edit_image_keys').data('tag');

				// Bỏ tất cả những từ khóa cũ
				var values = $tag_obj.values;
				
				for (var i = values.length - 1; i >= 0; i--) {
					var index = $tag_obj.inValues(values[i]);
					$tag_obj.remove(index);
				}

				// Thêm các từ khóa mới
				for (var i = 0; i < data.keywords.length; i++) {
					$tag_obj.add(data.keywords[i].keyword);
				}

			}
		);
	};

	var reload_images = function ($page = 1){
		$.post(
			$('base').attr('href') +"upload/reload_images", 
			{
				action: 'reload_images',
				url : window.location.href,
				page : $page
			}, function(data) {
				$("#gallery-content").html(data);
			}
		);
	};

	var get_current_page = function(){
		var pathname = window.location.pathname;
		pathname = pathname.split('/');
		pathname = pathname.filter(function(v){return v!==''});
		return pathname.length > 3 ? parseInt(pathname[3]) : 1;
	};
	// var maxHeight = 0;
	// $("#gallery-content #grid-view").find('.single-image .thumbnail.search-thumbnail').each(function() {
	// 	maxHeight = $(this).innerHeight() > maxHeight ? $(this).innerHeight() : maxHeight;
	// 	console.log(maxHeight);
	// });

	// $("#grid-view .single-image").height(maxHeight);
});