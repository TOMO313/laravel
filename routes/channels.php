<?php

use Illuminate\Support\Facades\Broadcast;

//クライアントがブロードキャストされたイベントを取得する際に認証を行うファイル
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
