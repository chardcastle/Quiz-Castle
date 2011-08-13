<?php defined('SYSPATH') or die('No direct script access.');
/**
 * Environment config
 * @var unknown_type
 */
return array(
	/**
	 * Environment type
	 * @options 
	 *  * DEVELOPMENT
	 *  * TESTING
	 *  * STAGING
	 *  * PRODUCTION
	 */
	'environment'  => Kohana::DEVELOPMENT,
	'is_form_active' => true,
);