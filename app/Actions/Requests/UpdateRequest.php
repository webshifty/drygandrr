<?php

namespace App\Actions\Requests;

use App\Actions\Requests\DTO\Request;
use App\Models\QAndA;
use App\Services\TelegramService;

class UpdateRequest
{
	private TelegramService $telegramService;

	public function __construct(TelegramService $telegramService)
	{
		$this->telegramService = $telegramService;
	}

	public function execute(Request $data): Request
	{
		$qa = QAndA::with(['responsible'])->findOrFail($data->id);
        $qa->country = $data->country;
        $qa->question_status = $data->status;
        $qa->question_category = $data->category;
        $qa->consul_answer = $data->answer;
		
		if ($data->answer) {
			$this->sendMessage($qa);
		}

		$qa->question_status = QAndA::STATUS_COMPLETED;
		$qa->save();

		return Request::fromEntity($qa);
	}

	private function sendMessage(QAndA $session): void
	{
		$this->telegramService->sendMessage($session->chat_id, $session->consul_answer);
	}
}
