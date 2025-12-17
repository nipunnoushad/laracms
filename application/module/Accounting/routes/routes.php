<?php
Route::get('/index',  ['uses' => 'AccountingController@index', 'title' => 'Accounting Index', 'show' => 'Yes', 'position' => 'Left'])->name('index');
Route::get('/sales',  ['uses' => 'AccountingController@sales', 'title' => 'Sales', 'show' => 'Yes', 'position' => 'Left'])->name('sales');

