<?php

namespace App\Actions\Requests\DTO;
use App\Contracts\Response;
use Carbon\Carbon;

class Request implements Response
{
	public int $id;
	public string $question;
	public string $user;
	public int $status;
	public Carbon $created_at;
	public ?int $category;
	public ?string $answer;
	public ?string $country;

	public function __construct(
		int $id,
		string $question,
		string $user,
		int $status,
		Carbon $created_at,
		?int $category,
		?string $answer,
		?string $country
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
		];
	}
}
