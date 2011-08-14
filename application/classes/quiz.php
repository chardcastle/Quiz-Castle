<?php 

class Quiz 
{
	public $questions = array();
	public $question_ids;

	public function __construct($question_ids = null)
	{
		$questions = i18n::get('questions');
		

		if (is_null($question_ids))
		{
			// Make a new random collection of questions and save their positions within language file
			$question_selection = array_slice($questions, 0, Kohana::config('app.questions_per_contest'));
	   		$keys = array_keys( $question_selection );
	   		shuffle( $keys );
		} else {
			// Look for a pre determined set of questions				
			$keys = explode(',',$question_ids);
		}

   		$this->questions = $this->get_questions_from_ids($keys);
		$this->question_ids = $keys;	
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
