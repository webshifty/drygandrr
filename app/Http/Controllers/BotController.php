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
                    "text" => "\xE2\x9D\x93 Задати питання \xE2\x9D\x93",
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

        $menuInBase["inline_keyboard"] = [
            [
                [
                    "text" => "\xF0\x9F\x93\x9A Шукати в базi \xF0\x9F\x93\x9A",
                    "callback_data" => "findInBase",
                ],
            ],
        ];

        $menuAlphabet["inline_keyboard"] = [
            [
                [
                    "text" => "А",
                    "callback_data" => "letterА",
                ],
                [
                    "text" => "Б",
                    "callback_data" => "letterБ",
                ],
                [
                    "text" => "У",
                    "callback_data" => "letterУ",
                ],
            ],
        ];

        if (isset($update->message) or isset($update->edited_message)) {
            $chatId = $client->easy->chat_id;
            $text = $client->easy->text;

            if (isset($update->message->location)){
                $weatherJson = @file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=" . $update->message->location->latitude . "&lon=" . $update->message->location->longitude . "&appid=" . Config::get('constants.weatherKey') . "&lang=ru&units=metric");
                $country = json_decode($weatherJson, true);

                if ($country['sys']['country'] == 'UA'){
                    $text = 'Україна';
                }
                $addCountry = TelegramBotData::addCountry($client->easy->from_id, $text);

                if ($addCountry == true) {
                    $country = TelegramBotData::getUserCountryName($client->easy->from_id);
                    $client->sendPhoto($chatId, asset('/img/telegram/have_question_2.png'));
                    $reply = $country->country . " - Країна обрана.\nНапишіть ваше запитання.\xF0\x9F\x98\x89";
                    $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuInBase);
                    exit();
                } else {
                    $client->sendSticker($chatId, 'CAACAgIAAxkBAAEBq45f0mrUq4zYoRR4KEffps6Xm95vbQACMwAD3OdiCEuFU2oXL1LqHgQ');
                    $reply = "Такої країни в нашій великій базі немає. Виберіть будь ласка першу букву назви країни:";
                    $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuAlphabet);
                    exit();
                }
            }
            switch ($text) {
                case "/start":
                    TelegramBotData::firstAddUser($client->easy->from_id, $update->message->chat->username);
                    if (!is_null($update->message->chat->first_name)) {
                        $client->sendPhoto($chatId, asset('/img/telegram/hello_2.png'));
                        $userName = ", " . $update->message->chat->first_name;
                        $reply = "Вітаю" . $userName . "!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8A\nМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну. \nЩоб ввести країну вручну почнiть з команди /country Далі країна";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    } else {
                        $client->sendPhoto($chatId, asset('/img/telegram/hello_2.png'));
                        $userName = "";
                        $reply = "Вітаю" . $userName . "!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8AnМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну. \nЩоб ввести країну вручну почнiть з команди /country Далі країна";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    }
                    break;

                case isset($update->message) && !is_null($update->message->text):
                    if (strpos($text, '/consul') !== false) {
                        $userQuestion = trim(str_replace('/consul', "", $text));
                        TelegramBotData::saveUserQuestion($chatId, $client->easy->from_id, $userQuestion);
                        $client->sendPhoto($chatId, asset('/img/telegram/byebye_2.png'));
                        $reply = "В нашій базі немає відповіді на це питання. Я все передала консулу. Він повернеться з відповіддю в свої робочі години, протягом двох робочих днів.";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuInBase);
                        exit();
                    } elseif (strpos($text, '/country') !== false) {
                        $userCountry = trim(str_replace('/country', "", $text));
                        $addCountry = TelegramBotData::addCountry($client->easy->from_id, $userCountry);

                        if ($addCountry == true) {
                            $country = TelegramBotData::getUserCountryName($client->easy->from_id);
                            $client->sendPhoto($chatId, asset('/img/telegram/have_question_2.png'));
                            $reply = $country->country . " - Країна обрана.\nНапишіть ваше запитання.\xF0\x9F\x98\x89";
                            $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuInBase);
                            exit();
                        } else {
                            $client->sendSticker($chatId, 'CAACAgIAAxkBAAEBq45f0mrUq4zYoRR4KEffps6Xm95vbQACMwAD3OdiCEuFU2oXL1LqHgQ');
                            $reply = "Такої країни в нашій великій базі немає. Виберіть будь ласка першу букву назви країни:";
                            $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuAlphabet);
                            exit();
                        }
                    } else {
                        $userCountryId = TelegramBotData::getUserCountry($client->easy->from_id);
                        $findQuestions = TelegramBotData::findQuestionsLikeText($text, $userCountryId);

                        if (count($findQuestions) > 0) {
                            $client->sendPhoto($chatId, asset('/img/telegram/have_question_2.png'));
                            $menuQuestions["inline_keyboard"] = [];

                            foreach ($findQuestions as $question) {
                                $menuQuestions["inline_keyboard"][] = [
                                    [
                                        "text" => $question->question,
                                        "callback_data" => "question" . $question->id,
                                    ],
                                ];
                            }
                            $reply = "Оберiть питання яке вас цiкавить";
                            $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuQuestions);
                            exit();
                        } else {
                            TelegramBotData::saveUserQuestion($chatId, $client->easy->from_id, $text);
                            $client->sendPhoto($chatId, asset('/img/telegram/no_answer_2.png'));
                            $reply = "В нашій базі немає відповіді на це питання. \nЯ все передала консулу. Він повернеться з відповіддю в свої робочі години, протягом двох робочих днів. \nВи можете пошукати відповідь в нашій базі знань вручну.";
                            $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuInBase);
                            exit();
                        }
                    }
                    break;

                case 0:
                    $reply = "По запросу \"<b>" . $text . "</b>\" ничего не найдено.";
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
                        $client->sendPhoto($message_chat_id, asset('/img/telegram/question_to_consul_2.png'));
                        $reply = "Введіть ваше запитання. Починайте текст питання з команди /consul Далі питання";
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuInBase);
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
                        $client->sendPhoto($message_chat_id, asset('/img/telegram/it_is_our_base_2.png'));
                        $reply = "Оберiть тематику питання";
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuCategories);
                        exit();
                        break;

                    case strpos($update->callback_query->data, 'category'):
                        $categoryId = str_replace('category', "", $update->callback_query->data);
                        TelegramBotData::saveLastCategory($userId, $categoryId);
                        $questions = TelegramBotData::getQuestionByCountryByCategory($userId, $categoryId);
                        $menuQuestions["inline_keyboard"] = [];

                        if (!empty($questions)) {
                        foreach ($questions as $question) {
                            $menuQuestions["inline_keyboard"][] = [
                                [
                                    "text" => $question->question,
                                    "callback_data" => "question" . $question->id,
                                ],
                            ];
                        }
                        $client->sendPhoto($message_chat_id, asset('/img/telegram/search_in_base_2.png'));
                        $reply = "Оберiть питання яке вас цiкавить";
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuQuestions);
                        exit();
                        break;
                        } else {
                            exit();
                            break;
                        }

                    case strpos($update->callback_query->data, 'question'):
                        $questionId = str_replace('question', "", $update->callback_query->data);
                        $answer = TelegramBotData::getAnswerById($questionId);
                        $client->sendPhoto($message_chat_id, asset('/img/telegram/byebye_2.png'));
                        $reply = "<b>Ваше запитання:</b>\n" . $answer->question . "\n\n<b>Вiдповiдь:</b>\n" . $answer->answer;
                        $client->sendMessage($message_chat_id, $reply, 'HTML', null, null, null, null, null, $menuInBase);
                        exit();
                        break;

                    case strpos($update->callback_query->data, 'letter'):
                        $letter = str_replace('letter', "", $update->callback_query->data);
                        $countries = TelegramBotData::getCountryByLetter($letter);
                        $menuCountries["inline_keyboard"] = [];

                        foreach ($countries as $country) {
                            $menuCountries["inline_keyboard"][] = [
                                [
                                    "text" => $country->name,
                                    "callback_data" => "countryId" . $country->id,
                                ],
                            ];
                        }
                        $client->sendSticker($message_chat_id, 'CAACAgIAAxkBAAEBrApf08LLYXnaJK2Iw0jawqgyQPfdNAACNwAD3OdiCGCQcXER-sVkHgQ');
                        $reply = "Виберіть країну зі списку:";
                        $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuCountries);
                        exit();
                        break;

                    case strpos($update->callback_query->data, 'countryId'):
                        $countryId = trim(str_replace('countryId', "", $update->callback_query->data));
                        $addCountry = TelegramBotData::addCountryById($update->callback_query->from->id, $countryId);

                        if ($addCountry == true) {
                            $country = TelegramBotData::getUserCountryName($update->callback_query->from->id);
                            $client->sendPhoto($message_chat_id, asset('/img/telegram/have_question_2.png'));
                            $reply = $country->country . " - Країна обрана.\nНапишіть ваше запитання.\xF0\x9F\x98\x89";
                            $client->sendMessage($message_chat_id, $reply, null, null, null, null, null, null, $menuInBase);
                            exit();
                            break;
                        } else {
                            exit();
                            break;
                        }
                        break;
                }
            }
        }
}
