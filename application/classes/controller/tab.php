<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tab extends App_controller {

	public function action_index()
	{
		$view = View::factory('tab/index');
		$view->quiz = new Quiz();
		$view->cache = $this->cache;	
		$view->errors = null;	
		$this->response->body($view);
	}

	public function action_enter($entry_token = null)
	{
		// Redirect to app permission request
		$view = View::factory('tab/index');
		$view->quiz = new Quiz();
		$view->cache = $this->cache;		
		$view->errors = null;
		$post = Validation::factory($_POST)		
				->rule('answers', 'not_empty')
				->rule('answers', 'Quiz::is_all_questions_answered');
				
		if ($post->check())
		{
			$quiz = new Quiz();
			$quiz->entry_token = $quiz->get_entry_token();
			$view->quiz->add_new_entry($answers);			
		}
		$view->errors = $post->errors('validation');
		$this->response->body($view);
		// if code
			// get token
			// if token
		// get user update contest entry with token
	}

	public function action_answer()
	{
		$view = View::factory('tab/index');
		$this->request->param();			
		$this->response->body($view);
	}



} // End Welcome
