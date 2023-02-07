<?php

namespace Modules\Football\Model;

class MatchModel extends FootballBaseModel
{
    public $id;
    public $date;
    public $hour;
    public $status;
    public $competition_id;
    public $home_team;
    public $home_team_crest;
    public $away_team;
    public $away_team_crest;

}
