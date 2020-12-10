<?php

namespace App\Actions\Workers\DTO;

class UpdateWorkerPayload
{
	public int $id;
	public int $access;
	public int $country;
	public string $email;
	public string $name;

	public function __construct(
		int $id,
		int $access,
		int $country,
		string $email,
		string $name
	)
	{
		$this->id = $id;
		$this->access = $access;
		$this->country = $country;
		$this->email = $email;
		$this->name = $name;
	}
}
