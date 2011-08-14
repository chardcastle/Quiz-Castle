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
	.find('.question:first')
		.show(0)
	.end()
	.find('input[type=radio]')
		.live('change', function(){
			console.log('lol'+$(this).val());
			var data = {
				answer: $(this).val(),
				question_id: $(this).attr('name').substr(-2,1)
			};
			$.post(ENV.app_url+"/tab/answer", data, function(json){
				console.log(json.message);
			},'json');
		})
	.end()
});
