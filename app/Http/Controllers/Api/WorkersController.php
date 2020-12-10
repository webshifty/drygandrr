<?php

namespace App\Http\Controllers\Api;

use App\Actions\Requests\GetRequestsByWorker;
use App\Actions\Users\DeletePhoto;
use App\Actions\Users\UploadPhoto;
use App\Actions\Workers\DeleteWorker;
use App\Actions\Workers\DTO\FilterWorker;
use App\Actions\Workers\DTO\UpdateWorkerPayload;
use App\Actions\Workers\GetWorker;
use App\Actions\Workers\GetWorkerList;
use App\Actions\Workers\GetWorkers;
use App\Actions\Workers\UpdateWorker;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WorkersController extends Controller
{
	public function getWorkerList(GetWorkerList $getWorkerList)
	{
		return $this->success(
			$getWorkerList->execute()
		);
	}

	public function getWorkers(Request $request, GetWorkers $getWorkers)
	{
		$filter = $request->input('filter') ?? [];

		$response = $getWorkers->execute(
			new FilterWorker(
				(string)$filter['search'],
				(int)$filter['country'],
			)
		);

		return $this->success($response);
	}

	public function getRequests(int $workerId, GetRequestsByWorker $getRequests)
	{
		$response = $getRequests->execute($workerId);

		return $this->success($response);
	}

	public function getWorker(int $workerId, GetWorker $getWorker)
	{
		$response = $getWorker->execute($workerId);

		return $this->success($response);
	}

	public function uploadPhoto(Request $request, int $workerId, UploadPhoto $uploadPhoto)
	{
		return $this->success(
			$uploadPhoto->execute($request, $workerId)
		);
	}

	public function deletePhoto(int $workerId, DeletePhoto $deletePhoto)
	{
		return $this->success(
			$deletePhoto->execute($workerId)
		);
	}

	public function updateWorker(Request $request, int $workerId, UpdateWorker $updateWorker)
	{
		return $this->success(
			$updateWorker->execute(
				new UpdateWorkerPayload(
					$workerId,
					(int)$request->input('access'),
					(int)$request->input('country'),
					$request->input('email'),
					$request->input('name'),
				),
			),
		);
	}

	public function deleteWorker(int $workerId, DeleteWorker $deleteWorker)
	{
		$deleteWorker->execute($workerId);

		return $this->empty();
	}
}
