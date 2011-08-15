
$(function(){
	$('body')
		.find(".answers")
		.buttonset()
	.end()
	.find("#submit")
		.button()
	.end()
	.find('.question')
		.hide(0)		
	.end()
	.find("#quiz")
		.append('<div id="question_response"></div>')
	.end()
	.find('.question:first')
		.show(0)
	.end()
	.find('input[type=radio]')
		.live('change', function(){			
			var data = {
				answer: $(this).val(),
				question_id: $(this).attr('name').substr(-2,1)
			};
			$.post(ENV.app_url+"/tab/answer", data, function(json){
				$("#question_response")
				.hide(0)
				.html(json.message)
				.fadeTo(0,0, function(){
					 Cufon.refresh();
				})
				.delay(500)
				.show("fast")
			},'json');
		})
	.end()	
});
