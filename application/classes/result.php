<?php 

class Result
{
	public $score = -1;
	public $number_of_questions = -1;
	public $break_down = array();

	public function add_question_result($quesiton_id, $is_correct)
	{
		$this->break_down[$quesiton_id] = $is_correct;
	}
	public function get_break_down()
	{
		return (string)serialize($this->break_down);
	}
}
