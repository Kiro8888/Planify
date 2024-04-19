<?php
  // file: controllers/ProfessorController.php
  require_once('models/UserModel.php');
  class UserController extends Controller {

    public function index() {  
      return view('user/index',
       ['users'=>DB::table('users')->get(),
        'title'=>'Users List','login'=>Auth::check()]);
    }

    public function show($id) {
      $user = DB::table('users')->find($id);
      return view('user/details',
        ['user'=>$user,
         'title'=>'User Detail',
         'show'=>true,'create'=>false,'edit'=>false,
		 'login'=>Auth::check()]);
    }

    public function create() {
      if (!Auth::check()) return redirect('/login');
      $user = ['name'=>'','email'=>'',
                 'password'=>''];
      return view('user/details',
        ['title'=>'User Create',
		'user'=>$user,'courses'=>false,
        'show'=>false,'create'=>true,'edit'=>false,
		'login'=>Auth::check()]);
    }

    public function store($param1 = null) {
	  if (!Auth::check()) return redirect('/login');
      $name = Input::get('name');
      $email = Input::get('email');
      $password = Input::get('password');
      $user = ['name'=>$name, 'email'=>$email,'password'=>$password];
      DB::table('users')->insert($user);
      return redirect('/user');
    }

    public function edit($id) {
	  if (!Auth::check()) return redirect('/login');
      $user = DB::table('users')->find($id);
      return view('user/details',
        ['user'=>$user,
         'title'=>'User Edit','courses'=>false,
         'show'=>false,'create'=>false,'edit'=>true,
		 'login'=>Auth::check()]);
    }

    public function update($_, $id = NULL) {
	  if (!Auth::check()) return redirect('/login');
      $name = Input::get('name');
      $email = Input::get('email');
      $password = Input::get('password');
      $user = ['name'=>$name,'email'=>$email,'password'=>$password];
      DB::table('users')->update($id,$user);
      return redirect('/user');
    }

    public function destroy($id) {
	  if (!Auth::check()) return redirect('/login');
      DB::table('users')->delete($id);
      return redirect('/user');
    }
  }
?>