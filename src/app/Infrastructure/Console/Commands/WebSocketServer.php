<?php

namespace App\Infrastructure\Console\Commands;

use App\Infrastructure\WebSocket\Routing\Route;
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
     * @return void
     */
    public function handle(): void
    {
        $host = config('app.ws_host');
        $port = config('app.ws_port');
        $address = config('app.ws_address');

        $loop = Loop::get();
        $app = new App($host, $port, $address, $loop);

        $routes = Route::getRoutes();

        foreach ($routes as $url => $controller) {
            $app->route($url, new WsServer(
                app($controller)
            ), ['*']);
        }

        $app->run();
    }
}
