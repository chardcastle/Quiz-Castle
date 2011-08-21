<?php echo View::factory('shared/header')->bind('cache',$cache) ?>
	<title><?php echo i18n::get('tab_title') ?></title>	
  </head>
  <body>
      <div id="fb-root"></div>
	<div id="global_outer">
	<h1>Tab</h1>
		<?php echo $body; ?>
	</div>
<?php echo View::factory('shared/footer')->bind('cache',$cache) ?>
