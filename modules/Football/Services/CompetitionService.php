<?php

namespace Modules\Football\Services;

use App\Util\RedisCache;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use Modules\Football\Core\FootballClient\IFootballClient;

class CompetitionService
{
    private $iFootballClient;

    private $redisCache;


    /**
     * @param IFootballClient $iFootballClient
     * @param RedisCache $redisCache
     */
    public function __construct(IFootballClient $iFootballClient, RedisCache $redisCache)
    {
        $this->iFootballClient = $iFootballClient;
        $this->redisCache = $redisCache;
    }


    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function getAll()
    {
        if ($this->redisCache->exists('competitions')) {
            return $this->redisCache->get('competitions');
        }
        try {
            $competitions = $this->iFootballClient->competitions();
            $this->redisCache->save('competitions', $competitions);
            return $competitions;
        } catch (\Exception $exception) {
            Log::error(get_class($this), ['error' => $exception->getMessage()]);
            throw new \Exception('CompetitionService');
        }
    }

    /**
     * @return array|mixed
     * @throws \Exception
     */
    public function queryByID(array $params)
    {

        if ($this->redisCache->exists('competitions',$params)) {
            return $this->redisCache->get('competitions', $params);
        }
        try {
            $competition = $this->iFootballClient->competitionById($params['id']);
            $end_date = Carbon::parse($competition->end_date)->format('Y-m-d');
            $competition->time_frames = [];
            for($i = 0; $i < 10; $i++){
                $day = Carbon::now()->addDays($i);
                if($day->lessThanOrEqualTo($end_date)){
                    $competition->time_frames[] = $day->format('Y-m-d');
                }
            }
            $this->redisCache->save('competitions', $competition, $params);
            return $competition;
        } catch (\Exception $exception) {
            Log::error(get_class($this), ['error' => $exception->getMessage()]);
            throw new \Exception('CompetitionService');
        }
    }

}
