<?php

namespace App\Contracts;

interface Response extends Arrayable
{
	public function getMeta(): array;
}
