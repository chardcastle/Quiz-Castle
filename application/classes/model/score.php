<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Toblerone Kitchen
*/


class Model_Score extends ORM
{
	/**
	* Name of the database table 
	*/
	protected $_table_name = 'scores';
	
	/**
	* Is existing fan of the page
	*/
	public $user_id = null;
	
	/**
	* Questions correct
	*/
	public $score;	
	
	/**
	* Description of which quesions were correct
	*/
	public $score_breakdown;
		
	/**
	* Binds this entry to new application users
	*/		
	public $entry_token;	

	public $submitted;
	
	public $question_ids;	

 	protected $_rules = array(
		'entry_token' => array(
		    'not_empty',      
		),       
		'score_breakdown' => array(
		    'not_empty',      
		),   
    );	
	
	public static function get_datetime()
	{
		return date('Y/m/d H:i:s');
	}
	
	public function get_score($entry_token)
	{
		$values = ORM::factory('score')
				->where('entry_token', '=', $entry_token)
				->find()
				->as_array();
		Kohana_Log::instance()->add(Kohana_Log::DEBUG,
				'Getting values for :entry_token example is :example',
				array(':entry_token'=>$entry_token,':example'=>print_r(Arr::get($values,'score','x'),true))
		);
		return array(
			'score' => Arr::get($values,'score','y'),
			'score_breakdown' => Arr::get($values,'score_breakdown',''),
			'question_ids' => Arr::get($values,'question_ids',''),
		);
	}
}

