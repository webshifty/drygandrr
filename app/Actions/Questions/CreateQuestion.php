<?php

namespace App\Actions\Questions;

use App\Actions\General\SingleResponse;
use App\Actions\Questions\DTO\Question;
use App\Models\Country;
use App\Models\Questions;
use Carbon\Carbon;

class CreateQuestion
{
	public function execute(Question $data, ?string $countryName = null): SingleResponse
	{
		if ($data->country === -1 && $countryName) {
			$country = new Country();
			$country->name = $countryName;
			$country->iso2 = '';
			$country->save();

			$data->country = $country->id;
		}

		$qa = new Questions();
        $qa->country = $data->country;
        $qa->category = $data->category;
        $qa->question = $data->question;
        $qa->answer = $data->answer;
        $qa->publish = $data->publish ? 1 : 0;
        $qa->created_at = Carbon::now();
        $qa->save();

		return new SingleResponse(
			new Question(
				$qa->id,
				$qa->country,
				$qa->category,
				$data->status,
				$qa->question,
				$qa->answer,
				(bool)$qa->publish
			)
		);
	}
}
