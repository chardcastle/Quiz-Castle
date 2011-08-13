<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tab extends App_controller {

	public function action_index()
	{
		$view = View::factory('tab/index');
		$view->quiz = new Quiz();
		$view->cache = $this->cache;		
		$this->response->body($view);
	}

} // End Welcome
