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
	'facebook' => array(
		'id_key' => '220812297965188',
		'secret' => '2dfa123a305720e004daeade49e51b3a',	
		'canvas_url' => 'http://apps.facebook.com/emc_contest',
		'tab_page_url' => 'http://www.facebook.com/pages/EMC-Contest/181942355205924?sk=app_220812297965188',	
	),
	'app_url' => 'http://quizcastle.local.net',
	'home_address' => 'http://chrishardcastle.co.uk',
	'questions_per_contest' => 10,
	'admins' => array(
		'664739612',
		'523155273',
		'879870713',
	),
);
