<?php

namespace App\Actions\General;

use App\Contracts\Arrayable;

abstract class BaseResponse
{
	protected array $entities = [];

	protected function addEntity(Arrayable $entity)
	{
		$this->entities[] = $entity;
	}

	public function toArray(): array
	{
		return collect($this->entities)->map(function (Arrayable $entity) {
			return $entity->toArray();
		})->toArray();
	}
}
