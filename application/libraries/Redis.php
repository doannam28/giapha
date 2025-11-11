<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Redis
{

    protected $redis;

    public function __construct()
    {
        $this->redis = new Redis();
        $this->redis->connect('127.0.0.1', 6379); // Adjust the host and port if needed
    }

    public function getRedisInstance()
    {
        return $this->redis;
    }

    public function clear()
    {
        return $this->redis->flushAll();
    }
}
