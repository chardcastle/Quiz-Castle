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
		$view->quiz = new Quiz($question_ids);

		$view->cache = $this->cache;		
		$view->errors = null;
		$post = Validation::factory($_POST)		
				->rule('answers', 'not_empty')
				->rule('answers', 'Quiz::is_all_questions_answered');
				
		if ($post->check())
		{			
			$quiz = new Quiz($question_ids);
			$quiz->entry_token = $quiz->get_entry_token();
			$entry = new Entry($post);
			$quiz->get_score($entry);
			$view->quiz->add_new_entry($entry);	
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
	
	public function authorise)
	{
		// if code
			// get token
			// if token
		// get user update contest entry with token
	}

s

