<div>
	<?php echo $question['question']; ?><br/>
	<ul>
		<?php foreach($question['answers'] as $answer): ?>
			<li><?php echo $answer; ?></li>
		<?php endforeach; ?>
	</ul>
</div>
