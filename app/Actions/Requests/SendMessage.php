<?php

namespace App\Actions\Requests;

use App\Models\QAndA;
use App\Services\TelegramService;
use DomainException;

class SendMessage
{
	private TelegramService $telegramService;

	public function __construct(TelegramService $telegramService)
	{
		$this->telegramService = $telegramService;
	}

	public function execute(int $requestId, string $message): void
	{
		$user = auth()->user();
		$qa = QAndA::findOrFail($requestId);

		if (!$user->is_admin && $qa->responsible_user_id !== $user->id) {
			throw new DomainException('Ви не відповідальні за цей запит', 403);
		}

		$this->sendMessage($qa, $message);
		$qa->consul_answer = $message;
		$qa->question_status = QAndA::STATUS_COMPLETED;

		$qa->save();
	}

	private function sendMessage(QAndA $session, string $message): void
	{
        $this->telegramService->sendSticker($session->chat_id, 'CAACAgIAAxkBAAEBq45f0mrUq4zYoRR4KEffps6Xm95vbQACMwAD3OdiCEuFU2oXL1LqHgQ');
        $reply = "<b>Ваше запитання:</b>\n" . $session->user_question . "\n\n<b>Вiдповiдь консула:</b>\n". $message;
		$this->telegramService->sendMessage($session->chat_id, $reply);
	}
}
