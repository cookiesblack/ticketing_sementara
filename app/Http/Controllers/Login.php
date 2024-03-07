<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;

class Login extends Controller
{
    public function index()
    {
        $data = [];
        return view("login", $data);
    }

    public function logincheck(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $userProfile = User::where(["email" => $username, "password" => $password])->selectRaw('*')->get();
        // echo $userProfile;
        if (empty($userProfile[0]->email)) {
            // return redirect()->route('login');
            return back()->withErrors('Wrong Username/Password');
        } else {
            $userSession = [
                "id" => $userProfile[0]->id,
                "fullname" => $userProfile[0]->fullname,
                "email" => $userProfile[0]->email,
                "type" => $userProfile[0]->type
            ];
            // print_r($userSession);
            session($userSession);
            return redirect()->route('dashboard');
            // $userProfile[0]->tipe;
        }

        // print_r($userProfile);
        // return redirect()->route('pariwisata');
    }

    public function logout()
    {
        session_unset();
        Session::flush();

        return redirect()->route('login');
    }
}
