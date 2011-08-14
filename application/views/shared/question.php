<div class="question">
	<p><?php echo $question->body ?></p>
	<div class="answers">
		<?php foreach($question->answers as $key => $answer): ?>
			
			<?php
				$id = "answers_{$question->id}_{$key}";				
				$name = "answers[{$question->id}]";
				$checked = (Arr::get($_POST,$name,null) === $answer) ? 'checked="checked"' : '';			
			?>
			<input type="radio" <?php echo $checked ?> id="<?php echo $id ?>" name="<?php echo $name ?>" />
			<label for="<?php echo $id ?>"><?php echo $answer; ?></label>
			
		<?php endforeach; ?>
	</div>
</div>
