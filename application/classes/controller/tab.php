<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Tab extends Controller_Global
{

	public $template = 'tab';

	public function action_index()
	{
		$body = View::factory('tab/index');
		$body->quiz = new Quiz();
		$body->errors = null;	
		// Send body content to tmeplate
		$this->template->body = $body->render();
	}

	public function action_enter($entry_token = null)
	{
		// Redirect to app permission request
		$view = View::factory('tab/index');	
		// Load quiz with questions from collection
		$question_ids = Arr::get($_POST,'question_sequence',null);	
		$quiz = new Quiz($question_ids);

		$view->quiz = $quiz;
		$view->errors = null;
		$post = Validation::factory($_POST)		
				->rule('answers', 'not_empty')
				->rule('answers', 'Quiz::is_all_questions_answered');
				
		if ($post->check())
		{	
			$is_ok = true;
			// Load
			$entry = new Entry($post);
			$quiz = new Quiz($entry->question_sequence);
			$result = $quiz->get_score($entry);
			// Set
			$score = ORM::factory('score');
			$score->set('score_breakdown', serialize($result->break_down));
			$score->set('question_ids', $entry->question_sequence);
			$score->set('score', $result->score);
			$score->set('user_id', $this->user->get_id());
			$score->set('entry_token', $entry->quiz_token);
			$score->set('submitted', Model_Score::get_datetime());

			try
			{
				// Create new entry
				$score->create();
				$this->response->redirect('tab/finish/'.$entry->entry_token);
			} catch(Exception $e) {

				$view->errors = array($e->__toString());
				$this->response->body($view);				
			}
		} else {
			$view->errors = $post->errors('validation');
			$view->existing_answers = Arr::get($_POST,'answers',array());
		}
		$this->template->body = $view->render();
	}
	
	public function action_finish($entry_token)
	{
		$view = View::factory('tab/finish');	
		$score = ORM::factory('score')	
				->get_score($entry_token);

		$result = new Result();	
		$result->number_of_questions = Arr::get($score,'number_of_questions','');	
		$result->score = Arr::get($score,'score','');
		$result->score_breakdown = Arr::get($score,'score_breakdown','');
		$result->question_ids = Arr::get($score,'question_ids','');
	
		$quiz = new Quiz($result->question_ids);
		$responses = unserialize($result->score_breakdown);

		$html = '';
		$first = true;
		foreach ($quiz->questions as $label => $question)
		{
			$label = (int)$label + 1;			
			$last = ($label == $result->number_of_questions);
			$html .= View::factory('tab/game_review')
					->bind('label', $label)
					->bind('last', $last)
					->bind('first', $first)
					->bind('answer', $question->correct_answer)
					->bind('question', $question->body)
					->bind('is_correct', $responses[$question->id])
					->bind('is_bonus', $question->is_bonus)
					->bind('points', $question->points)
					->bind('score', $result->score)
					->render();
			$first = false;
		}
		
		$view->review = $html;
		$view->result = $result;
		$view->info = ORM::factory('score')->last_query();

		$this->template->body = $view->render();
		$this->template->extra_scripts[] = 'jquery.qtip-1.0.0-rc3.min';
		$this->template->extra_scripts[] = 'fonts/Guifx_v2_Transports_400.font';
	}


	/**
	* Ajax only!
	*/
	public function action_answer()
	{
		$question = new Question();
		$question_id = Arr::get($_POST,'question_id',null);
		$user_answer = Arr::get($_POST,'answer',null);
		$is_correct = false;
		if ( ! is_null($question_id))
		{
			$question = $question->get_question_by_id($question_id);
			if ($question->correct_answer == $user_answer)
			{
				$is_correct = true;
			}			
		}
		echo json_encode(array('message'=>$question->get_response($is_correct)));
		exit;
	}	

	public function action_thank()
	{
		$view = View::factory('tab/thanks');
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
