<?php

namespace App\Actions\Workers\DTO;

use App\Actions\General\BaseResponse;
use App\Actions\Workers\DTO\Worker;
use App\Contracts\Response;

class WorkersResponse extends BaseResponse implements Response
{
	public function add(Worker $worker): void
	{
		parent::addEntity($worker);
	}
}
