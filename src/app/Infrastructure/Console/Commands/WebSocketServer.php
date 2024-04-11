<?php

namespace App\Infrastructure\Console\Commands;

use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;
use Illuminate\Console\Command;
use Ratchet\App;
use React\EventLoop\Loop;
use Ratchet\WebSocket\WsServer;

class WebSocketServer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $host = config('app.ws_host');
        $port = config('app.ws_port');
        $address = config('app.ws_address');

        $loop = Loop::get();
        $app = new App($host, $port, $address, $loop);

        $app->route('/friends', new WsServer(
            app(FriendWebSocketController::class)
        ), ['*']);

        $app->run();
    }
}
