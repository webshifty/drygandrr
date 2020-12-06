<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\RequestsResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;
use App\Actions\Requests\DTO\FilterRequest;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;

class GetRequests
{
	public function execute(FilterRequest $filter): RequestsResponse
	{
		$response = new RequestsResponse();

		$builder = QAndA::getTelegramRequests();
		$builder = $this->applyFilter($filter, $builder);
		$builder->get()->each(function ($data) use ($response) {
			$response->add(new Request(
				(int)$data->id,
				(string)$data->user_question,
				(string)$data->tg_username,
				(int)$data->question_status,
				new Carbon($data->created_at),
				$data->question_category,
				$data->consul_answer,
				$data->country
			));
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
