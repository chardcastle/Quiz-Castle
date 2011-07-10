<?php defined('SYSPATH') or die('No direct script access.');
/**
 * For Facebook page
 */
class Controller_Demo extends Kohana_Controller_Template {
	
	// The codebench view
	public $template = 'facebook';
	
	public function action_index()
	{
		phpinfo();die();
		// Create our Application instance (replace this with your appId and secret).
		$facebook = new Facebook(array(
		  'appId'  => '130035457066850',
		  'secret' => '736348b9164d993abff117e914527ee0',
		  'cookie' => true,
		));
		
		// We may or may not have this data based on a $_GET or $_COOKIE based session.
		//
		// If we get a session here, it means we found a correctly signed session using
		// the Application Secret only Facebook and the Application know. We dont know
		// if it is still valid until we make an API call using the session. A session
		// can become invalid if it has already expired (should not be getting the
		// session back in this case) or if the user logged out of Facebook.
		$session = $facebook->getSession();
		
		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $facebook->getUser();		   
		    $me = $facebook->api('/me');
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}
		
		// login or logout url will be needed depending on current user state.
		if ($me) {
		  $logoutUrl = $facebook->getLogoutUrl();
		} else {
		  $loginUrl = $facebook->getLoginUrl();
		}
		
		// This call will always work since we are fetching public data.
		$this->response->data = $facebook->api('/naitik');		
		$this->response->body('hello');
		
	}
	public function action_conf()
	{
		$data = Kohana::config('facebook')->app_key;
					
		//echo Debug::vars($view);die();
		$this->template->body = View::factory('facebook')
					->set('data',$data);
	}
}
