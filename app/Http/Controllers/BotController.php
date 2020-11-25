<?php

namespace App\Http\Controllers;

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


        $chatId = $client->easy->chat_id;
        $userName = ", ";
        $reply = "Привет". $userName;
        $client->sendMessage($chatId, $reply, null, null, null, null, null);
        exit();

        $menu["inline_keyboard"] = [
            [
                [
                    "text" => "\xE2\x98\x80 Узнать погоду \xE2\x98\x80",
                    "callback_data" => "whatWeather",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\x9A Что надеть? \xF0\x9F\x91\x96",
                    "callback_data" => "whatWear",
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

        $menu2["inline_keyboard"] = [
            [
                [
                    "text" => "\xF0\x9F\x91\x9A Что надеть? \xF0\x9F\x91\x96",
                    "callback_data" => "whatWear",
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

        $menuGender["inline_keyboard"] = [
            [
                [
                    "text" => "\xF0\x9F\x91\xA8 М",
                    "callback_data" => "men",
                ],
            ],
            [
                [
                    "text" => "\xF0\x9F\x91\xA9 Ж",
                    "callback_data" => "women",
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
                    //TelegramBotData::firstAddUser($client->easy->from_id, $update->message->chat->username);
                    if (!is_null($update->message->chat->first_name)){
                        $userName = ", ".$update->message->chat->first_name;
                        $reply = "Привет". $userName ."!\nЯ могу тебе подобрать лук на сегодня или рассказать погоду в твоем городе \xF0\x9F\x98\x8A";
                        //$reply_markup = TelegramBotData::replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
                        $client->sendMessage($chatId, $reply, null, null, null, null, $menu);
                        exit();
                    } else {
                        $userName = "";
                        $reply = "Привет". $userName ."!\nЯ могу тебе подобрать лук на сегодня или рассказать погоду в твоем городе \xF0\x9F\x98\x8A";
                        $client->sendMessage($chatId, $reply, null, null, null, null, $menu);
                        exit();
                    }
                    break;
                case !is_null($update->message->text):
                    //$addCity = TelegramBotData::addCity($client->easy->from_id, $text);

                    //if ($addCity == true) {
                        $reply = "Город сохранен";
                        $client->sendMessage($chatId, $reply, null, null, null, null, $menu);
                        exit();
                    //} else {
                    //    exit();
                    //}
                    break;
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
            }
        }

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
        }
    }
}
