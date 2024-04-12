<?php

use App\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;
use App\Infrastructure\WebSocket\Routing\Route;

Route::ws('/friends', FriendWebSocketController::class);