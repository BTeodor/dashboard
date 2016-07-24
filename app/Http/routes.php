<?php

        Route::get('/', ['as'=>'frontend.index','uses'=>'Frontend\HomeController@home']);

        Route::get('login', ['as'=>'login','uses'=>'Auth\AuthController@getLogin']);    //----------ok
        Route::post('login', 'Auth\AuthController@postLogin');      //----------ok
        Route::get('logout', ['as' => 'auth.logout','uses' => 'Auth\AuthController@getLogout']);        //----------ok

        if (Setting::get('reg_enabled')) {
            Route::get('register', ['as'=>'register','uses'=>'Auth\AuthController@getRegister']);   //----------ok
            Route::post('register', 'Auth\AuthController@postRegister');        //----------ok
            Route::get('register/confirmation/{token}', ['as' => 'register.confirm-email','uses' => 'Auth\AuthController@confirmEmail']);   //----------ok
        }

        if (Setting::get('forgot_password')) {
            Route::get('password/remind', 'Auth\PasswordController@forgotPassword');        //----------ok
            Route::post('password/remind', 'Auth\PasswordController@sendPasswordReminder');
            Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
            Route::post('password/reset', 'Auth\PasswordController@postReset');
        }

        Route::get('auth/{provider}/login', ['as' => 'social.login','uses' => 'Auth\SocialAuthController@redirectToProvider','middleware' => 'social.login']);
        Route::get('auth/{provider}/callback', 'Auth\SocialAuthController@handleProviderCallback');
        Route::get('auth/twitter/email', 'Auth\SocialAuthController@getTwitterEmail');
        Route::post('auth/twitter/email', 'Auth\SocialAuthController@postTwitterEmail');


        Route::group(['prefix'=>'dashboard','middleware' => ['role:Admin']], function () {
            Route::get('/', ['as' => 'dashboard','uses' => 'Dashboard\DashboardController@index']);   //----------ok

            Route::get('profile', ['as' => 'profile','uses' => 'Dashboard\ProfileController@index']);  //----------ok
            Route::put('profile/details/update', ['as' => 'profile.update.details','uses' => 'Dashboard\ProfileController@updateDetails']);  //----------ok
            Route::post('profile/avatar/update', ['as' => 'profile.update.avatar','uses' => 'Dashboard\ProfileController@updateAvatar']);   //----------ok
            Route::post('profile/avatar/update/external', ['as' => 'profile.update.avatar-external','uses' => 'Dashboard\ProfileController@updateAvatarExternal']);  //----------ok
            Route::put('profile/login-details/update', ['as' => 'profile.update.login-details','uses' => 'Dashboard\ProfileController@updateLoginDetails']);
            Route::put('profile/social-networks/update', ['as' => 'profile.update.social-networks','uses' => 'Dashboard\ProfileController@updateSocialNetworks']);  //----------ok


            Route::get('user', ['as' => 'user.list','uses' => 'Dashboard\UsersController@index']);   //-----ok
            Route::get('user/create', ['as' => 'user.create','uses' => 'Dashboard\UsersController@create']);   //-----ok
            Route::post('user/create', ['as' => 'user.store','uses' => 'Dashboard\UsersController@store']);     //-----ok
            Route::get('user/{user_id}/show', ['as' => 'user.show','uses' => 'Dashboard\UsersController@view']);    //-----ok
            Route::get('user/{user_id}/edit', ['as' => 'user.edit','uses' => 'Dashboard\UsersController@edit']);    //-----ok
            Route::put('user/{user_id}/update/details', ['as' => 'user.update.details','uses' => 'Dashboard\UsersController@updateDetails']);  //-----ok
            Route::put('user/{user_id}/update/login-details', ['as' => 'user.update.login-details','uses' => 'Dashboard\UsersController@updateLoginDetails']);
            Route::delete('user/{user_id}/delete', ['as' => 'user.delete','uses' => 'Dashboard\UsersController@delete']);    //-----ok
            Route::post('user/{user_id}/update/avatar', ['as' => 'user.update.avatar','uses' => 'Dashboard\UsersController@updateAvatar']);    //-----ok
            Route::post('user/{user_id}/update/avatar/external', ['as' => 'user.update.avatar.external','uses' => 'Dashboard\UsersController@updateAvatarExternal']);    //-----ok
            Route::post('user/{user_id}/update/social-networks', ['as' => 'user.update.socials','uses' => 'Dashboard\UsersController@updateSocialNetworks']);  //-----ok


            Route::get('role', ['as' => 'role.index','uses' => 'Dashboard\RolesController@index']);     //-----ok
            Route::get('role/create', ['as' => 'role.create','uses' => 'Dashboard\RolesController@create']);    //-----ok
            Route::post('role/store', ['as' => 'role.store','uses' => 'Dashboard\RolesController@store']);      //-----ok
            Route::get('role/{role_id}/edit', ['as' => 'role.edit','uses' => 'Dashboard\RolesController@edit']);    //-----ok
            Route::put('role/{role_id}/update', ['as' => 'role.update','uses' => 'Dashboard\RolesController@update']);      //-----ok
            Route::delete('role/{role_id}/delete', ['as' => 'role.delete','uses' => 'Dashboard\RolesController@delete']);   //-----ok
            Route::post('permission/save', ['as' => 'dashboard.permission.save','uses' => 'Dashboard\PermissionsController@saveRolePermissions']);  //-----ok
            Route::get('permission', ['as' => 'dashboard.permission.index','uses' => 'Dashboard\PermissionsController@index']); //-----ok
            Route::get('permission/create', ['as' => 'dashboard.permission.create','uses' => 'Dashboard\PermissionsController@create']);  //-----ok
            Route::post('permission/store', ['as' => 'dashboard.permission.store','uses' => 'Dashboard\PermissionsController@store']);  //-----ok
            Route::get('permission/{permission_id}/edit', ['as' => 'dashboard.permission.edit','uses' => 'Dashboard\PermissionsController@edit']);      //-----ok
            Route::put('permission/{permission_id}/update', ['as' => 'dashboard.permission.update','uses' => 'Dashboard\PermissionsController@update']);        //-----ok
            Route::delete('permission/{permission_id}/delete', ['as' => 'dashboard.permission.destroy','uses' => 'Dashboard\PermissionsController@destroy']);    //-----ok

            Route::get('settings', ['as' => 'settings.general','uses' => 'Dashboard\SettingsController@general']);  //-----ok
            Route::post('settings/general', ['as' => 'settings.general.update','uses' => 'Dashboard\SettingsController@update']);   //-----ok
            Route::get('settings/auth', ['as' => 'settings.auth','uses' => 'Dashboard\SettingsController@auth']);       //-----ok
            Route::post('settings/auth', ['as' => 'settings.auth.update','uses' => 'Dashboard\SettingsController@update']);     //-----ok
            Route::post('settings/auth/registration/captcha/enable', ['as' => 'settings.registration.captcha.enable','uses' => 'Dashboard\SettingsController@enableCaptcha']);  //-----ok
            Route::post('settings/auth/registration/captcha/disable', ['as' => 'settings.registration.captcha.disable','uses' => 'Dashboard\SettingsController@disableCaptcha']);   //-----ok
            Route::get('settings/notifications', ['as' => 'settings.notifications','uses' => 'Dashboard\SettingsController@notifications']);        //-----ok
            Route::post('settings/notifications', ['as' => 'settings.notifications.update','uses' => 'Dashboard\SettingsController@update']);       //-----ok

            Route::get('activity', ['as' => 'activity.index','uses' => 'Dashboard\ActivityController@index']);      //-----ok
            Route::get('activity/user/{user_id}/log', ['as' => 'activity.user','uses' => 'Dashboard\ActivityController@userActivity']);     //-----ok

            Route::group(['prefix' => 'log-viewer'], function () {
                Route::get('/', ['as' => 'log-viewer::dashboard','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@index']);     //-----ok
                Route::group(['prefix' => 'logs',], function () {
                    Route::get('/', ['as' => 'log-viewer::logs.list','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@listLogs']);  //-----ok
                    Route::delete('delete', ['as' => 'log-viewer::logs.delete','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@delete']);  //-----ok
                });
                Route::group(['prefix' => '{date}'], function () {
                    Route::get('/', ['as' => 'log-viewer::logs.show','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@show']);      //-----ok
                    Route::get('download', ['as' => 'log-viewer::logs.download','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@download']);   //-----ok
                    Route::get('{level}', ['as' => 'log-viewer::logs.filter','uses' => '\Arcanedev\LogViewer\Http\Controllers\LogViewerController@showByLevel']);   //-----ok
                });
            });



        });
