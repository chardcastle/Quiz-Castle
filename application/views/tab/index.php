		<span>
			<h1 class="title"><?php echo i18n::get('tab_intro'); ?></h1>
		</span>
		<span class="title inverted"><?php echo i18n::get('tab_blurb') ?></span>
		<?php if ($errors): ?>
			<p class="message">Some errors were encountered, please check the details you entered.</p>
			<ul class="errors">
			<?php foreach ($errors as $message): ?>
			    <li><?php echo $message ?></li>
			<?php endforeach ?>
		<?php endif ?>
		<form action="<?php echo Kohana::config('app.app_url') ?>/tab/enter" method="post" id="quiz">
			<input type="hidden" name="question_sequence" value="<?php echo implode(',',$quiz->question_ids) ?>" />
			<input type="hidden" name="quiz_token" value="<?php echo $quiz->entry_token ?>" />
			<div id="questions">
				<?php foreach($quiz->questions as $index => $question): ?>

					<?php 
					$index = (int)$index + 1;	
					echo View::factory('shared/question')
							->bind('question',$question)
							->bind('existing_answers',$existing_answers)
							->bind('index', $index)
							->bind('questions',$quiz->quiz_questions_count); ?>

				<?php endforeach; ?>
			</div>	
			<button type="submit" name="complete" id="submit">Enter</button>	
		</form>
