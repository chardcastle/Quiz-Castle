<?php 

class Quiz 
{
	public $questions = array();
	public $question_ids;
	public $quiz_entries_file = null;
	public $quiz_questions_count = -1;

	public function __construct($question_ids = null)
	{
		$questions = i18n::get('questions');
		$this->quiz_questions_count = Kohana::config('app.questions_per_contest');

		if (is_null($question_ids))
		{
			// Make a new random collection of questions and save their positions within language file
			$question_selection = array_slice($questions, 0, $this->quiz_questions_count);
	   		$keys = array_keys( $question_selection );
	   		shuffle( $keys );
		} else {
			// Look for a pre determined set of questions				
			$keys = explode(',',$question_ids);
		}
		$this->quiz_entries_file = APPPATH.'quiz_entries.xml';
   		$this->questions = $this->get_questions_from_ids($keys);
		$this->question_ids = $keys;	
		$this->entry_token = $this->get_entry_token();
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
		$result = new Result();
		$result->number_of_questions = count($entry->answers);
		
		foreach ($this->question_ids as $question_id)
		{
			$question = new Question();
			$question =  $question->get_question_by_id($question_id);
			$user_answer = Arr::get($entry->answers,$question_id,'');
			$is_correct = false;
			if ($user_answer == $question->correct_answer)
			{
				$is_correct = true;
				$result->score = (int)$result->score + 1;
			}		
			$result->add_question_result($question_id, $is_correct);
		}
		return $result;			
	}

	public function add_new_entry(Entry $entry, Quiz $quiz)
	{
		$xml = simplexml_load_file($this->quiz_entries_file);
		$new_entry = $xml->entries->addChild('entry');		
		$new_entry->user = serialize(array());
		$new_entry->question_ids = (string)implode(',',$quiz->question_ids);		
		$new_entry->score = (string)$entry->results->score;		
		$new_entry->score_breakdown = (string)$entry->results->get_break_down();
		$new_entry->entry_token = (string)$quiz->entry_token;

		if (file_put_contents($this->quiz_entries_file, $xml->asXml()) !== false){
			return true;
		} else {
			throw new Kohana_Exception('Quiz entry :file must be writable',
				array(
					':file' => $this->quiz_entries_file
				)
			);
		}
	}	

	public static function is_all_questions_answered($answers)
	{
		return (count($answers) == Kohana::config('app.questions_per_contest'));	
	}
}
