$(function(){
	/*
	* Movie title answer
	*/
	var quiz = {

		movie_title_options: null,
	
		answer_question: function(data)
		{

			var meta = data.meta.split(',');
			var answer_data = {
				question_id: meta[0],
				position: meta[1],
				answer: data.answer,
				current_question: "#question_" + (parseInt(meta[1])),
				next_question: "#question_" + (parseInt(meta[1]) + 1)
			}
			console.log(answer_data);
			$.post(ENV.app_url+"/tab/answer", answer_data, function(json){
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
						$(answer_data.current_question + " .answers")
						.button({disabled: true})
					},
					refresh_cufon: function(){
						console.log('refreshed cufon');
						Cufon.refresh();
					},
					refresh_question: function(){						
						// Increase compatibility with unnamed functions						
						if ($(answer_data.next_question).length)
						{
							console.log(answer_data.current_question);
							window.setTimeout(function() {
								console.log('running next');
								   $("#questions")
									.find(answer_data.current_question)
										.hide("slow")
									.end()			
									.find("#question_response")
										.empty()
									.end()
									.find(answer_data.next_question)
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
						var meta_data = $(item).attr("data-value");
						$(item)
						.autocomplete({
							source: quiz.movie_title_options,
							minLength: 0,
							select: function( event, ui ) {
								// Make new data and answer answer
								var data = {
									meta: meta_data,
									answer: ui.item.value
								};
								quiz.answer_question(data);
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
	.find('.question')
		.each(function(i, item){			
			$(item)
			.find('input[type=radio]')
				.each(function(i, item){
					$(item)
					.change(function(){
						var data = {
							meta: $(item).attr("data-value"),
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
});
