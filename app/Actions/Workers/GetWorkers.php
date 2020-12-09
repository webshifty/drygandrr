<?php

namespace App\Actions\Workers;

use App\Actions\Workers\DTO\WorkersResponse;
use App\Actions\Workers\DTO\Worker;
use App\Models\User;

class GetWorkers
{
	public function execute(): WorkersResponse
	{
		$response = new WorkersResponse();

		User::select([
			'id',
			'name',
			'work_country',
		])
		->where('access', User::ACCESS_OPERATOR)
		->orderBy('name')
		->get()
		->each(function ($user) use ($response) {
			$response->add(
				Worker::fromUser($user)
			);
		});
		
		return $response;
	}
}
