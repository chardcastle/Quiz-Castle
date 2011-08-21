<?php defined('SYSPATH') or die('No direct script access.');
/**
 * @package    Toblerone Kitchen
*/


class Model_User extends ORM
{
	/**
	* Name of the database table 
	*/
	protected $_table_name = 'users';
	
	/**
	* Is existing fan of the page
	*/
	public $user_id = null;
	
	/**
	*/
	public $name = null;
	
	/**
	* Is fant
	*/
	public $is_fan;	
	
	/**
	* Is admin
	*/
	public $is_admin;
		
	/**
	* Has control over submitted recipes
	*/		
	public $is_moderator;	
	
	/**
	* User locale
	*/
	public $locale;	
	
	/**
	* Contains all the data provided to the object
	* by the Facebook API
	*/			
	public $meta;
			
 	protected $_rules = array(
     	   'user_id' => array(
            'not_empty',      
		),       
	    );	
	
	public function get_id()
	{
		if (is_null($this->user_id))
		{
			// return negative number
			$this->user_id = (int)rand(-999999, 0);
		} 
		return $this->user_id;
	}
}

