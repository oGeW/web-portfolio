<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;

class LoginController extends Controller
{
    public function loginPage() {
        return view('login');
    }

    public function login(Request $request) {
        $id = $request->id;
        $password=$request->password;
        $credentials=['uid'=>$id, 'password'=>$password];

        if(!Auth::attempt($credentials)){
            echo "<script>alert('로그인 정보가 일치하지 않습니다')</script>";
            return view('login');
        }
        return redirect()->route('mypage', ['login'=>auth()->user()]);
    }

    public function findForm() {
        return view('findForm');
    }

    public function findId(Request $request) {
        $name=$request->name;
        $phone=$request->phone;

        $isExist=User::select('uid')->where('name', $name)->where('phone', $phone)->exists();

        if(!$isExist) {
            echo "<script>alert('가입 정보가 없습니다')</script>";
            return redirect()->route('register');
        } else {
            $id=User::select('uid')->where('name', $name)->where('phone', $phone)->pluck('uid');
        }

        return view('findIdresult', ['result'=>$id, 'name'=>$name]);
    }

    public function findPwd(Request $request) {
        $name=$request->name;
        $id=$request->id;
        $phone=$request->phone;

        $id=User::select('uid')->where('name', $name)->where('phone', $phone)->pluck('uid');

        dd($id);
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('main');
    }
}
