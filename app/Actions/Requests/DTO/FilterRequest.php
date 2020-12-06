<?php

namespace App\Actions\Requests\DTO;

class FilterRequest
{
	public string $search;
	public int $category;
	public string $requests;

	public function __construct(
		string $search,
		int $category,
		string $requests
	)
	{
		$this->search = $search;
		$this->category = $category;
		$this->requests = $requests;
	}
}
