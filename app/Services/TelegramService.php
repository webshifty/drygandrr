<?php

namespace App\Services;

use TuriBot\Client;

class TelegramService
{
	private $client;

	public function __construct(Client $client)
	{
		$this->client = $client;
	}

	public function sendMessage(int $chatId, string $message)
	{
		$this->client->sendMessage(
			$chatId,
			$message,
			null,
			null,
			null,
			null,
			null,
			null,
			null
		);
	}
}
