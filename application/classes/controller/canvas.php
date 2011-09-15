<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Canvas extends Controller_Global
{
	public $template = 'website';

	public function action_index()
	{
		$this->response->body('hello, world!');
	}

	public function action_build()
	{

		try 
		{
			// Make questions from movie images
			App_Build::build_movie_questions();
			// Get XML of moview choices
			App_Build::build_movie_answers();
		}
		catch (Exception $e)
		{
			throw new Http_Exception_500($e->__toString());
		}
		$this->template->body = 'done';
	}


	public function action_buildtwo()
	{

		try 
		{
			App_Build::build_movie_questions();
		}
		catch (Exception $e)
		{
			throw new Http_Exception_500($e->__toString());
		}
		$this->template->body = 'done';

	}

} // End Welcome
