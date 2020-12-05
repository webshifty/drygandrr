<?php

namespace App\Actions\Questions\DTO;

class FilterQuestion
{
	public ?int $country;
	public ?int $category;
	public string $search;

	public function __construct(
		?int $country,
		?int $category,
		string $search
	)
	{
		$this->country = $country;
		$this->category = $category;
		$this->search = $search;
	}
}
