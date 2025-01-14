<?php

use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Route;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

use function Pest\Laravel\get;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/', function () {
//     return redirect('https://febri.minty.my.id');
// });

// Route::get('/test', function () {
//     $recipient = auth()->user();

//     // Membuat notifikasi dan menambahkan Broadcasting
//     Notification::make()
//         ->title('sending test')
//         ->body('This is a test notification')
//         ->sendToDatabase($recipient)
//         ->broadcast($recipient); // Menggunakan broadcasting

//     dd('done');
// });
