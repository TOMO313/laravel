<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserRegistered $event): void
    {
        Session::flash('success', '登録が完了しました' . $event->user->name . 'さん！'); //flash()を使用してセッションに保存されたデータは、即時および後続のHTTPリクエスト中に利用可能
    }
}
