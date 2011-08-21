<?php echo View::factory('shared/header')->bind('cache',$cache) ?>
	<title><?php echo i18n::get('tab_title') ?></title>	
  </head>
  <body>
      <div id="fb-root"></div>
	<div id="global_outer">
		<h1><?php echo i18n::get('tab_intro'); ?></h1>
		<p><?php echo i18n::get('thanks_for_playing'); ?></p>
		
	</div>
<?php echo View::factory('shared/footer')->bind('cache',$cache) ?>
