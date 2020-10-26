<?php

namespace application\app\controller\v2;

use think\Controller;

class Article extends Controller
{
	
	public function __construct()
	{
		
	}


	public function list()
	{
		return 'list';
	}

	public function add()
	{
		return 'add';
	}

	public function like()
	{
		return 'like';
	}

}