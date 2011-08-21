<?php echo View::factory('shared/header')->bind('cache',$cache) ?>
	<title><?php echo i18n::get('tab_title') ?></title>	
  </head>
  <body>     
	<div id="global_outer">
		<h1>Website</h1>
		<?php echo $body; ?>
	</div>
<?php echo View::factory('shared/footer')->bind('cache',$cache) ?>
