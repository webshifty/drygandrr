<?php

namespace App\Actions\Workers\DTO;

use App\Actions\General\BaseResponse;
use App\Actions\Workers\DTO\WorkerItem;
use App\Contracts\Response;

class WorkerList extends BaseResponse implements Response
{
	public function add(WorkerItem $worker): void
	{
		parent::addEntity($worker);
	}
}
