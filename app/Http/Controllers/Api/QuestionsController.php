<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Actions\Questions\GetQuestions;
use App\Actions\Questions\UpdateQuestion;
use App\Actions\Questions\CreateQuestion;
use App\Actions\Questions\DTO\Question;
use Illuminate\Http\Request;

class QuestionsController extends Controller
{
    public function questions(GetQuestions $getQuestions)
    {
        $questions = $getQuestions->execute();

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
}
