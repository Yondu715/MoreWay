<?php

use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\WebSocket\Controllers\Friend\FriendWebSocketController;
use App\Infrastructure\Database\Models\Infrastructure\Database\Models\Infrastructure\WebSocket\Routing\Route;

Route::ws('/friends', FriendWebSocketController::class);
