<?php

namespace Tests\Unit;

use App\Util\DatabaseCache;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseCacheTest extends TestCase
{

    use RefreshDatabase;

    private function save()
    {
        DB::table('matches')->insert([
            'id' => 0,
            'date' => '2023-02-03',
            'hour' => '07:30:00 PM',
            'status' => 'FINISHED',
            'competition_id' => 'BL1',
            'home_team' => 'HOME',
            'home_team_crest' => 'HOME',
            'away_team' => 'AWAY',
            'away_team_crest' => 'AWAY',
        ]);
    }


    public function test_shouldNotExists(){
        $databaseCache = new DatabaseCache();
        $this->assertTrue(!$databaseCache->exists('matches',['id' => 1]));
    }

    public function test_shouldExists(){
        $databaseCache = new DatabaseCache();
        $this->save();
        $this->assertTrue($databaseCache->exists('matches',['id' => 0]));
    }

}
