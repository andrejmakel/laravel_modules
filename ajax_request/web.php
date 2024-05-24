<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {

    Route::get('/ajax-request/{incoming_data}', 'Controller@ajaxRequest');

});