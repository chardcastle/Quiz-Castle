<?php defined('SYSPATH') OR die('Kohana bootstrap needs to be included before tests run');

/**
 * Tests Date class
 *
 * @group QuizCastle
 * @group QuizCastle.quiz
 *
 * @package    QuizCastle
 * @category   Tests
 * @author     Chris Hardcastle
 * @author     Chris <me@chrishardcastle.co.uk>
 * @copyright  (c) 2008-2011 Kohana Team
 * @license    http://kohanaframework.org/license
 */
class QuizCastle_quizTest extends Unittest_TestCase
{
	protected $_original_timezone = NULL;
	public $user;
	/**
	 * Ensures we have a consistant timezone for testing.
	 */
	public function setUp()
	{
		parent::setUp();
		// Make user
		$app = new App();		
		$facebook = new Facebook(array(
		  'appId'  => Kohana::config('app.facebook.id_key'),
		  'secret' => Kohana::config('app.facebook.secret'),
		));
		$user_data = $app->get_facebook_user($facebook);
		$keys = array('name', 'user_id', 'locale', 'is_fan', 'meta');
		$this->user = ORM::factory('user')
				->values($user_data, $keys);
		
	}

	/**
	 * Restores original timezone after testing.
	 */
	public function tearDown()
	{
		parent::tearDown();
	}

	/**
	 * Provides test data for tests
	 *
	 * @return array
	 */
	public function provider_entry()
	{
		$fake = array
		(
			'user_id' => 98467,
			'score' => 6,	
			'score_breakdown' => serialize(array('fafasd','fsdfsdasd')),
			'entry_token' => 'fake',	
			'submitted' => '2011/09/06 11:42:13',
			'question_ids' => "1,9,8,7,2,6,5,3,0,4",
		);
		return array(
			array($fake),
		);
	}
	
	/**
	 * Test Quiz entry
	 *
	 * @test
	 * @dataProvider provider_entry
	 * @covers Quiz->add_entry
	 * @param array $test_data Expected data
	 */
	public function test_entry($test_data)
	{
		// Make the test data
		$score = ORM::factory('score');
		foreach ($test_data as $key => $value)
		{
			$score->set($key, $value);
		}
		
		Kohana_Log::instance()->add(Kohana_Log::DEBUG, 'Looking at values :entry_items :object',
			array(
				':entry_items' => print_r($test_data,true),
				':object' => print_r(get_object_vars($score),true),
			));		

		// Create a new score entry
		$is_ok = true;
		try {
			$score->create();
			Kohana_Log::instance()->add(Kohana_Log::INFO, 'Query executed fine :query',array(':query'=>ORM::factory('score')->last_query()));
		} catch(Exception $e) {
			$is_ok = false;
			Kohana_Log::instance()->add(Kohana_Log::ERROR, 'Exception saving :message ',array(':message'=>$e->__toString()));
		}		
		$this->assertEquals(true, $is_ok);
	}


	public function provider_validation()
	{
		// All questions answered
		$valid_entry_data = array
		(
			'quiz_token' => 'b56150e25ffb85a616872b346ddbe568',
			'question_sequence' => "1,9,8,7,2,6,5,3,0,4",
			'answers' => array(1=>0,9=>1,8=>1,7=>0,2=>1,6=>0,5=>1,3=>0,0=>1,4=>1),
		);

		// Some questions have not been answered
		$invalid_entry_data = array
		(
			'quiz_token' => 'b56150e25ffb85a616872b346ddbe568',
			'question_sequence' => "1,9,8,7,2,6,5,3,0,4",
			'answers' => array(1=>0,9=>1,8=>1,6=>0,5=>1,3=>0,0=>1,4=>1),
		);
		return array(
			array($valid_entry_data),
			array($invalid_entry_data),
		);
	}

	/**
	 * Check end of game validation
	 *
	 * @test
	 * @dataProvider provider_validation
	 * @covers Quiz->add_entry with validation
	 * @param array $test_data Expected data
	 */
	public function test_entryvalid($data)
	{
		$post = Validation::factory($data)		
				->rule('answers', 'not_empty')
				->rule('answers', 'Quiz::is_all_questions_answered');

		$is_ok = false;
		if ($post->check())
		{
			$is_ok = true;
			// Load
			$entry = new Entry($post);
			$quiz = new Quiz($entry->question_sequence);
			$result = $quiz->get_score($entry);
			// Set
			$score = ORM::factory('score');
			$score->set('score_breakdown', serialize($result->break_down));
			$score->set('question_ids', $entry->question_sequence);
			$score->set('score', $result->score);
			$score->set('user_id', $this->user->get_id());
			$score->set('entry_token', $entry->quiz_token);
			$score->set('submitted', Model_Score::get_datetime());

			try
			{
				// Create new entry
				$score->create();

			} catch(Exception $e) {

				$view->errors = array($e->__toString());
				$this->response->body($view);
			}
		} else {

			Kohana_Log::instance()->add(Kohana_Log::ERROR, 'Fafiled validation');	
		}		
		$this->assertEquals(true, $is_ok);
	}

	/**
	 * Provider resume from incomplete quiz
	 *
	 *
	 * @return array
	 */
	public function provider_resume_incomplete_questions()
	{
		return array(
			array("1,9,8,7,2,6,5,3,0,4", serialize(array(1=>0,9=>1,8=>1,6=>0,5=>1,3=>0,0=>1,4=>1))),
			array("11,19,18,17,12,16,15,13,10,14",serialize(array(11=>0,19=>1,18=>1,6=>0,5=>1,3=>0,0=>1,4=>1))),
			array("21,29,28,27,22,26,25,23,20,24",serialize(array(21=>0, 29=>1))),
		);
	}

	/**
	 * Test Quiz entry
	 *
	 * @test
	 * @dataProvider resume_incomplete_questions
	 * @covers Quiz->add_entry
	 * @param array $question_ids Questions ids
	 * @param string $session_answers Serialized array of answers so far
	 */
	public function test_resume_incomplete_questions($question_ids, $session_answers)
	{

	}

	/**
	 * Provider play another game 
	 *
	 * @return array Collection of question id's that have been answered already
	 */	
	public function provider_play_again()
	{
		return array(
			array("1,9,8,7,2,6,5,3,0,4"),
			array("11,19,18,17,12,16,15,13,10,14,1,9,8,7,2,6,5,3,0,4"),
			array("11,19,18,17,12,16,15,13,10,14,1,9,8,7,2,6,5,3,0,4,21,29,28,27,22,26,25,23,20,24"),
		);
	}

	/**
	 * Test Quiz entry
	 *
	 * Get another ten questions that exclude those 
	 * that exist within the provided parameter
	 * @test
	 * @dataProvider provider_play_again
	 * @covers Quiz->add_entry
	 * @param array $test_data Expected data
	 */
	public function test_play_again($questions_to_be_excluded)
	{

	}
}
