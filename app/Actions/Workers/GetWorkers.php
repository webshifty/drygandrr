<?php

namespace App\Actions\Workers;

use App\Actions\Workers\DTO\FilterWorker;
use App\Actions\Workers\DTO\WorkersResponse;
use App\Actions\Workers\DTO\Worker;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;

class GetWorkers
{
	public function execute(FilterWorker $filter): WorkersResponse
	{
		$response = new WorkersResponse();
		$userBuilder = User::select([
			'id',
			'name',
			'email',
			'work_country',
		])
		->where('access', User::ACCESS_OPERATOR);
		$userBuilder = $this->applyFilter($filter, $userBuilder);

		$userBuilder
		->with('country')
		->withCount('requests')
		->orderBy('name')
		->get()
		->each(function ($user) use ($response) {
			$response->add(
				Worker::fromUser($user)
			);
		});

		$countOfUsers = $userBuilder->count();
		$response->addMeta('total', $countOfUsers);
		
		return $response;
	}

	private function applyFilter(FilterWorker $filter, Builder $builder): Builder
	{
		if ($filter->country) {
			$builder->where('work_country', $filter->country);
		}

		if ($filter->search) {
			$builder
				->whereRaw('LOWER(`name`) LIKE ? ', [
					'%' . trim(mb_strtolower($filter->search)) . '%'
				]);
		}

		return $builder;
	}
}
