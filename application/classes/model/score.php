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

	
 	protected $_rules = array(
		'entry_token' => array(
		    'not_empty',      
		),       
		'score_breakdown' => array(
		    'not_empty',      
		),   
    );	

	
}

