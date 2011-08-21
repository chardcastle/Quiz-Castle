<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Canvas extends Controller_Global
{

	public function action_index()
	{
		$this->response->body('hello, world!');
	}

} // End Welcome
