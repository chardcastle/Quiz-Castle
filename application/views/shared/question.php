<div class="question" id="question_<?php echo $index ?>">
	<h4>Question <?php echo $index ?>) of <?php echo $questions ?></h4>
	<p><?php echo $question->body ?></p>

	<?php if ($question->type == 'movie'): ?>

		<img src="<?php echo $question->image_url ?>" alt="Question image" />	
		<form method="post" action="<?php echo Kohana::config('app.app_url') ?>/images/movie_questions/answers.xml" class="movie_answer">

			<div class="ui-widget">
				<label for="movie_names">Type your answer here: </label>
				<input class="movie_names" name="movie_title_choice"/>
			</div>

			<div class="ui-widget" style="margin-top:2em; font-family:Arial">
				Options:
				<div id="log" style="height: 200px; width: 300px; overflow: auto;" class="ui-widget-content"></div>
			</div>

		</form>	

	<?php elseif ($question->type == 'multi_choice'): ?>

		<div class="answers">
			<?php foreach($question->answers as $key => $answer): ?>
				<?php
					$id = "answers_{$question->id}_{$key}";				
					$name = "answers[{$question->id}]";
					$checked = (Arr::get($existing_answers,$question->id,'') == $answer) ? 'checked="checked"' : '';	
				?>
				<input type="radio" <?php echo $checked ?> id="<?php echo $id ?>" data-value="<?php echo $index ?>" name="<?php echo $name ?>" value="<?php echo $answer ?>"/>
				<label for="<?php echo $id ?>"><?php echo $answer; ?></label>
			
			<?php endforeach; ?>
		</div>

	<?php endif; ?>	

</div>
