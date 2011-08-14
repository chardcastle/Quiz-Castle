<div class="question">
	<p><?php echo $question->body ?></p>
	<div class="answers">
		<?php foreach($question->answers as $key => $answer): ?>
			
			<?php $id = "radio_{$question->id}_{$key}" ?>
			<input type="radio" id="<?php echo $id ?>" name="answer[<?php echo $question->id ?>]" />
			<label for="<?php echo $id ?>"><?php echo $answer; ?></label>
			
		<?php endforeach; ?>
	</div>
</div>
