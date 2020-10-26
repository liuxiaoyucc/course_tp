<?php

namespace application\test\controller;

use think\Controller;
use \Env;
use Config;


class Index extends Controller
{
	
	public function __construct()
	{
		
	}


	public function env()
	{
		echo "env操作测试";
	}

	public function config()
	{
		echo 'config操作测试' . PHP_EOL;
		print_r(Config::get('user'));

		print_r(Config::get('db'));
	}
}