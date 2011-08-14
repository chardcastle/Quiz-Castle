<?php

class Question
{
	public $body = null;
	public $correct_answer = null;
	public $answers = null;
	public $id = null;

	public function __construct($data = array())
	{
		foreach($data as $property => $value)
		{
			$this->{$property} = $value;
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


}
