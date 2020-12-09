<?php

namespace App\Actions\Requests\DTO;

class FilterRequest
{
	public string $search;
	public int $category;
	public string $requests;
	public int $country;

	public function __construct(
		string $search,
		int $category,
		string $requests,
		int $country
	)
	{
		$this->search = $search;
		$this->category = $category;
		$this->requests = $requests;
		$this->country = $country;
	}
}
