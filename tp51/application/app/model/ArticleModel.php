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

	public function add($data) {
		if (!$data) {
			return false;
		}

		$article_id = $this->article_id();

		$this->like($article_id, $data['poster']);
		$this->_redis->zadd('article:time', $data['time'] ,$article_id); // 时间排序列表
		return $this->_redis->hmset("article:{$article_id}", $data);
	}

	public function like($article_id, $user_id)
	{
		if (!$article_id || !$user_id) {
			return false;
		}
		$this->_redis->zincrby("article:votes", 1, $article_id); // 更新分值, 后面需要用算法计算出分值, 综合点赞评论等等
		return $this->_redis->rpush("like:{$article_id}", $user_id);
	}

	private function article_id() {
		return $this->_redis->incrby('article:generator', 1);
	}

}