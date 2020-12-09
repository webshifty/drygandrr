<?php

namespace App\Actions\General;

use App\Contracts\Arrayable;

abstract class BaseResponse
{
	protected array $entities = [];
	protected array $meta = [];

	protected function addEntity(Arrayable $entity): void
	{
		$this->entities[] = $entity;
	}

	public function addMeta(string $key, $value): void
	{
		$this->meta[$key] = $value;
	}

	public function toArray(): array
	{
		return collect($this->entities)->map(function (Arrayable $entity) {
			return $entity->toArray();
		})->toArray();
	}

	public function getMeta(): array
	{
		return $this->meta;
	}
}
