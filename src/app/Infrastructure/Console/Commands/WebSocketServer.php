<?php

namespace App\Infrastructure\Console\Commands;

use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;
use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Http\Router;
use React\EventLoop\Loop;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use React\Socket\SocketServer;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

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
        $url = config('app.websocket_url');

        $loop = Loop::get();
        $socket = new SocketServer($url);
        $routes = new RouteCollection();

        $websocketServer = new WsServer(
            app(FriendWebSocketController::class)
        );
        $websocketServer->enableKeepAlive($loop);

        $routes->add('friends', new Route('/friends', [
            '_controller' => $websocketServer,
        ]));

        $urlMatcher = new UrlMatcher($routes, new RequestContext());
        $router = new Router($urlMatcher);
        $server = new IoServer(
            new HttpServer($router),
            $socket,
            $loop
        );
        $server->run();
    }
}
