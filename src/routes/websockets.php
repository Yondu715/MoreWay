<?php

use App\Infrastructure\WebSocket\Controllers\Notification\NotificationController;
use App\Infrastructure\WebSocket\Routing\WebSocketRouter as Route;

Route::ws('/notifications', NotificationController::class);
