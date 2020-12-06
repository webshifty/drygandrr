<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Requests\UpdateRequest;
use App\Actions\Requests\DTO\Request as UserRequest;
use App\Actions\Requests\GetRequests;
use App\Actions\Requests\DTO\FilterRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    public function requests(Request $request, GetRequests $getRequests)
    {
        $filterData = $request->input('filter') ?? [];
        $requests = $getRequests->execute(
            new FilterRequest(
                $filterData['search'] ?? '',
            )
        );

        return $this->success($requests);
    }

    public function updateRequest(Request $request, int $id, UpdateRequest $updateRequest)
    {
        $response = $updateRequest->execute(
            new UserRequest(
                $id,
                (string)$request->input('question'),
                '',
                (int)$request->input('status'),
                Carbon::now(),
                (int)$request->input('category'),
                trim((string)$request->input('answer')),
                trim((string)$request->input('countryName'))
            )
        );

        return $this->success($response);
    }
}
