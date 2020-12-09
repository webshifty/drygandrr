<?php

namespace App\Actions\Questions\DTO;
use App\Contracts\Arrayable;

class Question implements Arrayable
{
	public int $id;
	public int $country;
	public int $category;
	public string $status;
	public string $question;
	public string $answer;
	public bool $publish;

	public function __construct(
		int $id,
		int $country,
		int $category,
		string $status,
		string $question,
		string $answer,
		bool $publish
	)
	{
		$this->id = $id;
		$this->country = $country;
		$this->category = $category;
		$this->status = $status;
		$this->question = $question;
		$this->answer = $answer;
		$this->publish = $publish;
	}

	public function toArray(): array
	{
		return [
			'id' => $this->id,
			'country' => $this->country,
			'category' => $this->category,
			'status' => $this->status,
			'question' => $this->question,
			'answer' => $this->answer,
			'publish' => $this->publish,
		];
	}
}
