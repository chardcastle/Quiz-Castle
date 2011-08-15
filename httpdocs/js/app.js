
$(function(){
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
	.find("#questions")
		.append('<div id="question_response"></div>')
	.end()
	.find('.question:first')
		.show(0)
	.end()
	.find('input[type=radio]')
		.change(function(){
			var position = $(this).attr('data-value');			
			var data = {
				answer: $(this).val(),
				question_id: $(this).attr('name').substr(-2,1)
			};
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
						$("#question_"+position+" .answers")
						.button({disabled: true})
					},
					refresh_cufon: function(){
						console.log('refreshed cufon');
						Cufon.refresh();
					},
					refresh_question: function(){						
						// Increase compatibility with unnamed functions
						if ($("#question_"+(parseInt(position) + 1)).length)
						{
							window.setTimeout(function() {
								console.log('running next');
								   $("#questions")
									.find("#question_"+(parseInt(position)))
										.hide("slow")
									.end()			
									.find("#question_response")
										.empty()
									.end()
									.find("#question_"+(parseInt(position) + 1))	
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
		})
	.end()	
});
