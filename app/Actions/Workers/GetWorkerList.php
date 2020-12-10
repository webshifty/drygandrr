<?php

namespace App\Actions\Workers;

use App\Actions\Workers\DTO\WorkerItem;
use App\Actions\Workers\DTO\WorkerList;
use App\Models\User;

class GetWorkerList
{
	public function execute(): WorkerList
	{
		$response = new WorkerList();
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
				WorkerItem::fromUser($user)
			);
		});

		return $response;
	}
}
