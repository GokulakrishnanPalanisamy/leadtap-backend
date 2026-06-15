<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('enquiry')->group(function () {

    Route::post('/', 'App\Http\Controllers\EnquiryController@createEnquiry')
        ->name('enquiry.store')
        ->middleware(('throttle:5,1'));

    Route::get('/{uuid}', 'App\Http\Controllers\EnquiryController@getEnquiry');

});

Route::get('/enquiries', 'App\Http\Controllers\EnquiryController@getEnquiries');

Route::post('/webhook/crm', 'App\Http\Controllers\WebhookController@updateStatus');

Route::get('sync-wp', 'App\Http\Controllers\WPController@syncWPContent');

Route::prefix('properties')->group(function () {
    Route::get('/', 'App\Http\Controllers\PropertyController@getProperties');
});
