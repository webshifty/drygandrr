<?php

namespace App\Actions\Workers\DTO;

class FilterWorker
{
	public string $search;
	public int $country;

	public function __construct(
		string $search,
		int $country
	)
	{
		$this->search = $search;
		$this->country = $country;
	}
}
