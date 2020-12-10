<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\RequestsResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;

class GetRequestsByWorker
{
	public function execute(int $workerId): RequestsResponse
	{
		$response = new RequestsResponse();

		$builder = QAndA::getTelegramRequests();
		$builder->where('responsible_user_id', $workerId)
			->get()
			->each(function (QAndA $data) use ($response) {
				$response->add(Request::fromEntity($data));
			});
		
		return $response;
	}
}
