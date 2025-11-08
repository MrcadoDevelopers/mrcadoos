<?php
use Illuminate\Support\Facades\Route;

Route::get('/erp/ping', function(){
    return ['pong' => 'erp'];
});