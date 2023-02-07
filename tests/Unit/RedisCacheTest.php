<?php

namespace Tests\Unit;

use App\Util\RedisCache;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class RedisCacheTest extends TestCase
{

    public function test_shouldNotExists(){
        $redisCache = new RedisCache();
        $this->assertTrue(!$redisCache->exists('key',['id' => 1]));
    }

    public function test_shouldExists(){
        $redisCache = new RedisCache();
        $redisCache->save('key', ['data' => true] ,['id' => 0]);
        $this->assertTrue($redisCache->exists('key',['id' => 0]));
    }

    public function test_shouldSave(){
        $redisCache = new RedisCache();
        $redisCache->save('key', ['data' => true] ,['id' => 0]);
        $this->assertTrue($redisCache->exists('key',['id' => 0]));
    }
}
