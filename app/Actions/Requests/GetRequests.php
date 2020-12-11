<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\RequestsResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;
use App\Actions\Requests\DTO\FilterRequest;
use App\Models\Country;
use Illuminate\Database\Eloquent\Builder;

class GetRequests
{
	public function execute(FilterRequest $filter): RequestsResponse
	{
		$response = new RequestsResponse();

		$builder = QAndA::getTelegramRequests();
		$builder = $this->applyFilter($filter, $builder);
		
		$paginator = $builder->paginate(20);
		
		collect($paginator->items())
			->each(function (QAndA $data) use ($response) {
				$response->add(Request::fromEntity($data));
			});

		$response->setPaginator($paginator);
		
		return $response;
	}

	private function applyFilter(FilterRequest $filter, Builder $builder): Builder
	{
		if ($filter->category) {
			if ($filter->category === -1) {
				$builder->whereNull('question_category');
			} else {
				$builder->where('question_category', $filter->category);
			}
		}

		if ($filter->requests === 'my') {
			$builder->where(function ($query) {
				$query->whereNull('responsible_user_id')->orWhere('responsible_user_id', auth()->id());
			});
		}

		if ($filter->country) {
			$country = Country::find($filter->country);
			$this->applyCountry($country, $builder);
		}

		if ($filter->search) {
			$builder
				->whereRaw('LOWER(`user_question`) LIKE ? ', [
					'%' . trim(mb_strtolower($filter->search)) . '%'
				]);
		}

		return $builder;
	}

	private function applyCountry(Country $country, Builder $builder): Builder
	{
		$builder->where(function ($query) use ($country) {
			if ($country->name) {
				$query->orWhereRaw('LOWER(`country`) = ?', trim(mb_strtolower($country->name)));
			}

			if ($country->name_ru) {
				$query->orWhereRaw('LOWER(`country`) = ?', trim(mb_strtolower($country->name_ru)));
			}

			if ($country->name_en) {
				$query->orWhereRaw('LOWER(`country`) = ?', trim(mb_strtolower($country->name_en)));
			}
		});

		return $builder;
	}
}
