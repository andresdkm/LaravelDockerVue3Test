<?php

namespace Modules\Football\Core\FootballClient;

interface IFootballClient
{

    /**
     * @return array
     */
    public function competitions(): array;

    /**
     * @param $id
     * @return object
     */
    public function competitionById($id): object;

    /**
     * @param string $competition
     * @param string $date
     * @return array
     */
    public function matches(string $competition, string $date): array;

}
