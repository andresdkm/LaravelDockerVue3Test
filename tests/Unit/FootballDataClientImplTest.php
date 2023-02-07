<?php

namespace Tests\Football\Core\FootballClient\FootballData;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Modules\Football\Core\FootballClient\FootballData\FootballDataClientImpl;
use Modules\Football\Model\CompetitionModel;
use Modules\Football\Model\MatchModel;
use Tests\TestCase;

class FootballDataClientImplTest extends TestCase
{


    public function test_shouldListCompetitions()
    {

        $expected = new CompetitionModel();
        $expected->id= 'QCAF';
        $expected->name= 'WC Qualification CAF';
        $expected->type= 'CUP';
        $expected->emblem= null;
        $expected->end_date= '2023-12-12';

        Http::fake([
            env('FOOTBALL_DATA_API_HOST').'/*' => Http::response([
                "count" => 1,
                "filters" => [],
                "competitions" => [
                    [
                        "id" => 1,
                        "area" => [
                            "id" => 1,
                            "name" => "Africa",
                            "code" => "AFR",
                            "flag" => null,
                        ],
                        "name" => "WC Qualification CAF",
                        "code" => "QCAF",
                        "type" => "CUP",
                        "emblem" => null,
                        "plan" => "TIER_ONE",
                        "currentSeason" => [
                            "id" => 555,
                            "startDate" => "2019-09-04",
                            "endDate" => "2023-12-12",
                            "currentMatchday" => 1,
                            "winner" => null,
                        ],
                        "numberOfAvailableSeasons" => 1,
                        "lastUpdated" => "",
                    ],
                ],
            ], 200, []),
        ]);

        $clientImpl = new FootballDataClientImpl();
        $response = $clientImpl->competitions();
        $this->assertEquals( $expected, $response[0]);
    }

    public function test_shouldGetCompetition()
    {

        $expected = new CompetitionModel();
        $expected->id= 'QCAF';
        $expected->name= 'WC Qualification CAF';
        $expected->type= 'CUP';
        $expected->emblem= null;
        $expected->end_date= '2023-12-12';
        Http::fake([
            env('FOOTBALL_DATA_API_HOST').'/*' => Http::response([
                "id" => 1,
                "area" => [
                    "id" => 1,
                    "name" => "Africa",
                    "code" => "AFR",
                    "flag" => null,
                ],
                "name" => "WC Qualification CAF",
                "code" => "QCAF",
                "type" => "CUP",
                "emblem" => null,
                "plan" => "TIER_ONE",
                "currentSeason" => [
                    "id" => 555,
                    "startDate" => "2019-09-04",
                    "endDate" => "2023-12-12",
                    "currentMatchday" => 1,
                    "winner" => null,
                ],
                "numberOfAvailableSeasons" => 1,
                "lastUpdated" => "",
            ], 200, []),
        ]);

        $clientImpl = new FootballDataClientImpl();
        $response = $clientImpl->competitionById('QCAF');
        $this->assertEquals( $expected, $response);
    }

    public function test_shouldListMatches()
    {

        $expected = new MatchModel();
        $expected->id= 416530;
        $expected->date= '2023-02-03';
        $expected->hour= '07:30:00 PM';
        $expected->status= 'FINISHED';
        $expected->competition_id= 'BL1';
        $expected->home_team= 'FC Augsburg';
        $expected->home_team_crest= 'https://crests.football-data.org/16.svg';
        $expected->away_team= 'Bayer 04 Leverkusen';
        $expected->away_team_crest= 'https://crests.football-data.org/3.png';
        Http::fake([
            env('FOOTBALL_DATA_API_HOST').'/*' => Http::response([
                "filters" => ["season" => "2022"],
                "resultSet" => [
                    "count" => 1,
                    "first" => "2023-02-03",
                    "last" => "2023-02-03",
                    "played" => 1,
                ],
                "competition" => [
                    "id" => 2002,
                    "name" => "Bundesliga",
                    "code" => "BL1",
                    "type" => "LEAGUE",
                    "emblem" => "https://crests.football-data.org/BL1.png",
                ],
                "matches" => [
                    [
                        "area" => [
                            "id" => 2088,
                            "name" => "Germany",
                            "code" => "DEU",
                            "flag" => "https://crests.football-data.org/759.svg",
                        ],
                        "competition" => [
                            "id" => 2002,
                            "name" => "Bundesliga",
                            "code" => "BL1",
                            "type" => "LEAGUE",
                            "emblem" => "https://crests.football-data.org/BL1.png",
                        ],
                        "season" => [
                            "id" => 1495,
                            "startDate" => "2022-08-05",
                            "endDate" => "2023-05-27",
                            "currentMatchday" => 19,
                            "winner" => null,
                        ],
                        "id" => 416530,
                        "utcDate" => "2023-02-03T19:30:00Z",
                        "status" => "FINISHED",
                        "matchday" => 19,
                        "stage" => "REGULAR_SEASON",
                        "group" => null,
                        "lastUpdated" => "2023-02-07T16:20:07Z",
                        "homeTeam" => [
                            "id" => 16,
                            "name" => "FC Augsburg",
                            "shortName" => "Augsburg",
                            "tla" => "FCA",
                            "crest" => "https://crests.football-data.org/16.svg",
                        ],
                        "awayTeam" => [
                            "id" => 3,
                            "name" => "Bayer 04 Leverkusen",
                            "shortName" => "Leverkusen",
                            "tla" => "B04",
                            "crest" => "https://crests.football-data.org/3.png",
                        ],
                        "score" => [
                            "winner" => "HOME_TEAM",
                            "duration" => "REGULAR",
                            "fullTime" => ["home" => 1, "away" => 0],
                            "halfTime" => ["home" => 0, "away" => 0],
                        ],
                        "odds" => [
                            "msg" =>
                                "Activate Odds-Package in User-Panel to retrieve odds.",
                        ],
                        "referees" => [
                            [
                                "id" => 15821,
                                "name" => "Marco Fritz",
                                "type" => "REFEREE",
                                "nationality" => "Germany",
                            ],
                        ],
                    ],
                ],
            ], 200, []),
        ]);

        $clientImpl = new FootballDataClientImpl();
        $response = $clientImpl->matches('BL1', Carbon::now()->format('Y-m-d'));
        $this->assertEquals( $expected, $response[0]);
    }
}
