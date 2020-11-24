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
        $client->sendMessage($chatId, '+++', null, null, null, null, null);
        exit();
        /**
        $menu["inline_keyboard"] = [

        ];

        if (isset($update->message) or isset($update->edited_message)) {
            $chatId = $client->easy->chat_id;
            $text = $client->easy->text;

            switch ($text) {
                case "/start":
                    //TelegramBotData::firstAddUser($client->easy->from_id, $update->message->chat->username);
                    if (!is_null($update->message->chat->first_name)) {
                        $userName = ", " . $update->message->chat->first_name;
                        $reply = "Привет" . $userName . "!\nЯ могу тебе подобрать лук на сегодня или рассказать погоду в твоем городе \xF0\x9F\x98\x8A";
                        //$reply_markup = TelegramBotData::replyKeyboardMarkup(['keyboard' => $keyboard, 'resize_keyboard' => true, 'one_time_keyboard' => false]);
                        $client->sendMessage($chatId, $reply, null, null, null, null, $menu);
                        exit();
                    } else {
                        $userName = "";
                        $reply = "Привет" . $userName . "!\nЯ могу тебе подобрать лук на сегодня или рассказать погоду в твоем городе \xF0\x9F\x98\x8A";
                        $client->sendMessage($chatId, $reply, null, null, null, null, $menu);
                        exit();
                    }
                    break;
            }
        }**/
    }
}
