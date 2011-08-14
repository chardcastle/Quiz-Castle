<?php 

class Quiz 
{
	public $questions = array();
	public $question_ids;
	public $quiz_entries_file = APPPATH.'/quiz_entries.xml';

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

	public function get_entry_token()
	{
		return md5(uniqid(rand(), TRUE));
	}

	public function get_score(Entry $entry)
	{
		$result = array(
			'questions' => count($entry->answers),
			'score' => 0,
		);
		foreach ($entry->question_ids as $question_id)
		{
			$question = new Question();
			$question =  $question->get_question_by_id($question_id);
			$user_answer = Arr::get($entry->answers,$question_id,'')
			if ($user_answer == $question->correct_answer)
			{
				$result['score'] = (int)$result['score'] + 1;
			}		
		}		
		return $result;			
	}

	public function add_new_entry(Entry $entry)
	{
		$xml = simplexml_load_file($this->quiz_entries_file);
		$new_entry = $xml->entries->addChild('entry');		
		$new_entry->responses = (string)$entry->responses;		
		//$new_entry->is_fan = (string)($entry->user->is_fan > 0 ? 'yes' : 'no');		
		$new_entry->entry_token = (string)$entry->entry_token;

		if (file_put_contents($this->quiz_entries_file, $xml->asXml()) !== false){
			return true;
		} else {
			return false;
		}
	}	

	public static function is_all_questions_answered($answers)
	{
		return (count($answers) == Kohana::config('app.questions_per_contest'));	
	}
}
