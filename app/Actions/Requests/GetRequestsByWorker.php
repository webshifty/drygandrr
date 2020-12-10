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

		$paginator = QAndA::getTelegramRequests()
			->where('responsible_user_id', $workerId)
			->paginate(20);
		collect($paginator->items())
			->each(function (QAndA $data) use ($response) {
				$response->add(Request::fromEntity($data));
			});
		
		$response->setPaginator($paginator);

		return $response;
	}
}
