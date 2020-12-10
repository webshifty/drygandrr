<?php

namespace App\Http\Controllers\Api;

use App\Actions\General\SingleResponse;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	public function createCategory(Request $request)
	{
		$request->validate([
			'category' => 'required',
		]);
		$categoryName = $request->input('category');
		$category = Category::create([ 'name' => $categoryName ]);

		return $this->success(new SingleResponse($category));
	}
}
