<?php

namespace App\Actions\Requests\DTO;

class Responsible
{
	public int $id;
	public string $name;

	public function __construct(
		int $id,
		string $name
	) {
		$this->id = $id;
		$this->name = $name;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
		];
	}
}
