<?php echo $cache;
	foreach($quiz->questions as $question):
		echo View::factory('shared/question')->bind('question',$question);
	endforeach;
?>
