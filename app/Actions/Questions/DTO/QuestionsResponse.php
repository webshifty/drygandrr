<?php

namespace App\Actions\Questions\DTO;

use App\Contracts\Response;

class QuestionsResponse implements Response
{
	public array $questions = [];

	public function add(Question $question)
	{
		$this->questions[] = $question;
	}

	public function toArray(): array
	{
		return collect($this->questions)->map(function (Question $question) {
			return $question->toArray();
		})->toArray();
	}
}
