<?php

namespace application\app\model;

use Cache;
/**
 * 
 */
class ArticleModel
{
	private $_redis;

	public function __construct() {
		$this->_redis = Cache::store('redis')->handler();
	}

	public function get($article_id)
	{
		if (!$article_id) {
			return false;
		}

		return $this->_redis->hgetall("article:{$article_id}");
	}

	public function list($page, $sort_by = 'time')
	{
		$limit = 5; //每页5条

		$start = ($page - 1) * $limit;
		$end = $start + $limit - 1;

		$ids = $this->_redis->zrevrange("article:{$sort_by}", $start, $end);

		$articles = [];
		foreach ($ids as $id) {
			$articles[] = $this->_redis->hgetall($id);
		}

		return $articles;
	}

	public function add($data) {
		if (!$data) {
			return false;
		}

		$article_id = $this->article_id();

		$this->like($article_id, $data['poster']);
		$this->_redis->zadd('article:time', $data['time'], "article:{$article_id}"); // 时间排序列表
		return $this->_redis->hmset("article:{$article_id}", $data);
	}

	public function like($article_id, $user_id)
	{
		if (!$article_id || !$user_id) {
			return false;
		}
		$this->_redis->zincrby("article:votes", 1, "article:{$article_id}"); // 更新分值, 后面需要用算法计算出分值, 综合点赞评论等等
		return $this->_redis->rpush("like:{$article_id}", $user_id);
	}

	private function article_id() {
		return $this->_redis->incrby('article:generator', 1);
	}

}