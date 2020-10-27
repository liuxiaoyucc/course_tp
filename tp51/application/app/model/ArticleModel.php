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

		return $this->_redis->hmset("article:{$article_id}", $data);
	}

	private function article_id() {
		return $this->_redis->incrby('article:generator', 1);
	}

}