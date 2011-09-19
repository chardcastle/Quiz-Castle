<?php $name = "answers[{$question->id}]"; ?>
<div class="question" id="question_<?php echo $index ?>">
	<h4>Question <?php echo $index ?>) of <?php echo $questions ?></h4>
	<p><?php echo $question->body ?></p>

	<?php if ($question->type == 'movie'): ?>

		<img src="<?php echo $question->image_url ?>" alt="Question image" />	
		<form method="post" action="<?php echo Kohana::config('app.app_url') ?>/images/movie_questions/answers.xml" class="answers movie_answer">

			<div class="ui-widget">
				<label for="movie_names">Type your answer here: </label>
				<input type="text" class="movie_names" name="<?php echo $name ?>" data-value="<?php echo $question->id ?>" />
			</div>

		</form>	

	<?php elseif ($question->type == 'multi_choice'): ?>

		<div class="answers">
			<?php foreach($question->answers as $key => $answer): ?>
				<?php
					$id = "answers_{$question->id}_{$key}";					
					$checked = (Arr::get($existing_answers,$question->id,'') == $answer) ? 'checked="checked"' : '';	
				?>
				<input type="radio" <?php echo $checked ?> id="<?php echo $id ?>" data-value="<?php echo $question->id ?>" name="<?php echo $name ?>" value="<?php echo $answer ?>"/>
				<label for="<?php echo $id ?>"><?php echo $answer; ?></label>
			
			<?php endforeach; ?>
		</div>

	<?php endif; ?>	

</div>
