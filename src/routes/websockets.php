<?php

use App\Infrastructure\WebSocket\Controllers\Chat\ChatWebSocketController;
use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;
use App\Infrastructure\WebSocket\Routing\WebSocketRouter as Route;

Route::ws('/friends', FriendWebSocketController::class);
Route::ws('/chats', ChatWebSocketController::class);
