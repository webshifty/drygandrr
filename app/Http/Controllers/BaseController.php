<?php

namespace App\Http\Controllers;

use App\Models\QAndA;
use App\Models\Questions;
use App\Models\TelegramBotData;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use App\Actions\Questions\GetQuestions;

class BaseController extends Controller
{
    public function questions(GetQuestions $getQuestions) {
        $questions = $getQuestions->execute();

        return $this->success($questions);
    }

    public static function dashboard()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $countries = QAndA::getAllCountries();
        $categories = QAndA::getAllQuestionCategories();
        $data = [
            'userInfo' => $userInfo,
            'countries' => $countries,
            'categories' => $categories,
        ];

        return view('admin.dashboard.questions', ['data' => $data]);
    }

    public static function updateUserQuestionInfo(Request $request)
    {
        $updateLeadInfo = QAndA::find($request->id);
        $updateLeadInfo->question_status = $request->status;
        $updateLeadInfo->consul_answer = $request->comment;
        $updateLeadInfo->save();

        return response()->json(['html'=>'Iнформація оновлена']);
    }

    public static function questionBase()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $questions = QAndA::getAllQuestions();
        $countries = QAndA::getAllCountries();
        $categories = QAndA::getAllQuestionCategories();
        $data = [
            'questions' => $questions,
            'userInfo' => $userInfo,
            'countries' => $countries,
            'categories' => $categories,
        ];

        return view('admin.dashboard.requests', ['data' => $data]);
    }

    public function saveNewQA(Request $request)
    {
        $qa = new Questions();
        $qa->country = $request->country;
        $qa->category = $request->category;
        $qa->question = trim($request->question);
        $qa->answer = trim($request->answer);
        $qa->publish = 1;
        $qa->created_at = Carbon::now();
        $qa->save();

        return redirect()->back()->with(['status'=>'Додано в базу.']);
    }

    public static function updateQABase(Request $request)
    {
        if (is_null($request->publish)){
            $publish = 1;
        } else {
            $publish = $request->publish;
        }
        $updateLeadInfo = Questions::find($request->id);
        $updateLeadInfo->question = $request->question;
        $updateLeadInfo->answer = $request->answer;
        $updateLeadInfo->publish = $publish;
        $updateLeadInfo->save();

        return response()->json(['html'=>'Iнформація оновлена']);
    }
}
