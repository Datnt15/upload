jQuery(document).ready(function($) {
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

	$('input.typeahead').typeahead({
		hint: true,
		highlight: true,
		minLength: 1
	}, {
		name: 'states',
		displayKey: 'value',
		source: substringMatcher(),
		limit: 10
	}).parent('.twitter-typeahead').css('display', 'block');

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
	  	});

		//programmatically add/remove a tag
		var $tag_obj = $('#form-field-tags').data('tag');
		$tag_obj.add('Beauty');
		
		var index = $tag_obj.inValues('some tag');
		$tag_obj.remove(index);
	}
	catch(e) {
		//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
		tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
		autosize($('#form-field-tags'));
	}
});