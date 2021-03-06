<?php namespace Config;//0PAYUTR
use CodeIgniter\Config\BaseConfig;

class Filters extends BaseConfig
{
	// Makes reading things below nicer,
	// and simpler to change out script that's used.
	public $aliases = [
		'csrf'     => \CodeIgniter\Filters\CSRF::class,
		//'toolbar'  => \CodeIgniter\Filters\DebugToolbar::class,
		//'honeypot' => \CodeIgniter\Filters\Honeypot::class,
		'financepanelAuthFilter'   => \Financepanel\Filters\AuthenticationFilter::class,
	];

	// Always applied before every request
	public $globals = [
		'before' => [
			//'honeypot'
			'csrf' => ['except' => ['*/*/subscription/*', '*/*/invoice/save/*']]
		],
		'after'  => [
			//'toolbar',
			//'honeypot'
		],
	];

	// Works on all of a particular HTTP method
	// (GET, POST, etc) as BEFORE filters only
	//     like: 'post' => ['CSRF', 'throttle'],
	public $methods = [];

	// List filter aliases and any before/after uri patterns
	// that they should run on, like:
	//    'isLoggedIn' => ['before' => ['account/*', 'profiles/*']],
	public $filters = [];
}
