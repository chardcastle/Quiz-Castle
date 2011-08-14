<?php 

class Quiz 
{
	public $questions = array();

	public function __construct()
	{
		$questions = i18n::get('questions');
		shuffle($questions);
		foreach($questions as $pointer => $question)
		{
			$pointer = $pointer + 1;
			// limit
			if ($pointer <= Kohana::config('app.questions_per_contest'))
			{
				$question = new Question($question);
				$question->id = $pointer;
				shuffle($question->answers);
				$this->questions[] =  $question;
					
			} else {
				return true;
			}	
			
		}	
	}
}
