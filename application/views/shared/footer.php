	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/jquery-1.6.2.min.js?cache_breaker=<?php echo $cache ?>"></script>
  	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/jquery-ui-1.8.15.custom.min.js?cache_breaker=<?php echo $cache ?>"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/app.js?cache_breaker=<?php echo $cache ?>"></script>  
   	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/fonts/cufon-yui.js?cache_breaker=<?php echo $cache ?>"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/fonts/Play_400-Play_700.font.js?cache_breaker=<?php echo $cache ?>"></script>    
	
	<?php if ( ! empty($extra_scripts)): ?>
		<?php foreach ($extra_scripts as $file): ?>
		<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/<?php echo $file ?>.js?cache_breaker=<?php echo $cache ?>"></script>
		<?php endforeach; ?>
	<?php endif; ?>

	<!-- font replacement -->
	<script type="text/javascript">		
		function replace_fonts()
		{
			Cufon.replace('h1, h2, h3, h4, h5, h6, strong, #question_response, .bold', { fontFamily: 'Play' });
			Cufon.replace('.font_icon', { fontFamily: 'Guifx v2 Transports' });
		}
		replace_fonts();
	</script>
    <!-- application vars -->
    <script type="text/javascript">				
	    var ENV = ENV || {
			app_url: '<?php echo Kohana::config('app.id_key') ?>',
			home_url: '<?php echo Kohana::config('app.home_url')  ?>',
			entry_url: '<?php echo Kohana::config('app.app_url') ?>/tab/enter',
			attachment: {
				name: '',
				caption: '',
				description: '',	
			},
			cache_breaker: '<?php echo $cache ?>'
		}		
    </script>
	<!-- Facebook Javascript SDK integration -->
	<?php if(Request::current()->controller() != 'website'): ?>
		<script src="http://connect.facebook.net/en_US/all.js"></script>
		<script>		
			FB.init({
				appId  : '<?php echo Kohana::config('app.id_key') ?>',
				status : false, // check login status
				cookie : true, // enable cookies to allow the server to access the session
				xfbml  : false  // parse XFBML
			});
			window.fbAsyncInit = function() {
				FB.Canvas.setSize();
			}	
		</script>
		<!-- End Facebook SDK -->
	<?php endif; ?>
	</body>
</html>
