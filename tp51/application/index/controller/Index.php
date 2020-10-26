<?php
namespace application\index\controller;
use think\Controller;
use \Env;
use Config;


class Index extends Controller
{

	protected $beforeActionList = [
		'first'
	];

	protected function first()
	{
		echo "first<br>";
	}

	protected function second()
	{
		echo "second";
	}

	protected function third()
	{
		echo "third";
	}

    public function index()
    {
    	print_r(Env::get('api.host'));
        
    }

    public function one()
    {
        return 'one';
    }

    public function two()
    {
    	return 'two';
    }
}
