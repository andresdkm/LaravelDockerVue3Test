<?php

namespace Modules\Football\Controllers;

use App\Http\Controllers\AppBaseController;
use Modules\Football\Services\MatchService;

class MatchesAPIController extends AppBaseController
{

    private $matchService;

    /**
     * @param MatchService $matchService
     */
    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }


    public function index($id, $date): \Illuminate\Http\JsonResponse
    {
        try {
            return $this->sendResponse($this->matchService->getAll([
                'competition_id' => $id,
                'date' => $date
            ]));
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }
    }
}
