<?php

namespace App\Http\Controllers;

use App\Models\QAndA;
use App\Models\Questions;
use App\Models\TelegramBotData;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class BaseController extends Controller
{
    public static function dashboard()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $telegramRequests = QAndA::getAllRequestsFromTG();
        $data = [
            'allRequests' => $telegramRequests,
            'userInfo' => $userInfo,
        ];

        return view('admin.dashboard', ['data' => $data]);
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
        $questionCategories = QAndA::getAllQuestionCategories();
        $data = [
            'questions' => $questions,
            'userInfo' => $userInfo,
            'countries' => $countries,
            'questionCategories' => $questionCategories,
        ];

        return view('admin.q_base', ['data' => $data]);
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
