<?php echo View::factory('shared/header')->bind('cache',$cache) ?>
	<title><?php echo i18n::get('tab_title') ?></title>	
  </head>
  <body>
      <div id="fb-root"></div>
	<div id="global_outer">
		<h1><?php echo i18n::get('tab_intro'); ?></h1>
		<h2>This is for the lols</h2>
		<form action="<?php echo Kohana::config('app.app_url') ?>/tab/enter" id="quiz">
			<?php foreach($quiz->questions as $question): ?>

				<?php echo View::factory('shared/question')->bind('question',$question); ?>

			<?php endforeach; ?>		
		</form>
	</div>
<?php echo View::factory('shared/footer')->bind('cache',$cache) ?>
