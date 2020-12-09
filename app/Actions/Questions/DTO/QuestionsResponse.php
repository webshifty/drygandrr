<?php

namespace App\Actions\Questions\DTO;

use App\Actions\General\BaseResponse;
use App\Contracts\Response;

class QuestionsResponse extends BaseResponse implements Response
{
	public function add(Question $question)
	{
		parent::addEntity($question);
	}
}
