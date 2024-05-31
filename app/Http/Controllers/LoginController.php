<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;


class LoginController extends Controller
{
  public function index()
  {
    return view('login.index');
  }
  
  protected function credentials(Request $request)
  {
      $email = filter_var($request->email, FILTER_SANITIZE_EMAIL);
      $password = $request->password;
  
      return ['email' => $email, 'password' => $password];
  }
  
  public function login(Request $request)
  {
    $request->validate([
      'username' => ['required', 'string', 'max:255'],
      'email' => 'required|string|email|max:255',
      'password' => 'required|string|min:8',
    ]);

    $username = $request->input('username');
    $email = $request->input('email');
    $password = $request->input('password');

    $user = Account::where('username', $username)->first();

    if ($user && $password === $user->password) {
      if ($username === 'Admin') {
        return redirect()->route('admin.index');
      } else {
        return redirect()->route('note.index', ['account_id' => $user->account_id]);
      }
    } else {
      return redirect()->route('login.index')->withErrors(['error' => 'Invalid username or password']);
    }
  }
}

