<?php

namespace App\Actions\Requests;

use App\Actions\General\SingleResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;

class AssignResponsible
{
	public function execute(int $requestId, ?int $userId = null): SingleResponse
	{
		$qa = QAndA::findOrFail($requestId);
		$qa->responsible_user_id = $userId;
		$qa->save();

		return new SingleResponse(
			Request::fromEntity(
				QAndA::find($requestId)
			)
		);
	}
}
