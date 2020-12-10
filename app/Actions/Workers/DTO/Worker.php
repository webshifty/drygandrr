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
	public ?string $photo;
	public ?bool $isOperator; 
	public ?bool $isAdmin;

	public function __construct(
		int $id,
		int $country,
		string $name,
		string $email,
		string $countryName,
		?int $requestsCount = 0,
		?string $photo, 
		?bool $isOperator, 
		?bool $isAdmin 
	)
	{
		$this->id = $id;
		$this->country = $country;
		$this->name = $name;
		$this->email = $email;
		$this->countryName = $countryName;
		$this->requestsCount = $requestsCount;
		$this->photo = $photo;
		$this->isOperator = $isOperator;
		$this->isAdmin = $isAdmin;
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
			$user->requests_count ?? 0,
			$user->profile_photo_url,
			$user->is_operator,
			$user->is_admin,
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
			'photo' => $this->photo,
			'is_operator' => $this->isOperator,
			'is_admin' => $this->isAdmin,
		];
	}
}
