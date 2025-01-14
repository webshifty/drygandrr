<?php

namespace App\Actions\Requests\DTO;
use App\Contracts\Arrayable;
use App\Models\QAndA;
use Carbon\Carbon;

class Request implements Arrayable
{
	public int $id;
	public string $question;
	public string $user;
	public int $status;
	public Carbon $created_at;
	public ?int $category;
	public ?string $answer;
	public ?string $country;
	public ?Responsible $responsible;

	public function __construct(
		int $id,
		string $question,
		string $user,
		int $status,
		Carbon $created_at,
		?int $category,
		?string $answer,
		?string $country,
		?Responsible $responsible
	)
	{
		$this->id = $id;
		$this->question = $question;
		$this->user = $user;
		$this->status = $status;
		$this->created_at = $created_at;

		$this->category = $category;
		$this->answer = $answer;
		$this->country = $country;
		$this->responsible = $responsible;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'question' => $this->question,
			'user' => $this->user,
			'status' => $this->status,
			'created_at' => $this->created_at,
			'category' => $this->category,
			'answer' => $this->answer,
			'country' => $this->country,
			'responsible' => $this->responsible
				? $this->responsible->toArray()
				: null,
		];
	}

	public static function fromEntity(QAndA $entity): Request
	{
		return new self(
			(int)$entity->id,
			(string)$entity->user_question,
			(string)$entity->tg_username,
			(int)$entity->question_status,
			new Carbon($entity->created_at),
			$entity->question_category,
			$entity->consul_answer,
			$entity->country,
			($entity->responsible_user_id !== null) ? new Responsible(
				$entity->responsible->id,
				$entity->responsible->name,
			) : null,
		);
	}
}
