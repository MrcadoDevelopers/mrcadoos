<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test-event', function(){
    $bus = app(\Mos\Kernel\Contracts\EventBusInterface::class);
    $bus->subscribe('test.hi', function($event){
        \Log::info('Event received: '.json_encode($event));
    });
    $bus->publish('test.hi', ['msg'=>'hello']);
    return 'published';
});
