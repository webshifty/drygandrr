<?php

namespace App\Http\Controllers;

use App\Models\QAndA;
use App\Models\Questions;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BaseController extends Controller
{
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

    public static function settings()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $countries = QAndA::getAllCountries();
        $categories = QAndA::getAllQuestionCategories();
        $data = [
            'userInfo' => $userInfo,
            'countries' => $countries,
            'categories' => $categories,
        ];

        return view('admin.dashboard.settings', ['data' => $data]);
    }

    public static function workers()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $countries = QAndA::getAllCountries();
        $categories = QAndA::getAllQuestionCategories();
        $data = [
            'userInfo' => $userInfo,
            'countries' => $countries,
            'categories' => $categories,
        ];

        return view('admin.dashboard.workers', ['data' => $data]);
    }

    public static function questionBase()
    {
        $userInfo = User::getUserInfoById(auth()->id());
        $countries = QAndA::getAllCountries();
        $categories = QAndA::getAllQuestionCategories();
        $statuses = QAndA::getStatuses();
        $data = [
            'userInfo' => $userInfo,
            'countries' => $countries,
            'categories' => $categories,
            'statuses' => $statuses,
        ];

        return view('admin.dashboard.requests', ['data' => $data]);
    }

    public static function updateUserQuestionInfo(Request $request)
    {
        $updateLeadInfo = QAndA::find($request->id);
        $updateLeadInfo->question_status = $request->status;
        $updateLeadInfo->consul_answer = $request->comment;
        $updateLeadInfo->save();

        return response()->json(['html'=>'Iнформація оновлена']);
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
