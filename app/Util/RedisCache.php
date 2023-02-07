<?php

namespace App\Util;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class RedisCache
{

    /**
     * @param string $table
     * @param array $params
     * @return bool
     */
    public function exists(string $table, array $params = array()): bool
    {
        $flattened = $params;
        array_walk($flattened, function(&$value, $key) {
            $value = "{$key}_{$value}";
        });
        $key = $table . '_' . implode('_', $flattened);
        return Redis::exists($key) == 1;
    }

    /**
     * @param $table
     * @param array $params
     * @return mixed
     */
    public function get(string $table, array $params = array())
    {
        $flattened = $params;
        array_walk($flattened, function(&$value, $key) {
            $value = "{$key}_{$value}";
        });
        $key = $table . '_' . implode('_', $flattened);
        return json_decode(Redis::get($key));
    }

    /**
     * @param $class
     * @param $data
     * @param array $params
     * @return void
     */
    public function save(string $table, $data, array $params = array())
    {
        $flattened = $params;
        array_walk($flattened, function(&$value, $key) {
            $value = "{$key}_{$value}";
        });
        $key = $table. '_' . implode('_', $flattened);
        Redis::set($key, json_encode($data), 'EX', 3600);
    }
}
