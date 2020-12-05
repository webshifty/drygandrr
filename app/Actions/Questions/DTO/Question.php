<?php

namespace App\Actions\Questions\DTO;

class Question
{
	public int $id;
	public string $country;
	public string $category;
	public string $status;
	public string $text;
	public string $answer;

	public function __construct(
		int $id,
		string $country,
		string $category,
		string $status,
		string $text,
		string $answer
	)
	{
		$this->id = $id;
		$this->country = $country;
		$this->category = $category;
		$this->status = $status;
		$this->text = $text;
		$this->answer = $answer;
	}

	public function toArray()
	{
		return [
			'id' => $this->id,
			'country' => $this->country,
			'category' => $this->category,
			'status' => $this->status,
			'text' => $this->text,
			'answer' => $this->answer,
		];
	}
}
