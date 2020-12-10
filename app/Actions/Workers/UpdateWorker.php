<?php

namespace App\Actions\Workers;

use App\Actions\General\SingleResponse;
use App\Actions\Workers\DTO\UpdateWorkerPayload;
use App\Actions\Workers\DTO\Worker;
use App\Actions\Workers\Exceptions\WorkerException;
use App\Models\User;

class UpdateWorker
{
	public function execute(UpdateWorkerPayload $payload): SingleResponse
	{
		$worker = User::findOrFail($payload->id);

		if (!$worker) {
			throw new WorkerException('Працівника не знайдено', 404);
		}

		$worker->name = $payload->name;
		$worker->email = $payload->email;
		$worker->work_country = $payload->country;
		$worker->access = $payload->access;
		$worker->save();

		return new SingleResponse(
			Worker::fromUser($worker),
		);
	}
}
