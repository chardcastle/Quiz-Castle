<?php defined('SYSPATH') or die('No direct script access.');

// Catch-all route for Codebench classes to run
Route::set('facebook', 'facebook(/<action>)')
	->defaults(array(
		'controller' => 'demo',
		'action' => 'index',
		'class' => NULL));