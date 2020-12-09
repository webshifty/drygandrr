<?php

namespace App\Http\Controllers\Api;

use App\Actions\Requests\GetRequestsByWorker;
use App\Actions\Workers\DTO\FilterWorker;
use App\Actions\Workers\GetWorker;
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

	public function getRequests(Request $request, int $workerId, GetRequestsByWorker $getRequests)
	{
		$user = $request->user();

		if (!$user->is_admin) {
			return $this->empty();
		}

		$response = $getRequests->execute($workerId);

		return $this->success($response);
	}

	public function getWorker(Request $request, int $workerId, GetWorker $getWorker)
	{
		$user = $request->user();
		if (!$user->is_admin) {
			return $this->empty();
		}

		$response = $getWorker->execute($workerId);

		return $this->success($response);
	}
}
