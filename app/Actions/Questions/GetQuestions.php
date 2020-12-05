<?php

namespace App\Actions\Questions;

use App\Actions\Questions\DTO\QuestionsResponse;
use App\Actions\Questions\DTO\Question;
use App\Models\QAndA;
use App\Actions\Questions\DTO\FilterQuestion;
use Illuminate\Database\Query\Builder;

class GetQuestions
{
	public function execute(FilterQuestion $filter): QuestionsResponse
	{
		$response = new QuestionsResponse();

		$questionsBuilder = QAndA::questionsBuilder();
		$questionsBuilder = $this->applyFilter($filter, $questionsBuilder);
		$questionsBuilder->get()->each(function ($data) use ($response) {
			$response->add(new Question(
				(int)$data->id,
				(int)$data->country,
				(int)$data->category,
				'',
				(string)$data->question,
				(string)$data->answer,
				(bool)$data->publish,
			));
		});

		return $response;
	}

	private function applyFilter(FilterQuestion $filter, Builder $questionsBuilder): Builder
	{
		if ($filter->country) {
			$questionsBuilder->where('country', '=', $filter->country);
		}

		if ($filter->category) {
			$questionsBuilder->where('category', '=', $filter->category);
		}

		if ($filter->search) {
			$questionsBuilder
				->whereRaw('LOWER(`question`) LIKE ? ', [
					'%' . trim(strtolower($filter->search)) . '%'
				])
				->orWhereRaw('LOWER(`answer`) LIKE ? ', [
					'%' . trim(strtolower($filter->search)) . '%'
				]);
		}

		$result = $questionsBuilder->toSql();

		return $questionsBuilder;
	}
}
