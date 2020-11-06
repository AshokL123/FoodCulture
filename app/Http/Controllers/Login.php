<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Mail;
use Session;
use App\Admin_model as admin_m;

class Login extends Controller
{
    public function __construct()
    {
    }

    public function login_process(Request $request){
        
        $email = $request->email;
        $password = $request->password;
        
        $get_admin = admin_m::where('admin_email',$email)->orWhere('admin_password',$password)->first();
        if(!is_null($get_admin)){
            if($email != $get_admin->admin_email){
                echo 2;
            }else if($password != $get_admin->admin_password){
                echo 3;
            }else{
                $timezone = 'Asia/Kolkata';
                if ($request->timezone != '' && $request->timezone != 'Asia/Culcatta' ) {
                   $timezone = $request->timezone;
                }
                session(['admin_id' => $get_admin->admin_id, 'timezone' => $timezone]);
                echo 0;
            }
        }else{
            echo 1;
        }
    }

    public function change_password(Request $request){
        if(session('admin_id') == ''){
            return redirect('/admin');
        }else{
            $old_password = $request->old_password;
            $new_password = $request->new_password;

            $admin_id = session('admin_id');
            $get_admin = admin_m::where('admin_id',$admin_id)->first();
            if(count($get_admin)>0){
                if($old_password == $get_admin->admin_password){
                    $data = ['admin_password' => $new_password];
                    admin_m::where('admin_id',$admin_id)->update($data);
                    echo 0;
                }else{
                    echo 3;
                }
            }else{
                echo 1;
            }
        }
    }

    public function forgot_password(Request $request){
        $email = $request->email;
        $get_email = admin_m::where('admin_email',$email)->first();
        if(!is_null($get_email)){
            $data = array('email' => $email, 'name'=> $get_email->admin_email,'password' => $get_email->admin_password);
             $mail = Mail::send('mail_forgot_password', $data, function($message) use($email){
                 $message->to($email,'admin')->subject
                    ('Forgot Password');
                 $message->from('test@gmail.com','FoodCulture App');
              });
            echo "1";
        }else{
            echo "4";
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_id');
        Session::flush();
        return redirect('/admin');
    }
}
