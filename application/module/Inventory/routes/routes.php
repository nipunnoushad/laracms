<?php
Route::get('index',  ['uses' => 'AccountingController@index', 'title' => 'Inventory Index', 'show' => 'Yes', 'position' => 'Left'])->name('index');

