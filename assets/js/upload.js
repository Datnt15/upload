jQuery(function($) {

	$('[data-rel=tooltip]').tooltip({container:'body'});
	$('[data-rel=popover]').popover({container:'body'});
	var drop_files = [];
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
		var files_input = $('#id-input-file-3');
		if(files_input.data('ace_input_method') == 'drop'){
			for (var i = 0; i < files_input.data('ace_input_files').length; i++) {
				drop_files.push(files_input.data('ace_input_files')[i]);
			}
		}
	});
	
	// Tag input cho phần upload
	var form_field_tags = $('#form-field-tags');
	try{
		form_field_tags.tag({
			placeholder:form_field_tags.attr('placeholder'),
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
		form_field_tags.after('<textarea id="'+form_field_tags.attr('id')+'" name="'+form_field_tags.attr('name')+'" rows="3">'+form_field_tags.val()+'</textarea>').remove();
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
	var search_tags = $('#search-tags');
	try{
		search_tags.tag({
			placeholder:search_tags.attr('placeholder'),
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
	  	var $tag_obj = $('#search-tags').data('tag');
	  	var inter_keys =  $('#search-tags').val();
	  	inter_keys = inter_keys.split(",");
	  	for (var i = 0; i < inter_keys.length; i++) {
	  		var key = inter_keys[i].replace(/ /g,'');
			if (key != '' && key != ' ') {
				$tag_obj.add(key);
			}
	  	}
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		search_tags.after('<textarea id="'+search_tags.attr('id')+'" name="'+search_tags.attr('name')+'" rows="3">'+search_tags.val()+'</textarea>').remove();
		// autosize($('#search-tags'));
	}


	// tag input cho phần tìm kiếm
	var edit_image_keys = $('#edit_image_keys');
	try{
		edit_image_keys.tag({
			placeholder:edit_image_keys.attr('placeholder'),
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
		edit_image_keys.after('<textarea id="'+edit_image_keys.attr('id')+'" name="'+edit_image_keys.attr('name')+'" rows="3">'+edit_image_keys.val()+'</textarea>').remove();
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
		    for (i = 0; i < drop_files.length; i++) {
		    	formdata.append("images[]", drop_files[i]);
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
			      		$("#id-input-file-3").ace_file_input('reset_input');
			      		var $tag_obj = $('#form-field-tags').data('tag');

						// Bỏ tất cả những từ khóa cũ
						var values = $tag_obj.values;
						
						for (var i = values.length - 1; i >= 0; i--) {
							var index = $tag_obj.inValues(values[i]);
							$tag_obj.remove(index);
							drop_files = [];
						}
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


	$("#header-search-title").keyup(function(e) {
		if(e.keyCode == 13){
			search_by_title( $(this).val(), $("#search-tags").val() );
	    }
	});


	$("#header-search-title").change(function() {
		search_by_title( $(this).val(), $("#search-tags").val() );
	});

	$("#header-search-title").on('typeahead:selected', function(evt, item) {
		search_by_title( $(this).val(), $("#search-tags").val() );
	});

	$("#search-tags").on('added',function() {
		search_by_title( $("#header-search-title").val(), $(this).val() );
	});


	$("#search-tags").on('removed',function() {
		search_by_title( $("#header-search-title").val(), $(this).val() );
	});

	$("#gallery-area").on('click', 'span.btn.btn-white.btn-yellow.btn-sm', function(event) {
		$("#search-tags").data('tag').add( $(this).text() );
		var keys_now = $("#search-tags").val();
		if (keys_now == '') {
			$("#search-tags").val($(this).text());
		}else{
			$("#search-tags").val( keys_now + "," + $(this).text() );
		}
		search_by_title( $("#header-search-title").val(), $("#search-tags").val() );
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
				page : $page,
				layout: get_current_layout()
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

	var get_current_layout = function(){
		return $(".search-area ul#toggle-layout-format li.active a").attr('href');
	};

	var search_by_title = function($title, $keys){
		$.post(
			$('base').attr('href') +"upload/search_by_title", 
			{
				action: 'search_by_title',
				title : $title,
				keys : $keys,
				layout: get_current_layout()
			}, function(data) {
				$("#gallery-content").html(data);
			}
		);
	}

});