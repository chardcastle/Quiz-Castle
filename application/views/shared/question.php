<div class="question" id="question_<?php echo $index ?>">
	<h4>Question <?php echo $index ?>) of <?php echo $questions ?></h4>
	<p><?php echo $question->body ?></p>
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
</div>
