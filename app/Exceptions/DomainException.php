<?php

namespace App\Exceptions;

class DomainException extends \Exception
{
	protected int $status;

	public function __construct(string $message, int $status = 400)
	{
		parent::__construct($message);
	
		$this->status = $status;
	}

	public function render()
	{
		return response()->json([
			'message' => parent::getMessage(),
		], $this->status);
	}
}
