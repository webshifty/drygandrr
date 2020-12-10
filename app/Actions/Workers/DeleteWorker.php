<?php

namespace App\Actions\Workers;

use App\Models\QAndA;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteWorker
{
	public function execute(int $workerId): void
	{
		$worker = User::findOrFail($workerId);

		QAndA::where('responsible_user_id', $worker->id)
			->update(['responsible_user_id' => null]);

		$worker->delete();
	}
}
