<?php

//'middleware' => ['admin']
Route::group([
    'prefix' => 'admin/',
    'namespace' => 'App\Http\Controllers\Backend',
    'as' => 'backend_',
    'middleware' => ['auth', 'user']
], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    /** Role */
    Route::group(['key' => 'Role', 'prefix' => 'role', 'as' => 'role_'], function(){
        Route::get('/manage', ['uses'=>'RoleController@index', 'title' =>'Manage Roles', 'show' => 'Yes', 'position' => 'Left'])->name('index');
        Route::get('/create', ['uses'=>'RoleController@create', 'title' => 'Add', 'show' => 'Yes', 'position' => 'Left'])->name('create');
        Route::post('/store', 'RoleController@store')->name('store');
        Route::get('/edit/{id}', ['uses'=>'RoleController@edit', 'title'=>'Edit'])->name('edit');
        Route::post('/update', 'RoleController@update')->name('update');
        Route::delete('/delete/{id}', ['uses'=>'RoleController@destroy','title'=> 'Delete'])->name('destroy');
    });

    /** User */

    Route::group(['key' => 'User', 'prefix' => 'user', 'as' => 'user_'], function(){
        Route::get('/manage', ['uses'=>'UserController@index', 'title' => 'Manage Users', 'show' => 'Yes', 'position' => 'Left'])->name('index');
        Route::get('/create', ['uses'=>'UserController@create', 'title' => 'Add', 'show' => 'Yes', 'position' => 'Left'])->name('create');
        Route::post('/store', 'UserController@store')->name('store');
        Route::get('/edit/{id}', ['uses' => 'UserController@edit', 'title' =>'Edit'])->name('edit');
        Route::post('/update', 'UserController@update')->name('update');
        Route::delete('/delete/{id}', ['uses'=>'UserController@destroy', 'title' => 'Delete'])->name('destroy');


        //Api
        Route::get('/api/getuser', 'UserController@apiGetUser')->name('api_getuser');
    });

    /** Routelist */

    Route::group(['key' => 'Routelist', 'prefix' => 'routelist', 'as' => 'routelist_'], function(){
        Route::get('/manage', ['uses'=>'RoutelistController@index','title' => 'Manage Route', 'show' => 'Yes', 'position' => 'Left'])->name('index');
        Route::get('/create', ['uses'=>'RoutelistController@create', 'title' => 'Add', 'show' => 'Yes', 'position' => 'Left'])->name('create');
        Route::post('/store', 'RoutelistController@store')->name('store');
        Route::get('/edit/{id}', ['uses'=>'RoutelistController@edit', 'title' => 'Edit'])->name('edit');
        Route::post('/update', 'RoutelistController@update')->name('update');
        Route::delete('/delete/{id}', ['uses'=>'RoutelistController@destroy','title' => 'Delete'])->name('destroy');
        Route::post('/updateorder', ['uses' => 'RoutelistController@updateOrder'])->name('updateorder');

        //Api
        Route::get('/api/get', 'RoutelistController@apiGet')->name('api_get');
    });



     //Media
    Route::group(['key' => 'Media', 'prefix' => 'media', 'as' => 'media_'], function(){
        Route::get('/all', ['uses'=>'MediaController@index', 'title' => 'Manage Media', 'show' => 'Yes', 'position' => 'Left'])->name('index');
        Route::post('/store', ['uses'=> 'MediaController@store'])->name('store');
        Route::post('/store/noajax', ['uses'=> 'MediaController@storeMedia'])->name('store_noajax');
        Route::get('/get', ['uses'=> 'MediaController@getMedia'])->name('get');
        Route::get('/delete/{id}', ['uses'=> 'MediaController@destroy'])->name('delete');
    });

    /**
     * Dynamic Post Type && Term Taxonomy
     */
    //Post
    foreach ((new \App\Models\Term)->getAll() as $item) {
        Route::group(['key' => $item->name,], function() use($item) {
            //Post
            Route::group(['prefix' => $item->slug, 'param' => [$item->slug], 'as' => 'term_type_'], function() use($item) {
                Route::get('/term_type={type}/all', ['uses' => 'PostController@index', 'title' => 'Manage ' . $item->name, 'show' => 'Yes', 'position' => 'Left'])->name('index'.$item->slug);
                Route::get('/term_type={type}/create', ['uses' => 'PostController@form', 'title' => 'Add '. $item->name, 'show' => 'Yes', 'position' => 'Left'])->name('form'.$item->slug);
                Route::post('/term_type={type}/store', ['uses' => 'PostController@store'])->name('store'.$item->slug);
                Route::get('/term_type={type}/edit/{id}', ['uses' => 'PostController@form', 'title' => 'Edit '. $item->name])->name('edit'.$item->slug);
                Route::post('/term_type={type}/update', ['uses' => 'PostController@update'])->name('update'.$item->slug);
                Route::delete('/term_type={type}/delete/{id}', ['uses' => 'PostController@destroy', 'title' => 'Delete '. $item->name])->name('delete'.$item->slug);

                Route::post('/term_type={type}/updateorder', ['uses' => 'PostController@updateOrder'])->name('updateorder'.$item->slug);
                //Api
                Route::get('/term_type={type}/api-get', 'PostController@apiGet')->name('api_get'.$item->slug);
                //EndApi
                Route::get('/term_type={type}/all/taxonomy={taxonomy}/category={categoryid}', ['uses' => 'PostController@index'])->name('index_by_category'.$item->slug);
                /** Custom field Data Store */
                Route::post('/term_type={type}/field/store', ['uses' => 'PostController@customFieldDataStore'])->name('custom_field_data_store'.$item->slug);
            });

            //Categories
            foreach (\App\Models\TermTaxonomy::where('term_type', $item->slug)->get() as $tax) {
                Route::group(['prefix' => $item->slug, 'param' => [$item->slug, $tax->slug], 'as' => 'taxonomy_type_'], function() use($item, $tax) {
                    Route::get('/term_type={type}/taxonomy={taxonomy}/all', ['uses'=>'CategoryController@index','title' => 'Manage '.$tax->name, 'show' => 'Yes', 'position' => 'Left'])->name('index'.$tax->slug);
                    Route::post('/term_type={type}/taxonomy={taxonomy}/create', ['uses' => 'CategoryController@index', 'title' => 'Add '.$tax->name])->name('create'.$tax->slug);
                    Route::post('/term_type={type}/taxonomy={taxonomy}/store', ['uses' => 'CategoryController@store'])->name('store'.$tax->slug);
                    Route::get('/term_type={type}/taxonomy={taxonomy}/edit/{id}', ['uses' => 'CategoryController@index', 'title' => 'Edit '.$tax->name])->name('edit'.$tax->slug);
                    Route::post('/term_type={type}/taxonomy={taxonomy}/update', ['uses' => 'CategoryController@update'])->name('update'.$tax->slug);
                    Route::delete('/term_type={type}/taxonomy={taxonomy}/delete/{id}', ['uses' => 'CategoryController@destroy', 'title' => 'Delete '.$tax->name])->name('delete'.$tax->slug);
                });
            } // End Categories
        });
    }

    /**
     * Settings
     */
     Route::group(['key' => 'Settings', 'prefix' => 'setting', 'as' => 'setings_'], function(){
         // Term taxonomy Custom Field
         Route::group(['prefix' => 'post-type',  'as' => 'posttype_taxonomy_'], function(){
             Route::get('/generate', ['uses'=>'PosttypeController@index', 'title' => 'Custom Post Type', 'show' => 'yes', 'position' => 'Left'])->name('index');
             Route::post('/store', ['uses'=>'PosttypeController@store'])->name('store');
         });
     });
});
