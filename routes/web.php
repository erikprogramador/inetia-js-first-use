<?php

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Laravel way
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function () {
    $messages = Message::all();
    return view('about', compact('messages'));
});

// Inertia way
Route::get('/hello', function () {
    $messages = Message::orderBy('id', 'DESC')->get();
    return inertia('Hello', compact('messages'));
});

Route::post('/messages', function (Request $request) {
    sleep(2);
    $validated = $request->validate([
        'message' => ['required', 'min:10'],
    ]);
    Message::create([
        'text' => $validated['message'],
    ]);
    return redirect('/hello');
})->name('messages.store');
