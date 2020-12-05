<?php

namespace App\Actions\Questions;

use App\Models\Questions;

class DeleteQuestion
{
	public function execute(int $questionId): void
	{
		$qa = Questions::findOrFail($questionId);
        $qa->delete();
	}
}
