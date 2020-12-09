<?php

namespace App\Actions\Requests;

use App\Actions\General\SingleResponse;
use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;
use App\Models\User;

class AssignResponsible
{
	public function execute(int $requestId, int $userId): SingleResponse
	{
		$user = User::findOrFail($userId);
		$qa = QAndA::findOrFail($requestId);
		$qa->responsible_user_id = $user->id;
		$qa->save();

		return new SingleResponse(
			Request::fromEntity(
				QAndA::find($requestId)
			)
		);
	}
}
