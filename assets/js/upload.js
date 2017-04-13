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
		var keywords = [
			'Beauty', 'Nature', 'Girls', 'Country', 'Ocean', 'School', 'Student', 'Work',
			'Office', 'Children'
		];
		tag_input.tag({
			placeholder:tag_input.attr('placeholder'),
			//enable typeahead by specifying the source array
			source: keywords,//defined in ace.js >> ace.enable_search_ahead
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

	//typeahead.js
	//example taken from plugin's page at: https://twitter.github.io/typeahead.js/examples/
	var substringMatcher = function() {
		var strs = [
			'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
			'Lorem Ipsum has been the industry',
			'Standard dummy text ever since the 1500s', 
			'when an unknown printer took a galley of type and scrambled',
			'It to make a type specimen book. ',
			'It has survived not only five centuries ',
			'But also the leap into electronic typesetting',
			'Remaining essentially unchanged. ',
			'It was popularised in the 1960s with the release of ',
			'Letraset sheets containing Lorem Ipsum passages, ',
			'And more recently with desktop publishing software like ',
			'Aldus PageMaker including versions of Lorem Ipsum'
		];
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

	// $('input.typeahead').typeahead(
	// 	{
	// 		hint: true,
	// 		highlight: true,
	// 		minLength: 1
	// 	}, {
	// 		name: 'states',
	// 		displayKey: 'value',
	// 		source: substringMatcher(),
	// 		limit: 10
	// 	}
	// ).parent('.twitter-typeahead').css('display', 'block');

	// tag input cho phần tìm kiếm
	// var tag_input = $('#search-tags');
	// try{
	// 	var keywords = [
	// 		'Beauty', 'Nature', 'Girls', 'Country', 'Ocean', 'School', 'Student', 'Work',
	// 		'Office', 'Children'
	// 	];
	// 	tag_input.tag({
	// 		placeholder:tag_input.attr('placeholder'),
	// 		//enable typeahead by specifying the source array
	// 		source: keywords,//defined in ace.js >> ace.enable_search_ahead
	//   	});

	// 	//programmatically add/remove a tag
	// 	var $tag_obj = $('#search-tags').data('tag');
	// 	$tag_obj.add('Beauty');
		
	// 	var index = $tag_obj.inValues('some tag');
	// 	$tag_obj.remove(index);
	// }
	// catch(e) {
	// 	//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
	// 	tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
	// 	autosize($('#search-tags'));
	// }

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
				      		$("#gallery-content .grid-view").append(`
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
				      		$("#gallery-content .list-view").append(`
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
					      	$("#gallery-content .table-view table tbody").append(`
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
	$('#toggle-layout-format').on('click', function(ev){
		var target = $('input', ev.target);
		var which = parseInt(target.val());
		var layout = '';
		switch(which){
			case 1:
				layout = 'grid-view';
				break;
			case 2:
				layout = 'list-view';
				break;
			case 3:
				layout = 'table-view';
				break;
		}
		$(".view-layout").addClass('hide');
		$("."+layout).toggleClass('hide');
	});

});