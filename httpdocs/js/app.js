$(function(){
	/*
	* Movie title answer
	*/
	var quiz = {

		movie_title_options: null,
	
		answer_question: function(data)
		{
			console.log(data);
			$.post(ENV.app_url+"/tab/answer", data, function(json){
				// create a deferred object
				var dfd = $.Deferred();
				var action = {
					add_response: function(json){
						console.log('added message');
						$("#question_response")
						.html(json.message)
					},
					disable_input: function(json){
						console.log('disabling input');
						$("#question_"+data.position+" .answers")
						.button({disabled: true})
					},
					refresh_cufon: function(){
						console.log('refreshed cufon');
						Cufon.refresh();
					},
					refresh_question: function(){						
						// Increase compatibility with unnamed functions
				
						if ($("#question_"+(parseInt(data.position) + 1)).length)
						{
							window.setTimeout(function() {
								console.log('running next');
								   $("#questions")
									.find("#question_"+(parseInt(data.position)))
										.hide("slow")
									.end()			
									.find("#question_response")
										.empty()
									.end()
									.find("#question_"+(parseInt(data.position) + 1))	
										.show("fast")
									.end();
							}, 2000);
						} else {
							console.log('end of quiz');
							$('#submit').button({ disabled: false });
						}
					}
				}
				dfd.done(action.add_response, action.disable_input, action.refresh_cufon, action.refresh_question).resolve(json);
			},'json');
		}
	}

	if ($('.movie_answer').length)
	{
		$.ajax({
			url: $('.movie_answer:first').attr('action'),
			dataType: "xml",
			success: function( xmlResponse ) {
				quiz.movie_title_options = $( "title", xmlResponse ).map(function() {
					return {
						value: $(this).text(),
						id: $(this).text()
					};
				}).get();
				$( ".movie_names" )
					.each(function(i, item){
						$(item)
						.autocomplete({
							source: quiz.movie_title_options,
							minLength: 0,
							select: function( event, ui ) {
								var item = $(this).parent().parent().find('.answers');
								console.log($.data(item,'meta').position);
//								console.log($(this).data('position'));
//								//ui.item.value
//								var data = {
//									question_id: $(this).attr('data-value'),
//									position: jQuery.data($(item),'meta').position,
//									answer: $(this).val()
//								};
//								quiz.answer_question(data);
							}
						})
					})
			}
		});
	}

	/*
	* End Movie title answer
	* Add events
	*/			
	$('body')
	.find(".answers")
		.buttonset()
	.end()
	.find("#submit")
		.button({ disabled: true })
	.end()
	.find('.question')
		.hide(0)
	.end()
	.find('.answers')
		.each(function(i, item){
			var current_position = parseInt(i) + 1;
			$(item)
			.find('input')
			.data('meta',{position : current_position})
//				.each(function(i, sub_item){
//					console.log($(sub_item).attr('name'));
//					$.data(sub_item,'meta',{position : current_position});
//				})
			.end();
		})					
	.end()
	.find('.answers')
		.each(function(i, item){			
			$(item)
			.find('input')
				.each(function(i, sub_item){
					$(item)
					.change(function(){
						console.log($.data(sub_item,'meta').position);
						var data = {
							question_id: $(this).attr('data-value'),
							position: $.data(sub_item,'meta').position,
							answer: $(this).val()
						};
						quiz.answer_question(data);
					})
				})			
			.end();
		})					
	.end()
	.find("#questions")
		.append('<div id="question_response"></div>')
	.end()
	.find('.question:first')
		.show(0)
	.end()
	.find('input[type=radio]')
		.each(function(i, item){
//			console.log($.data($(item),'meta').position);
//			$(item)
//			.change(function(){
//				var item = $(item);
//				console.log($.data(item,'meta').position);
	//			var data = {
	//				question_id: $(this).attr('data-value'),
	//				position: jQuery.data($(this),'meta').position,
	//				answer: $(this).val()
	//			};
	//			quiz.answer_question(data);
//			})
		})

	.end()	
});
