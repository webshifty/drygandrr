<?php

namespace App\Http\Controllers;

use App\Contracts\Response;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success(Response $response)
    {
        return response()->json([
            'data' => $response->toArray(),
        ]);
    }

    public function error(string $message)
    {
        return response()->json([
            'message' => $message,
        ], 400);
    }

    public function empty()
    {
        return response()->json([
            'data' => [],
        ]);
    }
}
