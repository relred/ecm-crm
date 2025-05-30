<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/subcoordinators/{coordinator}', function ($coordinator) {
    return \App\Models\User::where('parent_id', $coordinator)->where('role', 'subcoordinator')->get();
});

Route::get('/promoters/{subcoordinator}', function ($subcoordinator) {
    return \App\Models\User::where('parent_id', $subcoordinator)->where('role', 'promoter')->get();
});
