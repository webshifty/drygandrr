<?php

namespace App\Actions\Questions;

use App\Actions\Questions\DTO\QuestionsResponse;
use App\Actions\Questions\DTO\Question;
use App\Models\QAndA;

class GetQuestions
{
	public function execute(): QuestionsResponse
	{
		$response = new QuestionsResponse();

		$questions = QAndA::getAllQuestions();
		$questions->each(function ($data) use ($response) {
			$response->add(new Question(
				(int)$data->id,
				(string)$data->country,
				(string)$data->category,
				'',
				(string)$data->question,
				(string)$data->answer,
			));
		});

		return $response;
	}
}
