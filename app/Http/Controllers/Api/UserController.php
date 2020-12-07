<?php

namespace App\Http\Controllers\Api;

use App\Actions\Users\DTO\PhotoResponse;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
	public function uploadPhoto(Request $request)
	{
		if (!$request->hasFile('image')) {
			return response()->json([ 'message' => 'there is no file' ], 402);
		}

		if (!$request->file('image')->isValid()) {
			return response()->json([ 'message' => 'file is invalid image' ], 402);
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
}
