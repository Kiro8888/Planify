<?php

  // file: controllers/LoginController.php
  require_once('models/UserModel.php');
  
  class LoginController extends Controller {

    public function showLoginForm() {
      return view('Auth/login',
        ['error'=>false,'login'=>Auth::check(),'id' => Auth::id()]);
    }

    public function login() {
      $email = Input::get('email');   
      $password = Input::get('password');
      $user = UserModel::where('email', $email)->first();
      if (!$user) {
        return redirect('/loginFails');
      }
      if (Auth::attempt(['email' => $email, 'password' => $password])) {
        return redirect('/boards');
      }
      return redirect('/loginFails');
    }
    
    
    public function loginFails() {
      return view('Auth/login',
        ['error'=>true,'login'=>Auth::check()]);
    }

    public function logout() {
      Auth::logout();
      return redirect('/');
    }
  }
?>