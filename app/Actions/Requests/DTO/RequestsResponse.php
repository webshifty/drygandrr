<?php

namespace App\Actions\Requests\DTO;

use App\Contracts\Response;

class RequestsResponse implements Response
{
	public array $requests = [];

	public function add(Request $request)
	{
		$this->requests[] = $request;
	}

	public function toArray(): array
	{
		return collect($this->requests)->map(function (Request $request) {
			return $request->toArray();
		})->toArray();
	}
}
