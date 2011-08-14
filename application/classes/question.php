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


}
