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
        /**[
        [
        "text" => "\xF0\x9F\x91\xB7 Тех. поддержка \xF0\x9F\x91\xB7",
        "url" => "https://t.me/mishikoua",
        ],
        ],
         * **/
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

        $menuWhatWear2["inline_keyboard"] = [
            [
                [
                    "text" => "\xE2\x9D\x94 Что надеть cегодня? \xE2\x9D\x94",
                    "callback_data" => "whatWearAllParams",
                ],
            ],
            [
                [
                    "text" => "\xE2\x98\x80 Узнать погоду \xE2\x98\x80",
                    "callback_data" => "whatWeather",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\x91 Статьи о моде \xF0\x9F\x91\x91",
                    "url" => "https://umuse.info/fashion",
                ],
                [
                    "text" => "\xE2\x99\x88 Гороскопы \xE2\x99\x8D",
                    "url" => "https://umuse.info/horoscopes",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\xB7 Тех. поддержка \xF0\x9F\x91\xB7",
                    "url" => "https://t.me/mnadmn",
                ],
            ],
        ];

        $menuWhatWear3["inline_keyboard"] = [
            [
                [
                    "text" => "\xF0\x9F\x98\xA8 Покажи другой вариант \xF0\x9F\x98\xA8",
                    "callback_data" => "whatWearAllParamsRandomId",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\x91 Статьи о моде \xF0\x9F\x91\x91",
                    "url" => "https://umuse.info/fashion",
                ],
                [
                    "text" => "\xE2\x99\x88 Гороскопы \xE2\x99\x8D",
                    "url" => "https://umuse.info/horoscopes",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\xB7 Тех. поддержка \xF0\x9F\x91\xB7",
                    "url" => "https://t.me/mnadmn",
                ],
            ],
        ];

        $menuWeatherCityError["inline_keyboard"] = [
            [
                [
                    "text" => "	\xF0\x9F\x8C\x86 Повторно ввести город \xF0\x9F\x8C\x86",
                    "callback_data" => "whatWeather",
                ],
            ],
        ];

        if (isset($update->message) or isset($update->edited_message)) {
            $chatId = $client->easy->chat_id;
            $text = $client->easy->text;

            switch ($text) {
                case "/start":
                    TelegramBotData::firstAddUser($client->easy->from_id, $update->message->chat->username);
                    if (!is_null($update->message->chat->first_name)){
                        $client->sendPhoto($chatId, asset('/img/telegram/hello.png'));
                        $userName = ", ".$update->message->chat->first_name;
                        $reply = "Вітаю". $userName ."!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8A\nМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну.";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    } else {
                        $client->sendPhoto($chatId, asset('/img/telegram/hello.png'));
                        $userName = "";
                        $reply = "Вітаю". $userName ."!\nОберіть, будь-ласка, країну знаходження, щоб розпочати спілкування \xF0\x9F\x98\x8AnМожете натиснути кнопку Подiлитись геолокацiєю або ввести країну вручну.";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menu);
                        exit();
                    }
                    break;

                case !is_null($update->message->text):
                    $addCountry = TelegramBotData::addCountry($client->easy->from_id, $text);

                    if ($addCountry == true) {
                        $client->sendPhoto($chatId, asset('/img/telegram/have_question.png'));
                        $reply = "Країна обрана";
                        $client->sendMessage($chatId, $reply, null, null, null, null, null, null, $menuQuestion);
                        exit();
                    } else {
                        exit();
                    }
                    break;

                case "writeQuestion":
                    break;
                case "findInBase":
                    $categories = TelegramBotData::getAllQuestionCategories();
                    $menuCategories["inline_keyboard"] = [];
                    foreach ($categories as $category) {
                        $menuCategories["inline_keyboard"] = [
                            [
                                [
                                    "text" => "\xF0\x9F\x91\xA8 .$category->name",
                                    "callback_data" => "category.$category->id",
                                ],
                            ],
                        ];
                    }
                    $reply = "Оберiть тематику питання";
                    $client->sendMessage($chatId, json_decode($menuCategories), null, null, null, null, null, null, $menuCategories);

                    break;
                /**
                case 0:
                    $reply = "По запросу \"<b>" . $text . "</b>\" ничего не найдено.";
                    $client->sendMessage($chatId, $reply, 'HTML');
                    exit();
                    break;
                default:
                    $reply = "Напиши название города где ты живешь?\n Это поможет подобрать твой лук учитывая погоду \xF0\x9F\x98\x8A";
                    $client->sendMessage($chatId, $reply, 'HTML');
                    exit();
                    break;
                     **/
            }
        }
/**
        if (isset($update->callback_query)) {
            $id = $update->callback_query->id;
            $message_chat_id = $update->callback_query->message->chat->id;
            $message_message_id = $update->callback_query->message->message_id;
            $userId = $update->callback_query->from->id;
            switch ($update->callback_query->data) {
                case "whatWeather":
                    //$city = TelegramBotData::findCity($userId);

                    //if (is_null($city->city)) {
                        $client->answerCallbackQuery($id, null, false);
                        $reply = "Напиши название города где ты живешь?\n Это поможет подобрать твой лук учитывая погоду \xF0\x9F\x98\x8A";
                        $client->editMessageText($message_chat_id, $message_message_id, 'city', $reply, null, null, null);
                        exit();
                        break;
                    //} else {

                    //}
                    break;

            }
        }**/
    }
}
