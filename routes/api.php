<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/coba', function () {
    return response()->json(['status' => 'API routes are working']);
});

Route::get('/json-data', function () {
    return response()->json([
        ['id' => 1, 'name' => 'Item A', 'price' => 1000],
        ['id' => 2, 'name' => 'Item B', 'price' => 2000],
        ['id' => 3, 'name' => 'Item C', 'price' => 3000]
    ]);
});

// HTTP request ke API eksternal
Route::get('/fetch-posts', function () {
    $response = Http::get('https://jsonplaceholder.typicode.com/posts');
    return response()->json($response->json());
});

Route::middleware(\App\Http\Middleware\ValidateHeaders::class)->group(function () {
    Route::get('/getData', function () {
        return response()->json(['message' => 'GET request berhasil']);
    });
    Route::post('/postData', function (Request $request) {
        return response()->json(['message' => 'POST request berhasil', 'data' => $request->all()]);
    });
});