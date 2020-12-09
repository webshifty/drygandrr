<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Questions\GetQuestions;
use App\Actions\Questions\UpdateQuestion;
use App\Actions\Questions\CreateQuestion;
use App\Actions\Questions\DeleteQuestion;
use App\Actions\Questions\DTO\Question;
use App\Actions\Questions\DTO\FilterQuestion;
use App\Models\Questions;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function questions(Request $request, GetQuestions $getQuestions)
    {
        $user = $request->user();
        $filterData = $request->input('filter') ?? [];
        $country = $filterData['country'] ?? null;
        $questions = $getQuestions->execute(
            new FilterQuestion(
                $user->is_operator ? $user->work_country : $country,
                $filterData['category'] ?? null,
                $filterData['search'] ?? '',
            )
        );

        return $this->success($questions);
    }

    public function addQuestion(Request $request, CreateQuestion $createQuestion)
    {
        $user = $request->user();
        $countryId = $user->is_operator ? $user->work_country : (int)$request->input('country');
        $response = $createQuestion->execute(
            new Question(
                -1,
                $countryId,
                (int)$request->input('category'),
                '',
                trim((string)$request->input('question')),
                trim((string)$request->input('answer')),
                true,
            ),
            $request->input('countryName')
        );

        return $this->success($response);
    }

    public function updateQuestion(Request $request, int $id, UpdateQuestion $updateQuestion)
    {
        $user = $request->user();
        $question = Questions::findOrFail($id);

        if (!$user->can('modify', $question)) {
            return $this->error('Ви не можете модифікувати це питання');
        }

        $countryId = $user->is_operator ? $user->work_country : (int)$request->input('country');
        $response = $updateQuestion->execute(
            new Question(
                (int)$id,
                $countryId,
                (int)$request->input('category'),
                '',
                trim((string)$request->input('question')),
                trim((string)$request->input('answer')),
                true,
            )
        );

        return $this->success($response);
    }

    public function deleteQuestion(Request $request, int $id, DeleteQuestion $deleteQuestion)
    {
        $user = $request->user();
        $question = Questions::findOrFail($id);

        if (!$user->can('modify', $question)) {
            return $this->error('Ви не можете видалити це питання');
        }

        $deleteQuestion->execute($id);

        return $this->empty();
    }
}
