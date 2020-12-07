<?php

namespace App\Http\Controllers\Api;

use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Users\DTO\PhotoResponse;
use App\Actions\Users\DTO\UserInfoResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
	public function uploadPhoto(Request $request)
	{
		if (!$request->hasFile('image')) {
			return $this->error('there is no file');
		}

		if (!$request->file('image')->isValid()) {
			return $this->error('file is invalid image');
		}

		$request->validate([
			'image' => 'mimes:jpeg,png|max:4096',
		]);
		$extension = $request->image->extension();
		$name = uniqid();
		$request->image->storeAs('/public', $name.".".$extension);
		$url = $name.".".$extension;
		$user = User::find(auth()->id());

		if ($user->profile_photo_path) {
			Storage::delete($user->profile_photo_path);
		}

		$user->profile_photo_path = $url;
		$user->save();

		return $this->success(new PhotoResponse($url));
	}

	public function deletePhoto()
	{
		$user = User::find(auth()->id());
		Storage::delete($user->profile_photo_path);
		$user->profile_photo_path = null;
		$user->save();

		return $this->empty();
	}

	public function updateUser(Request $request, UpdateUserPassword $updatePassword)
	{
		$request->validate([
			'name' => 'required',
			'email' => 'required|email',
			'work_country' => 'required|exists:countries,id',
		]);

		$user = User::find(auth()->id());

		if ($request->input('password') && $request->input('current_password') && $request->input('password_confirmation')) {
			$updatePassword->update($user, [
				'password' => $request->input('password'),
				'current_password' => $request->input('current_password'),
				'password_confirmation' => $request->input('password_confirmation'),
			]);
		}

		$user->name = $request->input('name');
		$user->email = $request->input('email');
		$user->work_country = $request->input('work_country');

		$user->save();

		return $this->success(
			new UserInfoResponse(
				User::getUserInfoById($user->id)
			)
		);
	}
}
