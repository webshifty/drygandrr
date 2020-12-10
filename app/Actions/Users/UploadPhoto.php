<?php

namespace App\Actions\Users;

use App\Actions\Users\DTO\PhotoResponse;
use App\Actions\Users\Exceptions\InvalidPhotoException;
use App\Models\User;
use Illuminate\Http\Request;

class UploadPhoto
{
	public function execute(Request $request, int $userId): PhotoResponse
	{
		if (!$request->hasFile('image')) {
			throw new InvalidPhotoException('there is no file');
		}

		if (!$request->file('image')->isValid()) {
			throw new InvalidPhotoException('file is an invalid image');
		}

		$request->validate([
			'image' => 'mimes:jpeg,png|max:4096',
		]);

		$user = User::findOrFail($userId);
		$user->updateProfilePhoto($request->image);

		return new PhotoResponse($user->getProfilePhotoUrlAttribute());
	}
}
