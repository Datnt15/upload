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
				    success: function (res) {
				    	res = JSON.parse(res);
				    	i = 0;
				    	var keywords = $("#form-field-tags").val().split(",");
				    	var keys = '';
				    	for (var j = 0; j < keywords.length; j++) {
				    		keys += `<span type="button" class="btn btn-white btn-yellow btn-sm">`+keywords[j]+`</span>`;
				    	}
				      	for ( ; i < res.data.length; i++ ) {
					      	file = res.data[i];
				      		$("#gallery-content #grid-view").append(`
				      			<div class="col-xs-6 col-sm-4 col-md-3">
                                    <div class="thumbnail search-thumbnail">
                                        <span class="search-promotion label label-success arrowed-in arrowed-in-right">Sponsored</span>

                                        <img class="media-object" alt="100%x200" style="height: 200px; width: 100%; display: block;" src="`+file.url+`" data-holder-rendered="true">
                                        <div class="caption">
                                            <h3 class="search-title">
                                                `+file.title+`
                                            </h3>
                                            <p>
                                                `+keys+`
                                            </p>
                                        </div>
                                    </div>
                                </div>
				      			`);
				      		$("#gallery-content #list-view").append(`
				      			<div class="col-xs-12">
					      			<div class="media search-media">
	                                    <div class="media-left">
	                                        <a href="#">
	                                            <img class="media-object" alt="72x72" style="width: 72px; height: 72px;" src="`+file.url+`" data-holder-rendered="true">
	                                        </a>
	                                    </div>

	                                    <div class="media-body">
	                                        <div>
	                                            <h4 class="media-heading">
	                                                `+file.title+`
	                                            </h4>
	                                        </div>
	                                        <p>
	                                            `+keys+`
	                                        </p>
	                                    </div>
	                                </div>
	                            </div>
	                            <div class="space"></div>
				      			`);
					      	$("#gallery-content #table-view table tbody").append(`
				      			<tr>
                                    <td>
                                        <img class="media-object" alt="72x72" style="width: 72px; height: 72px;" src="`+file.url+`" data-holder-rendered="true">  
                                    </td>
                                    <td>`+file.title+`</td>
                                    <td>`+keys+`</td>
                                    <td>
                                        <button class="btn btn-white btn-info btn-bold">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120 blue"></i>
                                            Sửa
                                        </button>
                                        <button class="btn btn-white btn-warning btn-bold">
                                            <i class="ace-icon fa fa-trash-o bigger-120 orange"></i>
                                            Xóa
                                        </button>
                                    </td>
                                </tr>
			      			`);
			      			$("#myTab a[href='#gallery-area']").click();
			      			this_form.reset(function(event) {
			      				
			      			});
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
	});

	$("#gallery-content").on('click', '.edit-img', function(event) {
		event.preventDefault();
		load_image_info($(this).attr('data-img-id'));
		$("#edit-modal").modal('show');
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
				console.log(data.keywords);
				$("#edit_image_title").val(data.title);
				$("#edit_image_url").attr('src',data.url);
			}
		);
	}

});