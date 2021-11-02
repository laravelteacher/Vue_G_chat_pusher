<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
// this routes get new message at real time from events for new message 
Broadcast::channel('chat{id}', function ($user) {
    return $user;
});
// this routes get who are online or offline
Broadcast::channel('send{id}', function ($user) {
    return $user;
});
