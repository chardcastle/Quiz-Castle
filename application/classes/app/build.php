<?php

class App_Build
{
	public static function get_movie_directory()
	{
		$path = DOCROOT.'images/movie_questions/';
		if ( ! is_dir($path))
		{
			throw new Http_Exception_500("The directory {$path} does not exist");
		}
		return $path;
	}

	public static function get_source_directory()
	{
		$path = APPPATH . "var/source/";
		if ( ! is_dir($path))
		{
			throw new Http_Exception_500('Could not find source directory');
		}
		return $path;
	}
	
	/**
	* Make the list of movies
	*/
	public static function build_movie_answers()
	{
		$collection = new SimpleXMLElement('<movies></movies>');
		$target = App_Build::get_movie_directory() . 'answers.xml';
		$source_file = App_Build::get_source_directory() . "movie_answers.csv";		
		$handle = fopen($source_file, "r");

		if ($handle !== FALSE)
		{
			while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
			{
				$num = count($data);
				$title = ucfirst(strtolower(str_replace('_', ' ', $data[0])));
				$collection->addChild('title', $title);
			}
			fclose($handle);
			
			try
			{
				file_put_contents($target, (string)$collection->asXml());
			}
			catch(Exception $e)
			{
				throw new Kohana_Exception("Could not write movie answers {$source_file}");
			}
		}
		else
		{
			throw new Kohana_Exception("Could not find movie answer csv {$source_file}");
		}
		return true;
	}
	
	public static function test(){}

	/**
	* Make the list of movie questions	
	*/
	public static function build_movie_questions()
	{
		// Get all site copy
		$lang = i18n::lang();
		$app_i18n = i18n::load($lang);
		$lang_file = APPPATH . 'i18n/en.php';
		if ($lang !== 'en-us' || ! is_writable($lang_file))
		{
			throw new Kohana_Exception('Application is not in desired locale or is unable to write to language file.');
		}
		// Get existing questions
		$collection = i18n::get('questions');
		$target = App_Build::get_movie_directory();
		$source_dir = App_Build::get_source_directory();
		$dir = $source_dir . "movie_questions/";

		if (is_dir($dir))
		{
			foreach (glob($dir.'*') as $answer)
			{
				$meta = pathinfo($answer);
				$question_file_name = md5(strtolower($answer)) . '.' . Arr::get($meta, 'extension','');
				$question_file = $target . $question_file_name;
				$question_url =  Kohana::config('app.app_url') .'/images/movie_questions/' . $question_file_name;
				// Make question
				$question = array(
					"body" => "What famous document begins: 'When in the course of human events...'?",
					"correct_answer" => "The Declaration of Independence.",
					"answers" => array(
						"The bible",
						"Itunes terms of service",
						"The Magna carter",
						"The Declaration of Independence.",
					),
				);
			
				// Add question
				$collection[] = $question; 

				if ( ! copy($answer, $question_file))
				{
					throw new Kohana_Exception('Could not copy file.');
				}
			}
		}
		else
		{
			throw new Kohana_Exception('Could not find source images for movies.');
		}
		
		// Wriet questions to file
		$app_i18n['questions'] = $collection;
		// Dind path to i18n
		if ( ! file_put_contents($lang_file, var_export($app_i18n, false)))
		{						
			throw new Kohana_Exception('Could not write questions file xml.');
		}
		return true;
	}
	/**
	* Make the list of movie questions	
	
	public static function build_movie_questions()
	{

		$collection = new SimpleXMLElement('<movie_questions></movie_questions>');
		$target = App_Build::get_movie_directory();
		$source_dir = App_Build::get_source_directory();
		$dir = $source_dir . "movie_questions/";

		if (is_dir($dir))
		{
			foreach (glob($dir.'*') as $answer)
			{
				$meta = pathinfo($answer);
				$question_file_name = md5(strtolower($answer)) . '.' . Arr::get($meta, 'extension','');
				$question_file = $target . $question_file_name;
				$question_url =  Kohana::config('app.app_url') .'/images/movie_questions/' . $question_file_name;
				// Make question
				$question = $collection->addChild('question');
				$question->addChild('answer', (string)$answer);
				$question->addChild('image_source', (string)$question_file);
				// Add question
				$collection->addChild('question', $question); 

				if ( ! copy($answer, $question_file))
				{
					throw new Kohana_Exception('Could not copy file.');
				}
			}
		}
		else
		{
			throw new Kohana_Exception('Could not find source images for movies.');
		}
		
		// Wriet questions to file
		$xml = (string)$collection->asXml();
		if ( ! file_put_contents($target  . 'questions.xml', $xml))
		{						
			throw new Kohana_Exception('Could not write questions file xml.');
		}
		return true;
	}*/
}
