<?php echo View::factory('shared/header')->bind('cache',$cache) ?>
	<title><?php echo i18n::get('tab_title') ?></title>	
  </head>
  <body>
      <div id="fb-root"></div>
	<div id="global_outer">
		<h1><?php echo i18n::get('tab_intro'); ?></h1>
		<h2>This is for the lols</h2>
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
			
			<?php foreach($quiz->questions as $index => $question): ?>

				<?php 
				$index = (int)$index + 1;	
				echo View::factory('shared/question')
						->bind('question',$question)
						->bind('existing_answers',$existing_answers)
						->bind('index', $index)
						->bind('questions',$quiz->quiz_questions_count); ?>

			<?php endforeach; ?>	
			<button type="submit" name="complete" id="submit">Enter</button>	
		</form>
	</div>
<?php echo View::factory('shared/footer')->bind('cache',$cache) ?>
