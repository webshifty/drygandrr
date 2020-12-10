<?php

namespace App\Actions\Workers\DTO;

use App\Contracts\Arrayable;
use App\Models\User;

class WorkerItem implements Arrayable
{
	public int $id;
	public int $country;
	public string $name;

	public function __construct(
		int $id,
		int $country,
		string $name
	)
	{
		$this->id = $id;
		$this->country = $country;
		$this->name = $name;
	}

	public static function fromUser(User $user)
	{
		return new self(
			$user->id,
			$user->work_country,
			$user->name,
		);
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'country' => $this->country,
			'name' => $this->name,
		];
	}
}
