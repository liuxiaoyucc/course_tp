<?php

namespace application\app\controller\v1;

use think\Controller;
use Log;
use Cache;
// use Log; // 日志类

// request 处理库, 继承think\Controller后可直接使用$this->request属性, 这里不用再引入
// use think\Request; 

class Article extends Controller
{

	private $redis;
	
    /*
	* 控制器前置操作, 可指定方法, 较之__construct更加灵活, 
	* 1. 和__construct同时存在时无效
	* 2. 不能使用return输出
	* only 仅接受
	* except 排除
	*/
	protected $beforeActionList = [
		'valid',
		'add_times' => ['only'=> 'list']
	];

	protected function valid()
	{
		// 这里可以验证签名
		Log::write('这里可以验证请求合法性');

		$this->redis = Cache::store('redis')->handler();

	}

	// 在请求list时, 统计总访问次数, 简单防爬
	protected function add_times()
	{
		Log::write('times ++');
	}

	public function list()
	{
		return 'list';
	}

	public function info()
	{
		echo "info";
	}

	/* 
	* 使用redis散列存储文章信息
	* 1. 生成文章ID
	* 2. 保存文章数据
	* 3. 将发布者加入到已投票用户集合
	* 4. 生成两个有序集合, 分值分别为发布时间和评分
	*/
	public function add()
	{
		$post = $this->request->post();


		$article_id = $this->get_art_id();

		// boolean
		$this->redis->hmset("article:{$article_id}", [
			'title'=> $post['title'],
			'content'=> $post['content'],
			'time'=> time(),
			'poster'=> 'user:' . $post['user_id'],
			'link'=> $post['link'],
			'votes'=> 0
		]);
		
		return 'ok';
	}

	public function like()
	{
		return 'like';
	}



	/*
	* 文章id生成器
	*/
	private function get_art_id()
	{
		return $this->redis->incrby('article:generator', 1);
	}


}