<?php 

class Entry
{
	public $submitted = null;
	public $score = 0;
	public $score_breakdown = -1;
	public $entry_token = null;
	public $user = null;
	public $question_ids = null;

	public function __construct($data = array())
	{
		if ( ! empty($data))
		{
			foreach($data as $property => $value)
			{
				$this->{$property} = $value;
			}
			$this->submitted = date('Y/m/d H:i:s');
		}
	}


}

