<?php

namespace App\Http\Controllers\Api;

use App\Actions\Workers\GetWorkers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
	public function getWorkers(Request $request, GetWorkers $getWorkers)
	{
		$user = $request->user();

		if (!$user->is_admin) {
			return $this->empty();
		}

		$response = $getWorkers->execute();

		return $this->success($response);
	}
}
