<?php
Route::group(['prefix'=> '/system', 'namespace'=> 'App\Http\Controllers', 'as' => ''], function(){

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
    
    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');

    // Password Reset Routes...
    Route::get('reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
  
});

Route::group(['prefix'=> '/auth', 'namespace'=> 'App\Http\Controllers\Frontend', 'as' => 'frontend_'], function(){
  /** FrontEnd Login */
  Route::get('signin', 'CustomerController@login')->name('login');
  Route::post('signin', 'CustomerController@doLogin')->name('login');
  Route::get('signup', 'CustomerController@register')->name('register');
  Route::post('signup', 'CustomerController@doRegister')->name('register');
  Route::get('checkUserEmailExists', 'CustomerController@checkUserEmailExists')->name('checkUserEmailExists');
  Route::get('signout', 'CustomerController@logout')->name('logout');
  Route::get('{current_session_id}/dashboard', 'CustomerController@dashboard')->name('dashboard');

  //customer
  Route::post('auth/profile/update', 'customerController@accountUpdate')->name('profile_update');
  Route::post('auth/address/update', 'customerController@AddressUpdate')->name('address_update');
});