<?php



      Route::get('/', function () { return view('/Index', ['title'=>'Welcome','login'=>Auth::check()]); });

      // BOARDS
      Route::resource('boards', 'BoardController', ['login' => Auth::check()]);
      Route::get('/boards','BoardController@index',['login'=>Auth::check()]);
      Route::get('/boards/(:number)/delete','BoardController@destroy');
      Route::get('/boards/search', 'BoardController@search');


      // TASK
      Route::resource('tasks','TaskController', ['login' => Auth::check()]);
      Route::get('/boards/{board_id}/tasks', 'TaskController@index',['login'=>Auth::check()]);
      Route::get('/tasks/(:number)/delete','TaskController@destroy');
      // USER
      Route::resource('/user', 'UserController', ['login' => Auth::check()]);
      Route::get('/user/(:number)/delete','UserController@destroy');
      Route::get('/user','UserController@index', ['login' => Auth::check()]);


      // Authentication Routes  
       Route::get('login', 'LoginController@showLoginForm');
      Route::get('loginFails','LoginController@LoginFails');           
      Route::post('login', 'LoginController@login');  
      Route::get('logout', 'LoginController@logout');  

      // Registration Routes  
  Route::get('register','RegisterController@showRegistrationForm');  
  Route::post('register', 'RegisterController@register');





// 



// Route::get('/', function () { return view('/Index'); });

Route::dispatch();
?>