<?php

namespace App\Http\Controllers\Api;

use App\Actions\Workers\DTO\FilterWorker;
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
		$filter = $request->input('filter') ?? [];

		$response = $getWorkers->execute(
			new FilterWorker(
				(string)$filter['search'],
				(int)$filter['country'],
			)
		);

		return $this->success($response);
	}
}
