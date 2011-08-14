<?php 

class Quiz 
{
	public $questions = array();
	public $sequence;

	public function __construct($question_ids = null)
	{
		$questions = i18n::get('questions');
#		shuffle($questions);
#		$this->sequence = array_keys($questions);
		// get a range of questions 
		if (is_null($question_ids))
		{
			$question_selection = array_slice($questions, 0, Kohana::config('app.questions_per_contest'));
	   		$keys = array_keys( $question_selection );
	   		shuffle( $keys );
		} else {
			$keys = exlode(',',$question_ids);
		}

   		$this->questions = $this->get_questions_from_ids($keys);
		$this->sequence = $keys;	
	}

	public function get_questions_from_ids($keys)
	{
		$questions = i18n::get('questions');
		$questions_collection = array();
		foreach($keys as $id)
		{			
			$question = new Question($questions[$id]);
			$question->id = $id;
			shuffle($question->answers);
			$questions_collection[] = $question;			
		}
		return $questions_collection;
	}

	public static function is_all_questions_answered($answers)
	{
		return (count($answers) == Kohana::config('app.questions_per_contest'));	
	}
}
