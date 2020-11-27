<?php

namespace App\Http\Controllers;

use App\Models\TelegramBotData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Telegram\Bot\Laravel\Facades\Telegram;
use TuriBot\Client;

class BotController extends Controller
{
    public static function test()
    {
        //$telegram = new Api();
        $response = Telegram::getMe();

        //$botId = $response->getId();
        //$firstName = $response->getFirstName();
        //$username = $response->getUsername();
        $result = Telegram::getWebhookUpdates();
        $result2 = Telegram::getLastResponse();
        $commandBus = Telegram::getCommandBus();
        $data = [
            'response' => $response,
            'result' => $result,
            'result2' => $result2,
            'commandBus' => $commandBus,
        ];

        return $data;
    }

    public static function income()
    {
        $client = new Client(Config::get('telegram.bots.mybot.token'), false);
        $update = $client->getUpdate();
        /**
        $reply2 = json_encode($update->callback_query);
        $client->sendMessage($client->easy->chat_id, $reply2, 'HTML');
        exit();

        $chatId = $client->easy->chat_id;
        $reply = "" . $client->easy->text;
        $client->sendMessage($chatId, $reply, null, null, null, null, null);
        exit();
**/
        $menu = [
            'keyboard' => [
                [
                    [
                        "text" => "\xE2\x98\x80 Подiлитись геолокацiєю \xE2\x98\x80",
                        "request_location" => true,
                    ],
                ],
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ];

        $menuQuestion["inline_keyboard"] = [
            [
                [
                    "text" => "\xE2\x9D\x93 Задати питання? \xE2\x9D\x93",
                    "callback_data" => "writeQuestion",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x93\x9A Шукати в базi \xF0\x9F\x93\x9A",
                    "callback_data" => "findInBase",
                ],
            ],
        ];

        if (isset($update->message) or isset($update->edited_message)) {
            $chatId = $client->easy->chat_id;
            $text = $client->easy->text;

            if (isset($update->message->location)){
                $weatherJson = @file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=" . $update->message->location->latitude . "&lon=" . $update->message->location->longitude . "&appid=" . Config::get('constants.weatherKey') . "&lang=ru&units=metric");
                $country = json_decode($weatherJson, true);
                $reply2 = json_encode($country['sys']['country']);
                $client->sendMessage($client->easy->chat_id, $reply2, 'HTML');
                exit();
            }
            switch ($text) {
                case "/start":
                    TelegramBotData::firstAddUser($client->easy->from_id, $update->message->chat->username);
                    if (!is_null($update->message->chat->first_name)) {
                        $client->sendPhoto($chatId, asset('/img/telegram/hello.png'));
                        $userName = ", " . $update->message->chat->first_name;
                        $reply = "Вітаю" . $userName . "!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8A\nМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну.";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    } else {
                        $client->sendPhoto($chatId, asset('/img/telegram/hello.png'));
                        $userName = "";
                        $reply = "Вітаю" . $userName . "!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8AnМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну.";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    }
                    break;

                case !is_null($update->message->text):
                    $addCountry = TelegramBotData::addCountry($client->easy->from_id, $text);

                    if ($addCountry == true) {
                        $client->sendPhoto($chatId, asset('/img/telegram/have_question.png'));
                        $reply = $text . " - Країна обрана";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuQuestion);
                        exit();
                    } else {
                        exit();
                    }
                    break;

                case 0:
                    $reply = "По запросу \"<b>" . $text . "</b>\" ничего не найдено.";
                    $client->sendMessage($chatId, $reply, 'HTML');
                    exit();
                    break;

                default:
                    $reply = "Напиши название города где ты живешь?\n  \xF0\x9F\x98\x8A";
                    $client->sendMessage($chatId, $reply, 'HTML');
                    exit();
                    break;
            }
        }
            if (isset($update->callback_query)) {
                $id = $update->callback_query->id;
                $message_chat_id = $update->callback_query->message->chat->id;
                $message_message_id = $update->callback_query->message->message_id;
                $userId = $update->callback_query->from->id;

                switch ($update->callback_query->data) {
                    case "writeQuestion":
                        exit();
                        break;

                    case "findInBase":
                        $categories = TelegramBotData::getAllQuestionCategories();
                        $menuCategories["inline_keyboard"] = [];

                        foreach ($categories as $category) {
                            $menuCategories["inline_keyboard"][] = [
                                [
                                    "text" => "\xF0\x9F\x92\xAC " . $category->name,
                                    "callback_data" => "category" . $category->id,
                                ],
                            ];
                        }
                        $reply = "Оберiть тематику питання";
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuCategories);
                        exit();
                        break;

                    case strpos($update->callback_query->data, 'category'):
                        $categoryId = str_replace('category', "", $update->callback_query->data);
                        TelegramBotData::saveLastCategory($userId, $categoryId);
                        $questions = TelegramBotData::getQuestionByCountryByCategory($userId, $categoryId);
                        $menuQuestions["inline_keyboard"] = [];

                        foreach ($questions as $question) {
                            $menuQuestions["inline_keyboard"][] = [
                                [
                                    "text" => "\xE2\x9D\x94 " . $question->question,
                                    "callback_data" => "question" . $question->id,
                                ],
                            ];
                        }
                        $reply = "Оберiть питання яке вас цiкавить";
                        $reply2 = json_encode($categoryId);
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuQuestions);
                        exit();
                        break;

                    case strpos($update->callback_query->data, 'question'):
                        $questionId = str_replace('question', "", $update->callback_query->data);

                        $answer = TelegramBotData::getAnswerById($questionId);
                        $client->sendPhoto($message_chat_id, asset('/img/telegram/byebye.png'));
                        $client->sendMessage($message_chat_id, $answer->answer, null, null, null, null, null, null, $menuQuestion);
                        exit();
                        break;
                }
            }

        if (isset($update->callback_query->location)) {
            $chatId = $client->easy->chat_id;

            $reply2 = json_encode($update->location);
            $client->sendMessage($chatId, $reply2, 'HTML');
        }
        }
}
