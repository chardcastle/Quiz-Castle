<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Website extends Controller_Global
{
	public $template = 'website';
	
	public function action_index()
	{
		$this->template->page_title = "Quiz Castle | " . i18n::get('tab_title');
		$body = View::factory('tab/index');
		$body->quiz = new Quiz();
		$body->errors = null;	
		// Send body content to tmeplate
		$this->template->body = $body->render();

	}
 
}
