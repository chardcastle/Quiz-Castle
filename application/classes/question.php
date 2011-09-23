<?php

class Question
{
	public $body = null;
	public $correct_answer = null;
	public $answers = null;
	public $id = null;
	public $is_bonus;
	public $points;

	public function __construct($data = array())
	{
		if ( ! empty($data))
		{
			foreach($data as $property => $value)
			{
				$this->{$property} = $value;
			}
			$this->is_bonus = ($this->points > 100);
		}
	}

	public function get_question_by_id($position)
	{
		$questions = i18n::get('questions');
		$total_questions = count($questions);
		for ($pointer = 0; $pointer <= $total_questions; $pointer++)
		{
			if ($pointer == $position)
			{
				return new Question($questions[$pointer]);
			}
		}
	}

	/**
	* @param bool Result from correction answer
	* @return string A random response based on a positive or negative value
	*/
	public function get_response($is_correct = false)
	{
		$type = ($is_correct ? 'correct' : 'incorrect');
		$responses = i18n::get('responses');
		$responses = $responses[$type];
		shuffle($responses);
		return Arr::get($responses,0,"Could not compute a response");
	}

#	public function get_meta_as_json($index = 0)
#	{
#		$meta = array(
#			'question_id' => $this->id,
#			'position' => $index,
#		);
#		return json_encode($meta);
#	}

}
