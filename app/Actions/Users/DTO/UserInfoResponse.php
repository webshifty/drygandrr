<?php

namespace App\Actions\Users\DTO;

use App\Contracts\Response;
use App\Models\User;

class UserInfoResponse implements Response {
	private User $user;
	
	public function __construct(User $user)
	{
		$this->user = $user;
	}

	public function toArray(): array
	{
		return $this->user->toArray();
	}
}
