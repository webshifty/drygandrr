<?php

namespace App\Actions\Requests\DTO;

use App\Actions\General\BaseResponse;
use App\Contracts\Response;

class RequestsResponse extends BaseResponse implements Response
{
	public function add(Request $request)
	{
		parent::addEntity($request);
	}
}
