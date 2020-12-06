<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;

class QAndA extends Model
{
    use HasFactory;

    const STATUS_NEW = 0;
    const STATUS_EXECUTING = 1;
    const STATUS_COMPLETED = 2;

    protected $table = 'users_questions';

    public static function getStatuses()
    {
        return [
            [ 'id' => self::STATUS_NEW, 'name' => 'Нове' ],
            [ 'id' => self::STATUS_EXECUTING, 'name' => 'Виконується' ],
            [ 'id' => self::STATUS_COMPLETED, 'name' => 'Завершено' ],
        ];
    }

    public static function getTelegramRequests(): Builder
    {
        return DB::table('users_questions')->select()->orderByDesc('created_at');
    }

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
        $questions = self::questionsBuilder()->get();

        return $questions;
    }

    public static function questionsBuilder(): Builder
    {
        return DB::table('questions')->select(
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
        ->where('publish', 1)
        ->join('countries', 'countries.id', '=', 'questions.country')
        ->join('question_categories', 'question_categories.id', '=', 'questions.category')
        ->orderByDesc('created_at');
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
