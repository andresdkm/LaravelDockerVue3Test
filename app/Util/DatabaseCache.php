<?php

namespace App\Util;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class DatabaseCache
{

    public function exists(string $table, array $params = array()): bool
    {
        $count = DB::table($table)->where($params)->count();
        return $count > 0;
    }


    public function get(string $table, array $params = array()): array
    {
        return DB::table($table)->where($params)->get()->toArray();
    }


    public function save(string $table, array $data)
    {
        $columns = DB::getSchemaBuilder()->getColumnListing($table);
        if(count($columns)>0){
            $filteredData = array_filter(
                $data,
                function($k) use ($columns) {
                    return array_key_exists($k, $columns);
                }, ARRAY_FILTER_USE_KEY
            );
        }else{
            $filteredData = $data;
        }
        DB::table($table)->insert($filteredData);
    }
}
