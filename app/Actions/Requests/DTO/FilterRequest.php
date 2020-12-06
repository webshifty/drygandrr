<?php

namespace App\Actions\Requests\DTO;

class FilterRequest
{
	public string $search;

	public function __construct(
		string $search
	)
	{
		$this->search = $search;
	}
}
