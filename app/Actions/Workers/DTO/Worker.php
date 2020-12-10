<?php

namespace App\Actions\Workers\DTO;

use App\Contracts\Arrayable;
use App\Models\User;

class Worker implements Arrayable
{
	public int $id;
	public string $name;
	public string $email;
	public string $countryName;
	public int $requestsCount;
	public ?string $photo;
	public ?bool $isOperator; 
	public ?bool $isAdmin;
	public ?int $country;

	public function __construct(
		int $id,
		string $name,
		string $email,
		string $countryName,
		?int $requestsCount = 0,
		?string $photo, 
		?bool $isOperator, 
		?bool $isAdmin,
		?int $country = null
	)
	{
		$this->id = $id;
		$this->name = $name;
		$this->email = $email;
		$this->countryName = $countryName;
		$this->requestsCount = $requestsCount;
		$this->photo = $photo;
		$this->isOperator = $isOperator;
		$this->isAdmin = $isAdmin;
		$this->country = $country;
	}

	public static function fromUser(User $user)
	{
		$countryName = $user->country->name ?? $user->country->name_ru ?? $user->country->name_en ?? '';

		return new self(
			$user->id,
			$user->name,
			$user->email,
			$countryName,
			$user->requests_count ?? 0,
			$user->profile_photo_url,
			$user->is_operator,
			$user->is_admin,
			$user->work_country,
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
