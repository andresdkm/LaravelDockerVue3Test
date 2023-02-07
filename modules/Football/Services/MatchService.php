<?php

namespace Modules\Football\Services;

use App\Util\DatabaseCache;
use App\Util\RedisCache;
use Illuminate\Support\Facades\Log;
use Modules\Football\Core\FootballClient\IFootballClient;

class MatchService
{

    private $iFootballClient;

    private $databaseCache;


    /**
     * @param IFootballClient $iFootballClient
     */
    public function __construct(IFootballClient $iFootballClient, DatabaseCache $databaseCache)
    {
        $this->iFootballClient = $iFootballClient;
        $this->databaseCache = $databaseCache;
    }


    /**
     * @throws \Exception
     */
    public function getAll(array $params)
    {
        try {
            if ($this->databaseCache->exists('matches', $params)) {
                return $this->databaseCache->get('matches', $params);
            }
            $matches = $this->iFootballClient->matches($params['competition_id'], $params['date']);
            $this->databaseCache->save('matches', array_map(function ($match){
                return $match->toArray();
            }, $matches));
            return $matches;
        } catch (\Exception $exception) {
            Log::error(get_class($this), ['error' => $exception->getMessage()]);
            throw new \Exception('MatchService');
        }
    }
}
