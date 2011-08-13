	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/jquery-1.5.1.min.js?cache_breaker=<?php echo $cache ?>"></script>
  	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/jquery/jquery-ui-1.8.14.custom.min.js?cache_breaker=<?php echo $cache ?>"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/app.js?cache_breaker=<?php echo $cache ?>"></script>  
   	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/fonts/cufon-yui.js?cache_breaker=<?php echo $cache ?>"></script>
	<script type="text/javascript" src="<?php echo Kohana::config('app.app_url') ?>/js/fonts/meta.font.js?cache_breaker=<?php echo $cache ?>"></script>    
    <!-- font replacement -->
    <script type="text/javascript">		
		Cufon.replace('#header h1, #call_to_action', { fontFamily: 'Meta' });
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
