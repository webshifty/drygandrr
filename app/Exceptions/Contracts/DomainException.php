<?php

namespace App\Exceptions\Contracts;

interface DomainException
{
	public function getMessage(): string;
}
