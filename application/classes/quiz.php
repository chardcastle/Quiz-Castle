<?php 

class Quiz 
{
	public $questions = array();

	public function __construct()
	{
		$this->questions = i18n::get('questions');	
	}
}
