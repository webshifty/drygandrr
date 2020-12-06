<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\RequestsResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;
use App\Actions\Requests\DTO\FilterRequest;
use Illuminate\Database\Eloquent\Builder;

class GetRequests
{
	public function execute(FilterRequest $filter): RequestsResponse
	{
		$response = new RequestsResponse();

		$builder = QAndA::getTelegramRequests();
		$builder = $this->applyFilter($filter, $builder);
		$builder->get()->each(function (QAndA $data) use ($response) {
			$response->add(Request::fromEntity($data));
		});

		return $response;
	}

	private function applyFilter(FilterRequest $filter, Builder $builder): Builder
	{
		if ($filter->search) {
			$builder
				->whereRaw('LOWER(`user_question`) LIKE ? ', [
					'%' . trim(strtolower($filter->search)) . '%'
				]);
		}

		return $builder;
	}
}
