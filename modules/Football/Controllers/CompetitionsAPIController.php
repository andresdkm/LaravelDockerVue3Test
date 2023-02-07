<?php

namespace Modules\Football\Controllers;

use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Redis;
use Modules\Football\Core\FootballClient\IFootballClient;
use Modules\Football\Services\CompetitionService;

class CompetitionsAPIController extends AppBaseController
{

    private $competitionsService;

    /**
     * @param CompetitionService $competitionsService
     */
    public function __construct(CompetitionService $competitionsService)
    {
        $this->competitionsService = $competitionsService;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->sendResponse($this->competitionsService->getAll());
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }

    public function show($id): \Illuminate\Http\JsonResponse
    {

        try {
            return $this->sendResponse($this->competitionsService->queryByID([
                'id' => $id
            ]));
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

    }

}
