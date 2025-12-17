<?php
//$scanModule = array_diff(scandir(root_path('module')), array('.', '..')) ?? [];
$scanModule = array_diff(scandir(root_path().'\application\module\\'), array('.', '..')) ?? [];
//dd($scanModule);
foreach($scanModule as $index => $dir) {
    Route::group([
        'module_name' => strtolower($dir),
        'prefix' => 'module/'.strtolower($dir),
        'namespace' => 'Module\\'.$dir.'\Controllers',
        'as' => 'module_'.strtolower($dir).'_',
        'show_for' => $dir,
        'middleware' => ['auth', 'user']
    ], function () use($dir, $index)  {
        //include_once root_path('module\\'.strtolower($dir).'\routes\routes.php');
		include_once root_path() .  ("\application\module\\".$dir."\\routes\\routes.php");
		
    });
}

?>
