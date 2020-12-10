<?php

namespace App\Actions\Workers;

use App\Actions\General\SingleResponse;
use App\Actions\Workers\DTO\Worker;
use App\Models\User;

class GetWorker
{
	public function execute(int $workerId): SingleResponse
	{
		$worker = User::select([
			'*'
		])
		->where('id', $workerId)->first();

		return new SingleResponse(
			Worker::fromUser($worker),
		);
	}
}
