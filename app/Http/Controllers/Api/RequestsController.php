<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
// use App\Actions\Requests\UpdateRequest;
// use App\Actions\Requests\DTO\Request as UserRequest;
use App\Actions\Requests\GetRequests;
use App\Actions\Requests\DTO\FilterRequest;
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

    public function updateRequest(Request $request, int $id)
    {
        // $response = $updateQuestion->execute(
        //     new UserRequest(
        //         (int)$id,
        //         (int)$request->input('country'),
        //         (int)$request->input('category'),
        //         '',
        //         trim((string)$request->input('question')),
        //         trim((string)$request->input('answer')),
        //         (int)$request->input('publish'),
        //     )
        // );

        // return $this->success($response);
    }
}
