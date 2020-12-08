<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Requests\UpdateRequest;
use App\Actions\Requests\AssignResponsible;
use App\Actions\Requests\DTO\Request as UserRequest;
use App\Actions\Requests\GetRequests;
use App\Actions\Requests\DTO\FilterRequest;
use App\Models\QAndA;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestsController extends Controller
{
    public function requests(Request $request, GetRequests $getRequests)
    {
        $user = $request->user();

        if ($user->is_operator && !$user->work_country) {
            return $this->error('Оберіть країну у налаштуваннях');
        }

        $filterData = $request->input('filter') ?? [];
        $country = (int)$filterData['country'] ?? 0;
        $requests = $getRequests->execute(
            new FilterRequest(
                $filterData['search'] ?? '',
                (int)$filterData['category'] ?? 0,
                $filterData['requests'] ?? '',
                $user->is_admin ? $country : $user->work_country,
            )
        );

        return $this->success($requests);
    }

    public function updateRequest(Request $request, int $id, UpdateRequest $updateRequest)
    {
        $response = $updateRequest->execute(
            new UserRequest(
                $id,
                (string)$request->input('question'),
                '',
                (int)$request->input('status'),
                Carbon::now(),
                (int)$request->input('category'),
                trim((string)$request->input('answer')),
                trim((string)$request->input('countryName')),
                null,
            )
        );

        return $this->success($response);
    }

    public function assignResponsible(Request $request, int $id, AssignResponsible $assignResponsible)
    {
        $request = QAndA::findOrFail($id);
        $user = $request->user();

        if (!$user->can('changeResponsible')) {
            return $this->error('you cannot change responsible');
        }

        $response = $assignResponsible->execute($id, $request->input('responsible'));

        return $this->success($response);
    }
}
