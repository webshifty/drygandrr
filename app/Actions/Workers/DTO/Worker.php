<?php

namespace App\Actions\Workers\DTO;

use App\Contracts\Arrayable;
use App\Models\User;

class Worker implements Arrayable
{
	public int $id;
	public int $country;
	public string $name;
	public string $email;
	public string $countryName;
	public int $requestsCount;

	public function __construct(
		int $id,
		int $country,
		string $name,
		string $email,
		string $countryName,
		?int $requestsCount = 0
	)
	{
		$this->id = $id;
		$this->country = $country;
		$this->name = $name;
		$this->email = $email;
		$this->countryName = $countryName;
		$this->requestsCount = $requestsCount;
	}

	public static function fromUser(User $user)
	{
		$countryName = $user->country->name ?? $user->country->name_ru ?? $user->country->name_en ?? '';

		return new self(
			$user->id,
			$user->work_country,
			$user->name,
			$user->email,
			$countryName,
			$user->requests_count,
		);
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'country' => $this->country,
			'name' => $this->name,
			'email' => $this->email,
			'countryName' => $this->countryName,
			'requests_count' => $this->requestsCount,
		];
	}
}
