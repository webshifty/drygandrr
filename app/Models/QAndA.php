<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class QAndA extends Model
{
    use HasFactory;
    protected $table = 'users_questions';

    public static function getAllRequestsFromTG()
    {
        $usersQuestions = DB::table('users_questions')->select()->get();

        foreach ($usersQuestions as $key => $question) {

            if ($question->question_status == 0) {
                $usersQuestions[$key]->statusButton = '<button class="btn btn-info">Новий</button>';
            }

            if ($question->question_status == 1) {
                $usersQuestions[$key]->statusButton = '<button class="btn btn-warning">В роботі</button>';
            }

            if ($question->question_status == 2) {
                $usersQuestions[$key]->statusButton = '<button class="btn btn-success">Опрацьовано</button>';
            }
        }

        return $usersQuestions;
    }

    public static function getAllQuestions ()
    {
        $questions = DB::table('questions')->select(
            'questions.id',
            'questions.country',
            'questions.category',
            'questions.question',
            'questions.answer',
            'questions.created_at',
            'countries.name',
            'question_categories.name as category_name',
            'publish'
        )
        ->join('countries', 'countries.id', '=', 'questions.country')
        ->join('question_categories', 'question_categories.id', '=', 'questions.category')
        ->orderByDesc('created_at')
        ->get();

        return $questions;
    }

    public static function getAllCountries ()
    {
        $countries = DB::table('countries')->select()->get();

        return $countries;
    }

    public static function getAllQuestionCategories ()
    {
        $countries = DB::table('question_categories')->select()->get();

        return $countries;
    }

}
