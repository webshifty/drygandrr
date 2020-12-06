<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;

class UpdateRequest
{
	public function execute(Request $data): Request
	{
		$qa = QAndA::findOrFail($data->id);
        $qa->country = $data->country;
        $qa->question_status = $data->status;
        $qa->question_category = $data->category;
        $qa->consul_answer = $data->answer;
        $qa->save();

		return Request::fromEntity($qa);
	}
}
