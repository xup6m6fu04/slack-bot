<?php

namespace App\Http\Controllers;

use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\Drivers\Slack\Extensions\Menu;
use BotMan\Drivers\Slack\SlackDriver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SlackController extends Controller
{
    protected $loop;
    protected $bot;

    public function __construct()
    {
        DriverManager::loadDriver(SlackDriver::class);
        // Create BotMan instance
        $config = [
            'slack' => [
                'token' => env('SLACK_TOKEN')
            ]
        ];
        $this->bot = BotManFactory::create($config);
    }

    public function getRequest(Request $request)
    {
        Log::info(json_encode(json_decode($request->input('payload'), true), 128));
    }

    public function push(Request $request)
    {
        $this->bot->say($request->get('m'), 'CB7D98TD4', SlackDriver::class);
    }

    public function events(Request $request)
    {
        Log::info($request);
        // Inside your conversation
        // Inside your conversation
        $this->bot->hears('我錄取了嗎？', function($bot) {
            $bot->reply('錄取了！');
        });

        $this->bot->listen();
    }
}
