<?php

namespace Modules\Football\Core\FootballClient\FootballData;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Modules\Football\Core\FootballClient\IFootballClient;
use Modules\Football\Model\CompetitionModel;
use Modules\Football\Model\MatchModel;

class FootballDataClientImpl implements IFootballClient
{

    private $baseUrl;

    private $token;

    public function __construct()
    {
        $this->baseUrl = env('FOOTBALL_DATA_API_HOST');
        $this->token = env('FOOTBALL_DATA_API_KEY');
    }


    /**
     * @return array
     * @throws \Exception
     */
    public function competitions(): array
    {
        $result = [];
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->token,
        ])->get($this->baseUrl . '/v4/competitions');

        if (!$response->ok()) {
            throw new \Exception('Http is not success ' . $response->reason());
        }
        $body = json_decode($response->body(), true);
        $competitions = array_filter($body['competitions'], function ($obj) {
            if (isset($obj['plan'])) {
                if ($obj['plan'] != 'TIER_ONE') return false;
            }
            return true;
        });
        foreach ($competitions as $index => $data) {
            $competition = new CompetitionModel();
            $competition->decode($data);
            $competition->id = $data['code'];
            $competition->end_date = $data['currentSeason']['endDate'];
            $result[] = $competition;
        }
        return $result;

    }


    /**
     * @param $id
     * @return object
     * @throws \Exception
     */
    public function competitionById($id): object
    {
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->token,
        ])->get($this->baseUrl . '/v4/competitions/' . $id);

        if (!$response->ok()) {
            throw new \Exception('Http is not success ' . $response->reason());
        }
        $body = json_decode($response->body(), true);
        $competition = new CompetitionModel();
        $competition->decode($body);
        $competition->id = $body['code'];
        $competition->end_date = $body['currentSeason']['endDate'];
        return $competition;
    }


    /**
     * @param string $competition
     * @param string $date
     * @return array
     * @throws \Exception
     */
    public function matches(string $competition, string $date): array
    {
        $result = [];
        $response = Http::withHeaders([
            'X-Auth-Token' => $this->token,
        ])->get($this->baseUrl . '/v4/competitions/' . $competition . '/matches', [
            'dateFrom' => $date,
            'dateTo' => $date
        ]);

        if (!$response->ok()) {
            throw new \Exception('Http is not success ' . $response->reason());
        }
        $body = json_decode($response->body(), true);
        foreach ($body['matches'] as $index => $data) {
            $math = new MatchModel();
            $math->decode($data);
            $math->date = Carbon::parse($data['utcDate'])->format('Y-m-d');
            $math->hour = Carbon::parse($data['utcDate'])->format('h:i:s A');
            $math->competition_id = $data['competition']['code'];
            $math->home_team = $data['homeTeam']['name'];
            $math->home_team_crest = $data['homeTeam']['crest'];
            $math->away_team = $data['awayTeam']['name'];
            $math->away_team_crest = $data['awayTeam']['crest'];
            $result[] = $math;
        }
        return $result;
    }

}
