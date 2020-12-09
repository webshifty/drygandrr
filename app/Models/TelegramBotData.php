<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TelegramBotData extends Model
{
    use HasFactory;
    protected $table = 'tg_users';

    public static function firstAddUser($id, $username = null)
    {
        $data = [
            'tg_id' => $id,
            'tg_username' => $username,
            'created_at' => Carbon::now()
        ];
        $user = DB::table('tg_users')->select('tg_id')->where('tg_id', $id)->first();

        if (empty($user)) {
            DB::table('tg_users')->insert($data);
        }
    }

    public static function addCountry($id, $country)
    {
        $data = [
            'country' => $country,
            'updated_at' => Carbon::now()
        ];
        $country = DB::table('tg_users')->where('tg_id', $id)->update($data);

        return $country;
    }

    public static function getUserCountry($id)
    {
        $country = DB::table('tg_users')->select('country')->where('tg_id', $id)->first();

        if (!is_null($country)) {
            $countryId = DB::table('countries')->select('id')->orWhere('name', 'LIKE', '%' . $country->country . '%')->orWhere('name_ru', 'LIKE', '%' . $country->country . '%')->orWhere('name_en', 'LIKE', '%' . $country->country . '%')->first();
        } else {
            $countryId = null;
        }

        return $countryId;
    }

    public static function getAllQuestionCategories () {
        $categories = DB::table('question_categories')->select()->get()->toArray();

        return $categories;
    }

    public static function saveLastCategory($userId, $categoryId)
    {
        $data = [
            'category_id' => $categoryId,
            'updated_at' => Carbon::now()
        ];
        DB::table('tg_users')->where('tg_id', $userId)->update($data);
    }

    public static function getQuestionByCountryByCategory($userId, $category)
    {
        $userCountry = DB::table('tg_users')->select('tg_users.country', 'countries.id')->where('tg_id', $userId)->join('countries', 'name', 'LIKE', 'tg_users.country')->first();

        if (is_null($userCountry)){
            $questions = DB::table('questions')->select('id','question')->where('category', $category)->get()->toArray();

            if (empty($questions) || is_null($questions)){
                $questions = DB::table('questions')->select('id', 'question')->take(5)->get()->toArray();

                return $questions;
            }

            return $questions;
        }
        $questions = DB::table('questions')->select('id','question')->where('country', $userCountry->id)->where('category', $category)->get()->toArray();

        if (empty($questions) || is_null($questions)){
            $questions = DB::table('questions')->select('id', 'question')->where('country', $userCountry->id)->get()->toArray();

            return $questions;
        }

        return $questions;
    }

    public static function getAnswerById($id)
    {
        $answer = DB::table('questions')->select('answer')->where('id', $id)->first();

        return $answer;
    }

    public static function findQuestionsLikeText($text, $countryId)
    {
        if (!is_null($countryId)) {
            $questions = DB::table('questions')->select()->where('country', '=', $countryId->id)->where('question', 'LIKE', '%' . $text . '%')->get();
        } else {
            $questions = DB::table('questions')->select()->where('question', 'LIKE', '%' . $text . '%')->get();
        }

        return $questions;
    }

    public static function saveUserQuestion($chatId, $userId, $question)
    {
        $userData = DB::table('tg_users')->where('tg_id', $userId)->first();
        $data = [
            'chat_id' => $chatId,
            'tg_id' => $userId,
            'tg_username' => $userData->tg_username,
            'user_question' => $question,
            'country' => $userData->country,
            'question_category' => $userData->category_id,
            'question_status' => QAndA::STATUS_NEW,
            'created_at' => Carbon::now(),
            'responsible_user_id' => null,
        ];

        DB::table('users_questions')->insert($data);
    }
}
