<?php 
/**
* Utitlity class for the application
*/

class App
{
	public $cache_breaker;

	public function __construct()
	{
		$this->cache_breaker = $this->get_cache_string();
	}
	/**
	* Accept a facebook object to load user
	* @return void Sets user data
	*/	
	public function get_facebook_user(Facebook $facebook)
	{	
	
		// Try to get user		
		$fb_user = $facebook->getUser();
		// Defaults
		$user_id = null;
		$name = null;
		$profile = null;
		$login_url = null;
		$logout_url = null;
		
		if ($fb_user)
		{
		  try {
			// Proceed knowing you have a logged in user who's authenticated.
			 $profile = $facebook->api('/me');
			 $user_id = $meta->id;
			 $name = $meta->name;
			 
		  } catch (FacebookApiException $e) {				
			return array('exception'=>$e->__toString());
		  }
		}
		
		// Login or logout url will be needed depending on current user state.
		if ($fb_user)
		{
		  $logout_url = $facebook->getLogoutUrl();
		} else {
		  $login_url = $facebook->getLoginUrl();
		}	
		
		$basic = $this->load_user_from_signed_request();	
		$results = array(
			'name' => $name,
			'user_id' => $user_id,
			'locale' => Arr::get($basic,'locale',null),
			'is_fan' => Arr::get($basic,'is_fan',null),
			'meta' => $profile,
			'login_url' => $login_url,
			'logout_url' => $logout_url,		
		);	
		return $results;		
	}
		
	/**
	* Receive and inspect incoming Facebook 
	* server side data that's loaded with the page
	*/	
	private function load_user_from_signed_request()
	{
		$data = Arr::get($_REQUEST,'signed_request',null);
		$locale = null;
		$is_fan = null;		
		
		if ( ! is_null($data))
		{		
			$data = $this->unpack_signed_request($data);
			// Look for page like
			if (array_key_exists('page',$data))
			{
				if (empty($data["page"]["liked"])) {			   
				   $is_fan = false;
				   Kohana_Log::instance()->add(Kohana_Log::DEBUG,"User has not liked page");		  
				} else {				
					$is_fan = true;
					Kohana_Log::instance()->add(Kohana_Log::DEBUG,"User likes page");
				}	
			}
			// Get user locale
			if (array_key_exists('user',$data))
			{		
				// Get user locale
				if (empty($data['user']['locale'])) {			   
				   $locale = null;
				} else {				
				   $locale = $data['user']['locale'];
				}				
			}
		} 
		return array(
			"locale" => $locale,
			"is_fan" => $is_fan,
		);
		
	}
	
	
	/**
	* Receive the $_REQUEST
	* and return useful data on the user
	*/	
	public function unpack_signed_request($request)
	{
		list($encoded_sig, $payload) = explode('.', $request, 2);
		return json_decode(base64_decode(strtr($payload, '-_', '+/')), true);		
	}
	
	/**
	* Return a uniqiue string to force browsers to
	* reload the same files - especially helpful whilst 
	* Facebook caches everything
	*/
	public function get_cache_string()
	{		
		$environment = $this->get_environment_type();
		if ($environment != Kohana::PRODUCTION)
		{
			// return something different to force a fresh copy upon users
			return uniqid();	
		} else {
			// always return the same for production
			return 'static';	
		}	
	}
	
	/**
	* Get the name of the environment from the configuration file, either 
	* - Development
	* - Staging
	* - Production
	*/	
	public function get_environment_type()
	{	
		return Kohana::$environment;
	}	
}
