<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tab extends App_controller {

	public function action_index()
	{
		$view = View::factory('tab/index');
		$view->quiz = new Quiz();
		$view->cache = $this->cache;		
		$view->errors = null;	
		// if user is facebook
			// send to results
		// else
			$this->response->body($view);
	}

	public function action_enter($entry_token = null)
	{
		// Redirect to app permission request
		$view = View::factory('tab/index');	
		// Load quiz with questions from collection
		$question_ids = Arr::get($_POST,'question_sequence',null);	
		$quiz = new Quiz($question_ids);

		$view->quiz = $quiz;
		$view->cache = $this->cache;		
		$view->errors = null;
		$post = Validation::factory($_POST)		
				->rule('answers', 'not_empty')
				->rule('answers', 'Quiz::is_all_questions_answered');
				
		if ($post->check())
		{						
			$entry = new Entry($post);			
			$entry->results = $quiz->get_score($entry);			
			try {
				$view->quiz->add_new_entry($entry, $quiz);
			} catch(Exception $e)
			{
				$view->errors = array($e->__toString());
				$this->response->body($view);
			}
			// if ajax
				// echo done
			// else
				// redirect to app permissions process
				// tab/authorise
		} else {
			$view->errors = $post->errors('validation');
			$view->existing_answers = Arr::get($_POST,'answers',array());
		}
		$this->response->body($view);

	}
	
	public function action_answer()
	{
		$view = View::factory('tab/index');
		$this->request->param();			
		$this->response->body($view);
	}
	
	public function authorise()
	{
		// if code
			// get token
			// if token
		// get user update contest entry with token
	}
}
