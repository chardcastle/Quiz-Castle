<?php 

class Entry
{
	public $submitted = null;
	public $score = 0;
	public $user;

	public function __construct($data = array())
	{
		if ( ! empty($data))
		{
			foreach($data as $property => $value)
			{
				$this->{$property} = $value;
			}
			$this->submitted = date('d/m/Y H:i:s');
		}
	}

}

