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
		$new = array(
			'questions' => i18n::get('questions'),
		);
		$target = App_Build::get_movie_directory();
		$source_dir = App_Build::get_source_directory() . "movie_questions/";

		if (is_dir($source_dir))
		{
			foreach (glob($source_dir.'*') as $answer)
			{
				$meta = pathinfo($answer);
				$question_file_name = md5(strtolower($answer)) . '.' . Arr::get($meta, 'extension','');
				$question_thumb_name = md5(strtolower($answer)) . '_tab.' . Arr::get($meta, 'extension','');
				$question_answer = ucfirst(strtolower(str_replace('_', ' ', Arr::get($meta,'filename'))));
				$question_file = $target . $question_file_name;
				$question_url =  Kohana::config('app.app_url') .'/images/movie_questions/' . $question_thumb_name;
				// Make question
				$question = array(
					"body" => "Which film does the following image belong to?",
					"image_url" => $question_url,
					"correct_answer" => $question_answer,
					"type" => 'movie',
					"answers" => array(),
				);			
				// Add question
				$new['questions'][] = $question;

				// Copy original image
				if ( ! copy($answer, $question_file))
				{
					throw new Kohana_Exception('Could not copy file.');
				} else {
					// Make image of particular size
					Image::factory($question_file)
							->resize(500, NULL)
							->save($target . $question_thumb_name);
				}
			}
		}
		else
		{
			throw new Kohana_Exception('Could not find source images for movies.');
		}

		// Wriet questions to file
		$app_i18n = array_merge($app_i18n, $new);
		$new_quiz_copy = Kohana::FILE_SECURITY . "\r\n\r\n";
		$new_quiz_copy .= "return " . var_export($app_i18n,true) . ";";
		// Dind path to i18n
#		echo kohana_Debug::vars($lang_file);
#		echo kohana_Debug::vars($new_quiz_copy);
		if ( ! file_put_contents($lang_file, $new_quiz_copy))
		{						
			throw new Kohana_Exception('Could not write questions file xml.');
		}
		return true;
	}

	public static function tear_down()
	{
		$dir = App_Build::get_movie_directory();
		if (is_dir($dir))
		{
			foreach	(glob($dir.'*.xml') as $file)
			{				
				unset($file);
			}
			foreach	(glob($dir.'*.jpg') as $file)
			{
				unset($file);
			}
		} else {

			throw new Kohana_Exception("Could not list directory. {$dir}");
		}
	}


}
