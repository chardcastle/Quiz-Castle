<?php defined('SYSPATH') or die('No direct script access.');

abstract class Controller_Global extends Controller_Template
{
 
    public $page_title;
	public $extra_scripts;

    public function before()
    {
        parent::before();
        // Make $page_title available to all views
        //View::bind_global('page_title', $this->page_title);
		$app = new App();
        $this->template->cache = $app->cache_breaker;
		
		$this->template->app_url = Kohana::config('app.app_url');	
		$this->template->home_url = Kohana::config('app.home_address');
		$this->template->site_administrators = Kohana::config('app.admins');

		// Globals	
		$this->template->extra_scripts = array();
		View::bind_global('extra_scripts', $this->template->extra_scripts);

		// Facebook vars
		$this->template->facebook = Kohana::config('app.facebook');

		// Facebook object
		$facebook = new Facebook(array(
		  'appId'  => Kohana::config('app.facebook.id_key'),
		  'secret' => Kohana::config('app.facebook.secret'),
		));
		$app = new App();		
		//$user = ORM::factory('user');
		$user_data = $app->get_facebook_user($facebook);
		$keys = array('name', 'user_id', 'locale', 'is_fan', 'meta');
		$user = ORM::factory('user')
				->values($user_data, $keys);
		$this->template->user = $user;
	
    }
 
}
