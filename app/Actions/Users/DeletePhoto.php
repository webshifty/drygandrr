<?php

namespace App\Actions\Users;

use App\Actions\Users\DTO\PhotoResponse;
use App\Models\User;

class DeletePhoto
{
	public function execute(int $userId): PhotoResponse
	{
		$user = User::findOrFail($userId);
		$user->deleteProfilePhoto();

		return new PhotoResponse($user->getProfilePhotoUrlAttribute());
	}
}
