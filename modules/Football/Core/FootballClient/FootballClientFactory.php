<?php

namespace Modules\Football\Core\FootballClient;

abstract class FootballClientFactory
{

    public static function make(string $provider): IFootballClient
    {
        return new FootballData\FootballDataClientImpl();
    }

}
