<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Telegram\Bot\Api;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use Telegram\Bot\Laravel\Facades\Telegram;

class BotController extends Controller
{
    public function test()
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
}
