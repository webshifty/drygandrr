<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Questions\GetQuestions;
use App\Actions\Questions\UpdateQuestion;
use App\Actions\Questions\CreateQuestion;
use App\Actions\Questions\DeleteQuestion;
use App\Actions\Questions\DTO\Question;
use App\Actions\Questions\DTO\FilterQuestion;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function questions(Request $request, GetQuestions $getQuestions)
    {
        $filterData = $request->input('filter') ?? [];
        $questions = $getQuestions->execute(
            new FilterQuestion(
                $filterData['country'] ?? null,
                $filterData['category'] ?? null,
                $filterData['search'] ?? '',
            )
        );

        return $this->success($questions);
    }

    public function addQuestion(Request $request, CreateQuestion $createQuestion)
    {
        $response = $createQuestion->execute(
            new Question(
                -1,
                (int)$request->input('country'),
                (int)$request->input('category'),
                '',
                trim((string)$request->input('question')),
                trim((string)$request->input('answer')),
                (int)$request->input('publish'),
            )
        );

        return $this->success($response);
    }

    public function updateQuestion(Request $request, int $id, UpdateQuestion $updateQuestion)
    {
        $response = $updateQuestion->execute(
            new Question(
                (int)$id,
                (int)$request->input('country'),
                (int)$request->input('category'),
                '',
                trim((string)$request->input('question')),
                trim((string)$request->input('answer')),
                (int)$request->input('publish'),
            )
        );

        return $this->success($response);
    }

    public function deleteQuestion(int $id, DeleteQuestion $deleteQuestion)
    {
        $deleteQuestion->execute($id);

        return $this->empty();
    }
}
