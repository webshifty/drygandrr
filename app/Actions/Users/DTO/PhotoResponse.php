<?php

namespace App\Actions\Users\DTO;

use App\Contracts\Response;

class PhotoResponse implements Response {
	private string $photo;
	
	public function __construct(string $photo)
	{
		$this->photo = $photo;
	}

	public function toArray(): array
	{
		return [
			'photo' => $this->photo,
		];
	}

	public function getMeta(): array
	{
		return [];
	}
}
