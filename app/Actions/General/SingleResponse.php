<?php

namespace App\Actions\General;

use App\Contracts\Arrayable;
use App\Contracts\Response;

class SingleResponse implements Response
{
	public Arrayable $entity;

	public function __construct(Arrayable $entity)
	{
		$this->entity = $entity;
	}

	public function toArray(): array
	{
		return $this->entity->toArray();
	}

	public function getMeta(): array
	{
		return [];
	}
}
