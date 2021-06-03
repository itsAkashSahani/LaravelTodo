<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function LoginPage() {
        return view('loginPage');
    }
    
    public function RegisterPage() {
        return view('registerPage');
    }
    
    public function CreateUser(Request $request) {
        $data = $request -> all();

        $name = "/^[a-zA-Z ]+$/";
        $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
        $number = "/^[0-9]+$/";

        $uname = $data['uname'];
        $email = $data['email'];
        $contact = $data['contact'];
        $password = $data['password'];
        $cpassword = $data['cpassword'];

        
        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>this $email is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($name, $uname)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>this $uname is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($number, $contact)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number $contact is not valid</b>
                </div>
            ";
            exit();
        }
        if (!(strlen($contact) == 10)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number must be 10 digit</b>
                </div>
            ";
            exit();
        }
        if (strlen($password) < 9) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password is weak</b>
                </div>
            ";
            exit();
        }
        if ($password != $cpassword) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password Mismatch</b>
                </div>
            ";
            exit();
        }
        
        try {
            $user = new User();
            $user->name = $uname;
            $user->email = $email;
            $user->contact = $contact;
            $user->password = Hash::make($password);
            $user->save();
            $request->session()->put('username', $user->name);
            $request->session()->put('uid', auth()->user()->id);

            echo "success";
        }

        catch (Exception $e) {
            echo "error";
        }
    }

    public function CheckUser(Request $request) {
        $data = $request -> all();
        $email = $data['email'];
        $password = $data['password'];
        $query = User::where(['email' => $email]);
        $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";

        if (!preg_match($emailValidation, $email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>this $email is not valid..!</b>
                </div>
            ";
            exit();
        }

        if (strlen($password) < 9) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password is weak</b>
                </div>
            ";
            exit();
        }
        
        if ($query -> exists()) {
            $check = Hash::check($password, $query -> first() -> password);
            if ($check) {
                echo 'success';
                $request->session()->put('username', $query -> first() -> name);
                $request->session()->put('uid', $query -> first() -> id);
            }
            else {
                echo "
                    <div class='alert alert-danger'>
                        <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                        <b>Password Not Match</b>
                    </div>
                ";
            }
        }
        else {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Account Not Exist!! Create Account First</b>
                </div>
                ";
        }
        
    }

    public function ShowProfile() {
        $query = User::where('id', session()->get('uid'))->get()->all();
        return view('profile') -> with('query', $query);
    }

    public function UpdateDetails(Request $request) {
        $data = $request -> all();
        $id = $data['id'];
        $uname = $data['uname'];
        $contact = $data['contact'];
        $password = bcrypt($data['password']);

        $name = "/^[a-zA-Z ]+$/";
        $number = "/^[0-9]+$/";

        if (!preg_match($name, $uname)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>this $uname is not valid..!</b>
                </div>
            ";
            exit();
        }
        if (!preg_match($number, $contact)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number $contact is not valid</b>
                </div>
            ";
            exit();
        }
        if (!(strlen($contact) == 10)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number must be 10 digit</b>
                </div>
            ";
            exit();
        }
        if (strlen($password) < 9) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Password is weak</b>
                </div>
            ";
            exit();
        }

        if ($password == '') {
            $query = User::where('id', $id)->update(['name' => $uname, 'contact' => $contact]);
            echo 'success';
        }
        else {
            $query = User::where('id', $id)->update(['name' => $uname, 'contact' => $contact, 'password' => $password]);
            echo 'success';
        }

    }

    public function Logout() {
        session()->flush();
        Auth::logout();
        return redirect('loginPage');
    }
}
