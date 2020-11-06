<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use DateTime;
use Crypt;
use Mail;
use App\Authentication_model as auth_m;
use App\User_model as user_m;
use App\Category_model as category_m;
use App\Comment_model as comment_m;
use App\Favorite_model as favorite_m;
use App\Ingredients_model as ingredients_m;
use App\Purchase_model as purchase_m;
use App\Rate_model as rate_m;
use App\Recipe_model as recipe_m;
use App\Shopping_list_model as shopping_list_m;
use App\List_item_model as list_item_model_m;
use App\Subscription as subscr_m;
use App\User_notes_model as user_notes_m;
use App\Recipe_image_model as recipe_image_m;


class UserController extends Controller
{

    
    public function user_registration(Request $request){
        
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $age = $request->age;
        $gender = $request->gender;
        $email = $request->email;
        $password = $request->password;
        $ethnicity = $request->ethnicity;
        $login_type = $request->login_type;
        $social_id = $request->social_id;
        $device_token = $request->device_token;
        $device_type = $request->device_type;

        if($first_name == ""){
            return response()->json(['status' => false,'message'=>'Please Enter First Name.'], 200);
        }
        

        if($last_name == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Last Name.'], 200);
        }

        if($email == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Email Id.'], 200);
        }

        if($login_type == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Social Login Type.'], 200);
        }

        $useremail_exist = user_m::where('email',$email)->first();
        /*regular registration */
        if($login_type == 'regular'){
            if($age == ""){
                return response()->json(['status' => false,'message'=>'Please Enter Age.'], 200);
            }

            if($gender == ""){
                return response()->json(['status' => false,'message'=>'Please Select Gender.'], 200);
            }

            if($ethnicity == ""){
                return response()->json(['status' => false,'message'=>'Please Select ethnicity.'], 200);
            }

            if($password == ""){
                return response()->json(['status' => false,'message'=>'Please Enter Password.'], 200);
            }
        
            if(is_null($useremail_exist)){
                $password = Crypt::encrypt($password);
                $get_free_subsrc = subscr_m::where(['subscription_type' => 'free','is_deleted' => '0'])->first();
                
                    $insert_data = [
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'age' => $age,
                        'gender' => $gender,
                        'ethnicity' => $ethnicity,
                        'email' => $email,
                        'password' => $password,
                        'is_verify_email' => 'not_verify',
                        'login_type' => 'regular',
                        'subscription_id' => $get_free_subsrc->subscription_id,                    
                        'device_token' => $device_token,
                        'device_type' => $device_type,
                     ];

                    $insertid = user_m::create($insert_data);
                    if($insertid){

                        $data = array('email' => $email, 'first_name'=> $first_name, 'user_id'=>$insertid->user_id);
                    
                        $mail = Mail::send('mail_user', $data, function($message) use($email){
                            $message->to($email,'admin')->subject('Verify Email Address');
                            $message->from('test@gmail.com','FoodCulture App');
                        });
                        

                       
                        if(\Mail::failures()) {
                            return response()->json(['status' => false,'statusCode' => '0','message'=>'Mail not sent.'], 200);
                        }
                        
                        
                        
                        
                        $unique_token = $this->getSecureKey();
                        $insert_data_authentication = [
                                'user_id' => $insertid->user_id,
                                'device_type' => $device_type,                     
                                'device_token' => $device_token,                     
                                'unique_token' => $unique_token
                            ];
                        $insertid_authentication = auth_m::create($insert_data_authentication);
                        //print_r($insertid_authentication);die;
                        if($insertid_authentication){
                            $data['Token'] = $insertid_authentication->unique_token;
                            $get_user = user_m::where('user_id',$insertid->user_id)->first();
                            if(!is_null($get_user)){
                                $get_user_detail = user_m::where(['user_id' => $get_user->user_id])->first();
                                $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                                $unique_token = $this->getSecureKey();
                                $edit_data_authentication = [
                                        'device_type' => $device_type,                     
                                        'device_token' => $device_token,                     
                                        'unique_token' => $unique_token
                                    ];
                                $insertid_authentication = auth_m::where(['user_id' => $get_user_detail->user_id,'auth_id' => $get_authentication_user->auth_id ])->update($edit_data_authentication);

                                

                                $data['Token'] = $unique_token;
                                $data['user_id'] = $get_user_detail->user_id;
                                $data['first_name'] = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name;
                                $data['last_name'] = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name;
                                $data['age'] = ($get_user_detail->age == null) ? '' : $get_user_detail->age;
                                $data['gender'] = ($get_user_detail->gender == null) ? '' : $get_user_detail->gender;
                                $data['ethnicity'] = ($get_user_detail->ethnicity == null) ? '' : $get_user_detail->ethnicity;
                                
                                $data['email'] = ($get_user_detail->email == null) ? '' : $get_user_detail->email;
                                $data['login_type'] = ($get_user_detail->login_type == null) ? '' : $get_user_detail->login_type;
                                $data['social_id'] = ($get_user_detail->social_id == null) ? '' : $get_user_detail->social_id;
                                $data['subscription_id'] = ($get_user_detail->subscription_id == null) ? '' : $get_user_detail->subscription_id;
                                $data['device_type'] = ($get_user_detail->device_type == null) ? '' : $get_user_detail->device_type;
                                $data['device_token'] = ($get_user_detail->device_token == null) ? '' : $get_user_detail->device_token; 
                                $data['noti_badge'] =  $get_user_detail->noti_badge; 
                                $data['is_verify_email'] =  $get_user_detail->is_verify_email;   
                                $data['user_status'] = "registration";
                                $data['created_at'] =  $get_user_detail->created_at->toDateString();

                                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Singup Successfully.', 'data' => $data], 200);
                            }
                        }else{
                            return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                        }
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
            }else{
                return response()->json(['status' => false,'statusCode' => "4",'message'=>'Email already exist.'], 200);
            }
        }else{
            /* social login */
            if($social_id == ""){
                return response()->json(['status' => false,'message'=>'Please Enter Social Id.'], 200);
            }
            $get_user = user_m::where(['social_id' => $social_id])->first();
            if(!is_null($get_user)){
                
                $edit_user =[
                    'device_token' => $device_token,
                    'device_type' => $device_type                     
                ];
                $update_user = user_m::where(['user_id' => $get_user->user_id])->update($edit_user);
                if($update_user){
                    $get_user_detail = user_m::where(['user_id' => $get_user->user_id])->first();
                    $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                
                    $unique_token = $this->getSecureKey();
                    $edit_data_authentication = [
                            'device_type' => $device_type,                     
                            'device_token' => $device_token,                     
                            'unique_token' => $unique_token
                        ];
                    $insertid_authentication = auth_m::where(['user_id' => $get_user_detail->user_id,'auth_id' => $get_authentication_user->auth_id])->update($edit_data_authentication);
                    
                    if($insertid_authentication){
                        $data['Token'] = $unique_token;
                        $data['user_id'] = $get_user_detail->user_id;
                        $data['first_name'] = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name;
                        $data['last_name'] = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name;
                        $data['age'] = ($get_user_detail->age == null) ? '' : $get_user_detail->age;
                        $data['gender'] = ($get_user_detail->gender == null) ? '' : $get_user_detail->gender;
                        $data['ethnicity'] = ($get_user_detail->ethnicity == null) ? '' : $get_user_detail->ethnicity;
                        
                        $data['email'] = ($get_user_detail->email == null) ? '' : $get_user_detail->email;
                        $data['login_type'] = ($get_user_detail->login_type == null) ? '' : $get_user_detail->login_type;
                        $data['social_id'] = ($get_user_detail->social_id == null) ? '' : $get_user_detail->social_id;
                        $data['subscription_id'] = ($get_user_detail->subscription_id == null) ? '' : $get_user_detail->subscription_id;
                        $data['device_type'] = ($get_user_detail->device_type == null) ? '' : $get_user_detail->device_type;
                        $data['device_token'] = ($get_user_detail->device_token == null) ? '' : $get_user_detail->device_token; 
                        $data['noti_badge'] =  $get_user_detail->noti_badge; 
                        $data['is_verify_email'] =  $get_user_detail->is_verify_email;   
                        $data['user_status'] = "registration";
                        $data['created_at'] =  $get_user_detail->created_at->toDateString();

                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Singup Successfully.', 'data' => $data], 200);

                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
                }else{
                    return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                }
            }else{
                $get_free_subsrc = subscr_m::where(['subscription_type' => 'free','is_deleted' => '0'])->first();
                if($first_name == 'null'){
                    $first_name = "";
                }
                if($last_name == 'null'){
                    $last_name = "";
                }
                if($email == 'null'){
                    $last_name = "";
                }
                $insert_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'is_verify_email' => 'verify',
                    'login_type' => $login_type,
                    'subscription_id' => $get_free_subsrc->subscription_id,
                    'social_id' => $social_id,                    
                    'device_token' => $device_token,
                    'device_type' => $device_type
                 ];

                $insertid = user_m::create($insert_data);
                if($insertid){
                    $unique_token = $this->getSecureKey();
                    $insert_data_authentication = [
                            'user_id' => $insertid->user_id,
                            'device_type' => $device_type,                     
                            'device_token' => $device_token,                     
                            'unique_token' => $unique_token
                        ];
                    $insertid_authentication = auth_m::create($insert_data_authentication);
                    if($insertid_authentication){
                        $data['Token'] = $insertid_authentication->unique_token;
                        $get_user = user_m::where('user_id',$insertid->user_id)->first();
                        if(!is_null($get_user)){
                            $get_user_detail = user_m::where(['user_id' => $get_user->user_id])->first();
                            $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                            $unique_token = $this->getSecureKey();
                            $edit_data_authentication = [
                                    'device_type' => $device_type,                     
                                    'device_token' => $device_token,                     
                                    'unique_token' => $unique_token
                                ];
                            $insertid_authentication = auth_m::where(['user_id' => $get_user_detail->user_id,'auth_id' => $get_authentication_user->auth_id ])->update($edit_data_authentication);

                            

                            $data['Token'] = $unique_token;
                            $data['user_id'] = $get_user_detail->user_id;
                            $data['first_name'] = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name;
                            $data['last_name'] = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name;
                            $data['age'] = ($get_user_detail->age == null) ? '' : $get_user_detail->age;
                            $data['gender'] = ($get_user_detail->gender == null) ? '' : $get_user_detail->gender;
                            $data['ethnicity'] = ($get_user_detail->ethnicity == null) ? '' : $get_user_detail->ethnicity;
                            
                            $data['email'] = ($get_user_detail->email == null) ? '' : $get_user_detail->email;
                            $data['login_type'] = ($get_user_detail->login_type == null) ? '' : $get_user_detail->login_type;
                            $data['social_id'] = ($get_user_detail->social_id == null) ? '' : $get_user_detail->social_id;
                            $data['subscription_id'] = ($get_user_detail->subscription_id == null) ? '' : $get_user_detail->subscription_id;
                            $data['device_type'] = ($get_user_detail->device_type == null) ? '' : $get_user_detail->device_type;
                            $data['device_token'] = ($get_user_detail->device_token == null) ? '' : $get_user_detail->device_token; 
                            $data['noti_badge'] =  $get_user_detail->noti_badge; 
                            $data['is_verify_email'] =  $get_user_detail->is_verify_email;   
                            $data['user_status'] = "registration";
                            $data['created_at'] =  $get_user_detail->created_at->toDateString();

                            return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Singup Successfully.', 'data' => $data], 200);
                        }
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
                }else{
                    return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                }
            }
        }
    }

    public function email_verification(Request $request,$user_id){

        
        $get_user = user_m::where(['user_id' => $user_id, 'is_deleted' => 0, 'is_verify_email' => 'not_verify'])->first();

        if(!is_null($get_user)){
            
                  
            $edit_data = [
                            'is_verify_email' => 'verify',                    
                        ];
            $update_user_data = user_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->update($edit_data);
            if($update_user_data){
                $get_user_detail = user_m::where(['user_id' => $get_user->user_id])->first();
                $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                $unique_token = $this->getSecureKey();
                $edit_data_authentication = [                     
                    'unique_token' => $unique_token
                ];
                $insertid_authentication = auth_m::where(['user_id' => $get_user_detail->user_id,'auth_id' => $get_authentication_user->auth_id ])->update($edit_data_authentication);

                

                return view('mail_sucess');
            }
        }else{
            return view('mail_sucess');
        }
    }

    /* regular login */
    public function user_login(Request $request){

        $user_email = $request->email;
        $user_password = $request->password;
        $device_token = $request->device_token;
        $device_type = $request->device_type;

        
        if($user_email == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Email.'], 200);
        }

        if($user_password == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Password.'], 200);
        }

        

        $get_user = user_m::where(['email' => $user_email, 'is_deleted' => 0])->first();
        
        
        if(!is_null($get_user)){
            if($get_user->is_verify_email != 'verify'){
                return response()->json(['status' => false,'responseCode' => 1,'message'=>'Please verify your Email.'], 200);
            }
           
            $get_password = Crypt::decrypt($get_user->password);
           
            if($get_password == $user_password){
                    $edit_user =[
                        'device_type' => $device_type,                     
                        'device_token' => $device_token
                    ];
                    $update_user = user_m::where(['user_id' => $get_user->user_id, 'is_verify_email' => 'verify'])->update($edit_user);
                    $get_user_detail = user_m::where(['user_id' => $get_user->user_id,'is_verify_email' => 'verify'])->first();
                    
                    $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                    $unique_token = $this->getSecureKey();
                    $edit_data_authentication = [
                            'device_type' => $device_type,                     
                            'device_token' => $device_token,                     
                            'unique_token' => $unique_token
                        ];
                    $insertid_authentication = auth_m::where(['user_id' => $get_user_detail->user_id,'auth_id' => $get_authentication_user->auth_id ])->update($edit_data_authentication);

                    
                    $data['Token'] = $unique_token;
                    $data['user_id'] = $get_user_detail->user_id;
                    $data['first_name'] = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name;
                    $data['last_name'] = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name;
                    $data['age'] = ($get_user_detail->age == null) ? '' : $get_user_detail->age;
                    $data['gender'] = ($get_user_detail->gender == null) ? '' : $get_user_detail->gender;
                    $data['ethnicity'] = ($get_user_detail->ethnicity == null) ? '' : $get_user_detail->ethnicity;
                    $data['email'] = ($get_user_detail->email == null) ? '' : $get_user_detail->email;
                    $data['login_type'] = ($get_user_detail->login_type == null) ? '' : $get_user_detail->login_type;
                    $data['social_id'] = ($get_user_detail->social_id == null) ? '' : $get_user_detail->social_id;
                    
                    $data['device_type'] = ($get_user_detail->device_type == null) ? '' : $get_user_detail->device_type;
                    $data['device_token'] = ($get_user_detail->device_token == null) ? '' : $get_user_detail->device_token; 
                    $data['noti_badge'] =  $get_user_detail->noti_badge;
                    $data['is_verify_email'] =  $get_user_detail->is_verify_email;
                    
                    $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                    if(!is_null($check_premium_user)){
                       
                        $data['premium_user'] = true;

                    }else{
                        $data['premium_user'] = false;
                    }
                    return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Login Successfully.', 'data' => $data], 200);
                
                
            }else{
                return response()->json(['status' => false,'responseCode' => 2,'message'=>'Email or Password is incorrect.'], 200);
            }

        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'Email does not exist.'], 200);
        }
    }

    public function category_list(Request $request){
        $user_id = $request->header('UserId');

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        if(!is_null($get_user)){
            $get_category = category_m::where(['is_deleted' => 0])->orderBy('cat_order','DESC')->get();
            if(count($get_category) > 0){
                foreach ($get_category as $key_cat => $value_cat) {

                    if($value_cat->category_image != null){
                        $value_cat->category_image = asset("/public/storage/images/category") . "/" . $value_cat->category_image;
                    }else{
                       $value_cat->category_image = "";
                    }
                    unset($value_cat->is_deleted,$value_cat->deleted_at,$value_cat->updated_at);
                    $data[] = $value_cat;

                }
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Category get successfully.', 'data' => $data], 200);
            }else{

                return response()->json(['status' => false,'statusCode' => '0','message'=>"Category not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }

    }

    public function recipe_list(Request $request){
        $user_id = $request->header('UserId');

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $rate_value = [1,2,3,4,5];
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['is_deleted' => 0,'is_hide' => 0])->orderBy('recipe_name')->get();
            if(count($get_recipe) > 0){
                foreach ($get_recipe as $key_recipe => $value_recipe) {
                    $value_recipe->description = ($value_recipe->description == null) ? '' : $value_recipe->description;
                    $get_recipe_image = recipe_image_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0])->orderBy('recipe_image_id','DESC')->get();
                    $data1 = array();
                    if(count($get_recipe_image)>0){

                     foreach ($get_recipe_image as $key_image => $value_image) {
                            if($value_image->recipe_image_name != null){
                                $value_image->recipe_image_name = asset("/public/storage/images/recipe_image") . "/" . $value_image->recipe_image_name;
                            }else{
                                $value_image->recipe_image_name = "";
                            }
                            unset($value_image->is_deleted,$value_image->deleted_at,$value_image->updated_at);
                            $data1[] =  $value_image;
                        }
                    }
                    if(count($data1)>0){
                        $value_recipe->recipe_image = $data1;
                    }else{
                        $value_recipe->recipe_image = $data1;
                    }
                    if($value_recipe->recipe_video != null){
                        $value_recipe->recipe_video = asset("/public/storage/images/recipe_video") . "/" . $value_recipe->recipe_video;
                    }else{
                       $value_recipe->recipe_video = "";
                    }

                    $rate_formula = 0;
                    $rate_count = 0;
                    $get_total_review = rate_m::where(['recipe_id' => $value_recipe->recipe_id, 'is_deleted' => 0])->get();
                    $value_recipe->get_total_review = count($get_total_review);
                    foreach ($rate_value as $key_rate_value => $value_rate_value) {
                        $get_rate = rate_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                        $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                        $rate_count = $rate_count+count($get_rate);

                    }

                    if($rate_count != 0){
                        $div = $rate_formula/$rate_count;
                    }else{
                        $div = 0;
                    }

                    $value_recipe->user_average_rate = $div;

                    unset($value_recipe->is_deleted,$value_recipe->deleted_at,$value_recipe->updated_at);
                    $data['recipe'][] = $value_recipe;
                }
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                if(!is_null($check_premium_user)){
                   
                    $data['premium_user'] = true;
                }else{
                    $data['premium_user'] = false;
                }
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data], 200);
            }else{

                return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function user_favorite_recipe(Request $request){
        $user_id = $request->header('UserId');
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data_recipe = array();
        
        $rate_value = [1,2,3,4,5];
        if(!is_null($get_user)){
            $get_fav_recipe = favorite_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->orderBy('favorite_id','DESC')->get();
            if(count($get_fav_recipe) > 0){
                foreach ($get_fav_recipe as $key_fav => $value_fav) {
                    $get_recipe = recipe_m::where(['recipe_id' => $value_fav->recipe_id,'is_deleted' => 0,'is_hide' => 0])->first();
                    if(!is_null($get_recipe)){
                        $data1 = array();
                        $get_recipe->description = ($get_recipe->description == null) ? '' : $get_recipe->description;
                        $get_recipe_image = recipe_image_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0])->orderBy('recipe_image_id','DESC')->get();
                        if(count($get_recipe_image)>0){
                         foreach ($get_recipe_image as $key_image => $value_image) {
                                if($value_image->recipe_image_name != null){
                                    $value_image->recipe_image_name = asset("/public/storage/images/recipe_image") . "/" . $value_image->recipe_image_name;
                                }else{
                                    $value_image->recipe_image_name = "";
                                }
                                unset($value_image->is_deleted,$value_image->deleted_at,$value_image->updated_at);
                                $data1[] =  $value_image;
                            }
                        }
                        if(count($data1)>0){
                            $get_recipe->recipe_image = $data1;
                        }else{
                            $get_recipe->recipe_image = $data1;
                        }
                        if($get_recipe->recipe_video != null){
                            $get_recipe->recipe_video = asset("/public/storage/images/recipe_video") . "/" . $get_recipe->recipe_video;
                        }else{
                           $get_recipe->recipe_video = "";
                        }

                        $rate_formula = 0;
                        $rate_count = 0;
                        $get_total_review = rate_m::where(['recipe_id' => $get_recipe->recipe_id, 'is_deleted' => 0])->get();
                        $get_recipe->get_total_review = count($get_total_review);
                        foreach ($rate_value as $key_rate_value => $value_rate_value) {
                            $get_rate = rate_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                            $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                            $rate_count = $rate_count+count($get_rate);

                        }

                        if($rate_count != 0){
                            $div = $rate_formula/$rate_count;
                        }else{
                            $div = 0;
                        }

                        $get_recipe->user_average_rate = $div;

                        unset($get_recipe->is_deleted,$get_recipe->deleted_at,$get_recipe->updated_at);
                        $data_recipe[] = $get_recipe;
                    }
                }
                $data['recipe'] = $data_recipe;
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                if(!is_null($check_premium_user)){
                   
                    $data['premium_user'] = true;
                }else{
                    $data['premium_user'] = false;
                }
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data], 200);
            }else{
                return response()->json(['status' => false,'statusCode' => '0','message'=>"Favorite Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function get_recipe_details(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;

        if($recipe_id == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Recipe Id.'], 200);
        }

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data1 = array();
        $rate_value = [1,2,3,4,5];
        $data_ingredients = array();
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
            if(!is_null($get_recipe)){
               
                $get_recipe->description = ($get_recipe->description == null) ? '' : $get_recipe->description;
                $rate = 0;
                $view = $get_recipe->is_view;
                $view = $view+1;
                $update_view = ['is_view' => $view];

                $edit_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->update($update_view);
                $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
                $get_user_rate = rate_m::where(['recipe_id' => $get_recipe->recipe_id, 'user_id' => $get_user->user_id,'is_deleted' => 0])->first();
                
                if(!is_null($get_user_rate)){
                    $get_recipe->user_rate = ($get_user_rate->rate == null)? '' : $get_user_rate->rate;
                    $get_recipe->comment = ($get_user_rate->comment == null)? '' : $get_user_rate->comment;

                }else{
                    $get_recipe->user_rate = '';
                    $get_recipe->comment = '';
                }
                $rate_formula = 0;
                $rate_count = 0;
                $get_total_review = rate_m::where(['recipe_id' => $get_recipe->recipe_id, 'is_deleted' => 0])->get();
                $get_recipe->get_total_review = count($get_total_review);
                foreach ($rate_value as $key_rate_value => $value_rate_value) {
                    $get_rate = rate_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                    $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                    $rate_count = $rate_count+count($get_rate);

                }

                if($rate_count != 0){
                    $div = $rate_formula/$rate_count;
                }else{
                    $div = 0;
                }

                $get_recipe->user_average_rate = $div;
                $get_fav = favorite_m::where(['recipe_id' => $get_recipe->recipe_id, 'user_id' => $get_user->user_id,'is_deleted' => 0])->first();
                if(!is_null($get_fav)){
                    $get_recipe->fav = true;
                }else{
                    $get_recipe->fav = false;
                }
                $get_notes = user_notes_m::where(['recipe_id' => $get_recipe->recipe_id, 'user_id' => $get_user->user_id,'is_deleted' => 0])->first();
                if(!is_null($get_notes)){
                    $get_recipe->note = ($get_notes->note == null)? '' : $get_notes->note;
                }else{
                    $get_recipe->note = '';
                }

                $get_recipe->time_to_cook = $get_recipe->time_to_cook = ($get_recipe->time_to_cook == null)? '' : $get_recipe->time_to_cook;

                



                $get_recipe_image = recipe_image_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0])->orderBy('recipe_image_id','DESC')->get();
                    if(count($get_recipe_image)>0){
                     foreach ($get_recipe_image as $key_image => $value_image) {
                            if($value_image->recipe_image_name != null){
                                $value_image->recipe_image_name = asset("/public/storage/images/recipe_image") . "/" . $value_image->recipe_image_name;
                            }else{
                                $value_image->recipe_image_name = "";
                            }
                            unset($value_image->is_deleted,$value_image->deleted_at,$value_image->updated_at);
                            $data1[] =  $value_image;
                        }
                    }
                    if(count($data1)>0){
                        $get_recipe->recipe_image = $data1;
                    }else{
                        $get_recipe->recipe_image = $data1;
                    }
                if($get_recipe->recipe_video != null){
                    $get_recipe->recipe_video = asset("/public/storage/images/recipe_video") . "/" . $get_recipe->recipe_video;
                }else{
                   $get_recipe->recipe_video = "";
                }

                $get_ingredients = ingredients_m::where(['recipe_id' => $get_recipe->recipe_id, 'is_deleted' => 0])->orderBy('ingredients_id')->get();
                if(count($get_ingredients) > 0){
                    foreach ($get_ingredients as $key => $value) {
                        unset($value->is_deleted,$value->deleted_at,$value->updated_at);
                        $data_ingredients[] = $value;
                    }
                }

                $get_recipe->ingredients = $data_ingredients;
             
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                if(!is_null($check_premium_user)){
                   
                     $get_recipe->premium_user = true;
                }else{
                    $get_recipe->premium_user  = false;
                }
                unset($get_recipe->is_deleted,$get_recipe->deleted_at,$get_recipe->updated_at);
                $data = $get_recipe;
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data], 200);

            }else{
                return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

     public function get_user_review(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;

        if($recipe_id == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Recipe Id.'], 200);
        }


        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data1 = array();
        
        $rate_value = [1,2,3,4,5];
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
            if(!is_null($get_recipe)){
                $rate_formula = 0;
                $rate_count = 0;
                foreach ($rate_value as $key_rate_value => $value_rate_value) {
                    $get_rate = rate_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                    $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                    $rate_count = $rate_count+count($get_rate);

                }

                if($rate_count != 0){
                    $div = $rate_formula/$rate_count;
                }else{
                    $div = 0;
                }

              
                $data1['user_average_rate'] = $div;

                $get_review = rate_m::where(['recipe_id' => $get_recipe->recipe_id,'is_deleted' => 0])->orderBy('rate_id','DESC')->get();
                
                foreach ($get_review as $key_get_review => $value_get_review) {
                    $get_user_detail = user_m::where(['user_id' => $value_get_review->user_id,'is_deleted' => 0])->first();
                    if(!is_null($get_user_detail)){

                    $value_get_review->user_id = ($get_user_detail->user_id == null) ? '' : $get_user_detail->user_id; 
                    $value_get_review->first_name = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name; 
                    $value_get_review->last_name = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name; 
                    $value_get_review->comment = ($value_get_review->comment == null) ? '' : $value_get_review->comment;

                    unset($value_get_review->is_deleted,$value_get_review->deleted_at,$value_get_review->updated_at);
                    
                    
                    $data[] = $value_get_review;
                    }
                }
                    
                $data1['user_review'] = $data;

                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data1], 200);

            }else{
                return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }


    public function user_add_notes(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        $note = $request->note;

        if($note == ""){
            return response()->json(['status' => false,'message'=>'Please Add Note.'], 200);
        }

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $note_exists = user_notes_m::where(['recipe_id' => $recipe_id, 'user_id' => $user_id, 'is_deleted' => 0])->first();
        $data = array();
        
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
            if(!is_null($get_recipe)){
                if(!is_null($note_exists)){
                        $edit_data = [
                
                        'note' => $note
                    ];

                    $editid = user_notes_m::where(['note_id' => $note_exists->note_id])->update($edit_data);
                    if($editid){
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'You have successfully added a note.'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
                }else{
                    $insert_data = [
                        'recipe_id' => $get_recipe->recipe_id,
                        'user_id' => $get_user->user_id,
                        'note' => $note
                    ];

                    $insertid = user_notes_m::create($insert_data);

                    if($insertid){
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'You have successfully added a note.'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
                }

            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function user_add_rate(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        $rate = $request->rate;
        $comment = $request->comment;

        if($rate == ""){
            return response()->json(['status' => false,'message'=>'Please give rate to recipe.'], 200);
        }

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $rate_exists = rate_m::where(['recipe_id' => $recipe_id, 'user_id' => $user_id, 'is_deleted' => 0])->first();
        $data = array();
        
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
            if(!is_null($rate_exists)){
                return response()->json(['status' => false,'statusCode' => '0','message'=>"You have already reviewed this recipe!"], 200);
            }else{
                if(!is_null($get_recipe)){
                    $insert_data = [
                        'recipe_id' => $get_recipe->recipe_id,
                        'user_id' => $get_user->user_id,
                        'rate' => $rate,
                        'comment' => $comment
                    ];

                    $insertid = rate_m::create($insert_data);

                    if($insertid){
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Your review was added!'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }

                }else{
                    return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
                }
            }
            
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function user_add_fav_recipe(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
            if(!is_null($get_recipe)){
                $insert_data = [
                    'recipe_id' => $get_recipe->recipe_id,
                    'user_id' => $get_user->user_id,
                ];

                $insertid = favorite_m::create($insert_data);

                if($insertid){
                    return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe Add to favorite list Successfully.'], 200);
                }else{
                    return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                }

            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function create_shoppinglist(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        $ingredients_id = $request->ingredients_id;

        $split_ingredients_id = explode(',', $ingredients_id);
        
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data_item = array();
        $shopping_list = shopping_list_m::where(['user_id' => $get_user->user_id, 'recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
        if(!is_null($shopping_list)){
             $sid =  $shopping_list->shopping_list_id;
        }
       
        if(!is_null($get_user)){
            if(is_null($shopping_list)){

                $get_recipe = recipe_m::where(['recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
                if(!is_null($get_recipe)){

                    $insert_data = [
                        'recipe_id' => $get_recipe->recipe_id,
                        'user_id' => $get_user->user_id,
                    ];

                    $insertid = shopping_list_m::create($insert_data);

                    $sid = $insertid->shopping_list_id;
                    if($insertid){
                        foreach ($split_ingredients_id as $key_item => $value_item) {
                            $get_ingredients = ingredients_m::where(['ingredients_id' => $value_item, 'recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
                            $item_list = list_item_model_m::where(['shopping_list_id' => $insertid->shopping_list_id, 'ingredients_id' => $get_ingredients->ingredients_id, 'is_deleted' => 0])->first();
                            if(is_null($item_list)){
                                if(!is_null($get_ingredients)){
                                    $data_item = [
                                        'shopping_list_id' => $insertid->shopping_list_id,
                                        'ingredients_id' => $get_ingredients->ingredients_id,
                                    ];

                                    $item_insertid = list_item_model_m::create($data_item);
                                    
                                }
                            }

                        }
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'You have added the Ingredients to the shopping list.'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }

                }
            }else{
                $item_insertid = false;
                foreach ($split_ingredients_id as $key_item => $value_item) {
                            $get_ingredients = ingredients_m::where(['ingredients_id' => $value_item, 'recipe_id' => $recipe_id, 'is_deleted' => 0])->first();
                           
                            if(!is_null($get_ingredients)){
                                $item_list = list_item_model_m::where(['shopping_list_id' => $shopping_list->shopping_list_id, 'ingredients_id' => $get_ingredients->ingredients_id])->first();

                                if(is_null($item_list)){
                                    if(!is_null($get_ingredients)){
                                        $data_item = [
                                            'shopping_list_id' => $sid,
                                            'ingredients_id' => $get_ingredients->ingredients_id,
                                        ];

                                        $item_insertid = list_item_model_m::create($data_item);
                                        
                                    }
                                }
                            }else{
                                return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                            }

                        }
                        if($item_insertid){
                            return response()->json(['status' => true,'responseCode' => 3, 'message'=>'You have added the Ingredients to the shopping list.'], 200);
                        }else{
                            return response()->json(['status' => false,'responseCode' => 1,'message'=>'You have already added the Ingredients to the shopping list.'], 200);
                        }
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function get_shopping_list(Request $request){
        $user_id = $request->header('UserId');
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();

        if(!is_null($get_user)){
        
            $shopping_list = shopping_list_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->get();
            if(!is_null($shopping_list)){
                
                foreach ($shopping_list as $key_shopping_list => $value_shopping_list) {
                    $data_item = array();
                    $get_recipe = recipe_m::where(['recipe_id' => $value_shopping_list->recipe_id, 'is_deleted' => 0,'is_hide'=>0])->first();
                    if(!is_null($get_recipe)){
                        $item_list = list_item_model_m::where(['shopping_list_id' => $value_shopping_list->shopping_list_id, 'is_deleted' => 0])->get();
                        foreach ($item_list as $key_item_list => $value_item_list) {
    
                           $get_ingredients = ingredients_m::where(['ingredients_id' => $value_item_list->ingredients_id])->first();
                           unset($get_ingredients->deleted_at,$get_ingredients->updated_at);
                           $data_item[] = $get_ingredients;
                        }
                    
                        $value_shopping_list->recipe_name = ($get_recipe->recipe_name == null) ? '' : $get_recipe->recipe_name;
                        $value_shopping_list->ingredients = $data_item;
                        unset($value_shopping_list->deleted_at,$value_shopping_list->updated_at);
                        $data[] = $value_shopping_list;
                    }
                    
                }
                
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Shopping list get successfully.', 'data' => $data], 200);

            }else{
                return response()->json(['status' => false,'responseCode' => 1,'message'=>'shopping list not Exist.'], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function remove_fav_recipe(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;

        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        if(!is_null($get_user)){
            $remove_fav_recipe = favorite_m::where(['user_id' => $get_user->user_id, 'recipe_id' => $recipe_id, 'is_deleted' => 0])->delete();
            if($remove_fav_recipe){
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe remove from favorite list Successfully.'], 200);
            }else{

                return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function remove_shopping_list(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        $shopping_list_id = $request->shopping_list_id;
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        if(!is_null($get_user)){
            $shopping_list = shopping_list_m::where(['shopping_list_id' => $shopping_list_id, 'recipe_id' => $recipe_id, 'user_id' => $user_id, 'is_deleted' => 0])->first();
            if(!is_null($shopping_list)){
                $remove_list_item = list_item_model_m::where(['shopping_list_id' => $shopping_list->shopping_list_id, 'is_deleted' => 0])->delete();
                if($remove_list_item){
                    $remove_shopping_list = shopping_list_m::where(['shopping_list_id' => $shopping_list_id, 'recipe_id' => $recipe_id, 'user_id' => $user_id, 'is_deleted' => 0])->delete();
                    if($remove_shopping_list){
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe remove from Shopping list Successfully.'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
                }else{

                    return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                }
            }else{

                    return response()->json(['status' => false,'responseCode' => 1,'message'=>'Shopping list not found.'], 200);
                }
            
            
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function remove_item(Request $request){
        $user_id = $request->header('UserId');
        $recipe_id = $request->recipe_id;
        $ingredients_id = $request->ingredients_id;
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        if(!is_null($get_user)){
            $shopping_list = shopping_list_m::where(['recipe_id' => $recipe_id, 'user_id' => $user_id, 'is_deleted' => 0])->first();
            if(!is_null($shopping_list)){
                 $remove_list_item = list_item_model_m::where(['shopping_list_id' => $shopping_list->shopping_list_id, 'ingredients_id' => $ingredients_id, 'is_deleted' => 0])->delete();
                 if($remove_list_item){
                        return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Ingredients remove from Shopping list Successfully.'], 200);
                    }else{
                        return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                    }
            }else{
                return response()->json(['status' => false,'responseCode' => 1,'message'=>'Shopping list not found.'], 200);
            }
           
            
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'user not exist'], 200);
        }

    }

    public function user_purchase(Request $request){
        
        $user_id = $request->header('UserId');
        $transaction_id = $request->transaction_id;
        $transaction_status = $request->transaction_status;
        $purachase_date = date('Y-m-d H:i:s');
        $get_user = user_m::where(['user_id' => $user_id, 'is_deleted' => 0])->first();

        if(!is_null($get_user)){

            $insert_subscription = [
                'user_id' => $user_id,
                'purchase_date' => $purachase_date,
                'transaction_id' => $transaction_id,          
                'transaction_status' => $transaction_status                  
            ];
           
            $insertid = purchase_m::create($insert_subscription);
            if($insertid){
               
                return response()->json(['status' => true,'message'=>"Congratulations! Your  Plan is active now."], 200);  
            }else{
                return response()->json(['status' => false,'statusCode' => '0','message'=>'User not exist.'], 200);
            }
            
            
            
        }else{
            return response()->json(['status' => false,'statusCode' => '0','message'=>'User not exist.'], 200);
        }

    }

    public function check_user_subscrption(Request $request){
        $user_id = $request->header('UserId');
        $get_user = user_m::where(['user_id' => $user_id, 'is_deleted' => 0])->first();
        
        if(!is_null($get_user)){
            $get_subscrption_detail = subscr_m::where(['subscrption_id' => $get_user->subscrption_id, 'is_deleted' => 0])->first();
            
            if($get_subscrption_detail->subscrption_type == "paid"){
               $get_user_purchase_detail = userpurchse_m::where(['user_id' => $user_id,'subscription_id' => $get_user->subscrption_id, 'is_deleted' => 0,'transaction_status' => 'success'])->orderBy('user_purchase_id','DESC')->first();
               
            }else{
                $data_expire['flage_id'] = "free";
                $data = $data_expire;
                return response()->json(['status' => true,'statusCode' => '0','message'=>'User subscrption is running.','data' => $data], 200);
                
            }
        }else{
            return response()->json(['status' => false,'statusCode' => '0','message'=>'User not exist.'], 200);
        }
    }

    public function forgot_email_password(Request $request){
       $email = $request->user_email;
      
       if($email == ""){
           return response()->json(['status' => false,'statusCode' => '0','message'=>'Please Enter user email.'], 200);
       }

       $get_user = user_m::where(['email'=>$email, 'is_deleted' => 0, 'is_verify_email' => 'verify'])->first();
       if(!is_null($get_user)){
           $user_name = $get_user->first_name." ".$get_user->last_name;
           $new_password = $this->generatePassword();

           $data = array('email' => $get_user->email, 'name'=> $user_name,'password' => $new_password);
           $mail = \Mail::send('mail_forgot_password', $data, function($message) use($email){
               $message->from('test@gmail.com','FoodCulture App');
               $message->to($email,'user')->subject('Forgot Password');
           });

            
            
            if(\Mail::failures()) {
                return response()->json(['status' => false,'statusCode' => '0','message'=>'Mail not sent.'], 200);
            }else{
                $update = user_m::where('user_id',$get_user->user_id)->update(['password' => Crypt::encrypt($new_password)]);
                if($update){
                   return response()->json(['status' => true,'message'=>'Password sent successfully to your register email.'], 200);
                }else{
                   return response()->json(['status' => false,'statusCode' => '0','message'=>"Password can't be changed."], 200);
                }
            }
           
           
       }else{
           return response()->json(['status' => false,'statusCode' => '0','message'=>'Email does not exist.'], 200);
       }
    }

    public function change_password(Request $request){

        $user_id = $request->header('UserId');
        $old_password = $request->old_password;
        $new_password = $request->new_password;


        if($old_password == ""){
           return response()->json(['status' => false,'statusCode' => '0','message'=>'Please Enter current password.'], 200);
        }

        if($new_password == ""){
           return response()->json(['status' => false,'statusCode' => '0','message'=>'Please Enter new password.'], 200);
        }

        $get_user = user_m::where(['user_id'=>$user_id, 'is_deleted' => 0, 'is_verify_email' => 'verify'])->first();

        if(!is_null($get_user)){

           $user_password = Crypt::decrypt($get_user->password);

           if($user_password == $old_password){

               $update = user_m::where('user_id',$user_id)->update(['password' => Crypt::encrypt($new_password)]);

               if($update){
                    return response()->json(['status' => true,'message'=>'Password change successfully.'], 200);
                }else{
                   return response()->json(['status' => false,'statusCode' => '0','message'=>"Oops!Something wents Wrong."], 200);
                }
            }else{
               return response()->json(['status' => false,'statusCode' => '0','message'=>"Current Password is Wrong."], 200);
            }
        }else{
           return response()->json(['status' => false,'statusCode' => '0','message'=>'User Not Exist.'], 200);
        }
    }

    public function edit_user_profile(Request $request){
        $user_id = $request->header('UserId');
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $age = $request->age;
        $gender = $request->gender;
        $ethnicity = $request->ethnicity;

        if($first_name == ""){
            return response()->json(['status' => false,'message'=>'Please Enter First Name.'], 200);
        }
        

        if($last_name == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Last Name.'], 200);
        }

        if($age == ""){
            return response()->json(['status' => false,'message'=>'Please Enter Age.'], 200);
        }

        if($gender == ""){
            return response()->json(['status' => false,'message'=>'Please Select Gender.'], 200);
        }

        if($ethnicity == ""){
            return response()->json(['status' => false,'message'=>'Please Select ethnicity.'], 200);
        }

        $get_user = user_m::where(['user_id' => $user_id, 'is_deleted' => 0, 'is_verify_email' => 'verify'])->first();
        
        if(!is_null($get_user)){

            $user_data = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'age' => $age,
                    'gender' => $gender,
                    'ethnicity' => $ethnicity
            ];

            $edit_user = user_m::where(['user_id' =>$get_user->user_id, 'is_deleted' => 0, 'is_verify_email' => 'verify'])->update($user_data);

            if($edit_user){
                $get_user_detail = user_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0, 'is_verify_email' => 'verify'])->first();

                if(!is_null($get_user_detail)){
                    $get_authentication_user = auth_m::where('user_id',$get_user_detail->user_id)->first();
                                   
                    $data['Token'] = $get_authentication_user->unique_token;
                    $data['user_id'] = $get_user_detail->user_id;
                    $data['first_name'] = ($get_user_detail->first_name == null) ? '' : $get_user_detail->first_name;
                    $data['last_name'] = ($get_user_detail->last_name == null) ? '' : $get_user_detail->last_name;
                    $data['age'] = ($get_user_detail->age == null) ? '' : $get_user_detail->age;
                    $data['gender'] = ($get_user_detail->gender == null) ? '' : $get_user_detail->gender;
                    $data['ethnicity'] = ($get_user_detail->ethnicity == null) ? '' : $get_user_detail->ethnicity;
                    
                    $data['email'] = ($get_user_detail->email == null) ? '' : $get_user_detail->email;
                    $data['login_type'] = ($get_user_detail->login_type == null) ? '' : $get_user_detail->login_type;
                    
                    $data['device_type'] = ($get_user_detail->device_type == null) ? '' : $get_user_detail->device_type;
                    $data['device_token'] = ($get_user_detail->device_token == null) ? '' : $get_user_detail->device_token; 
                    $data['noti_badge'] =  $get_user_detail->noti_badge; 
                    $data['is_verify_email'] =  $get_user_detail->is_verify_email;   
                    $data['created_at'] =  $get_user_detail->created_at->toDateString();
                    $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                    if(!is_null($check_premium_user)){
                       
                        $data['premium_user'] = true;

                    }else{
                        $data['premium_user'] = false;
                    }
                    return response()->json(['status' => true,'responseCode' => 3, 'message'=>'user profile updated Successfully.', 'data' => $data], 200);
                }

            }


        }else{
            return response()->json(['status' => false,'statusCode' => '0','message'=>'User Not Exist.'], 200);
        }

    }

    public function search_recipe_list(Request $request){
        $user_id = $request->header('UserId');
        $search = $request->search;
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data1 = array();
        $rate_value = [1,2,3,4,5];
        $distinict_array = array();

        if(!is_null($get_user)){
            $get_ingredients = recipe_m::leftJoin('tbl_ingredients', 'tbl_recipe.recipe_id', '=', 'tbl_ingredients.recipe_id')->where('tbl_ingredients.ingredients_name','LIKE','%'.$search."%")->where(['is_hide'=>0])->get();

            foreach ($get_ingredients as $key => $value) {
               $distinict_array[] = $value->recipe_id; 
            }

            array_unique($distinict_array);
            $ingredients = recipe_m::WhereIn('recipe_id', $distinict_array)->orderBy('recipe_id','DESC')->get();
            $get_recipe = recipe_m::where('recipe_name','LIKE','%'.$search."%")->WhereNotIn('recipe_id', $distinict_array)->where(['is_hide'=>0])->orderBy('recipe_id','DESC')->get();
            

            $data1 = array_merge(json_decode($ingredients), json_decode($get_recipe));


            
            if(count($data1) > 0){
                foreach ($data1 as $key_recipe => $value_recipe) {
                    $value_recipe->description = ($value_recipe->description == null) ? '' : $value_recipe->description;
                    $image_data = array();
                    $get_recipe_image = recipe_image_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0])->orderBy('recipe_image_id','DESC')->get();
                    if(count($get_recipe_image)>0){
                     foreach ($get_recipe_image as $key_image => $value_image) {
                            if($value_image->recipe_image_name != null){
                                $value_image->recipe_image_name = asset("/public/storage/images/recipe_image") . "/" . $value_image->recipe_image_name;
                            }else{
                                $value_image->recipe_image_name = "";
                            }
                            unset($value_image->is_deleted,$value_image->deleted_at,$value_image->updated_at);
                            $image_data[] =  $value_image;
                        }
                    }
                    if(count($image_data)>0){
                        $value_recipe->recipe_image = $image_data;
                    }else{
                        $value_recipe->recipe_image = $image_data;
                    }
                    if($value_recipe->recipe_video != null){
                        $value_recipe->recipe_video = asset("/public/storage/images/recipe_video") . "/" . $value_recipe->recipe_video;
                    }else{
                       $value_recipe->recipe_video = "";
                    }

                    $rate_formula = 0;
                    $rate_count = 0;
                    $get_total_review = rate_m::where(['recipe_id' => $value_recipe->recipe_id, 'is_deleted' => 0])->get();
                    $value_recipe->get_total_review = count($get_total_review);
                    foreach ($rate_value as $key_rate_value => $value_rate_value) {
                        $get_rate = rate_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                        $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                        $rate_count = $rate_count+count($get_rate);

                    }

                    if($rate_count != 0){
                        $div = $rate_formula/$rate_count;
                    }else{
                        $div = 0;
                    }

                    $value_recipe->user_average_rate = $div;

                    unset($value_recipe->is_deleted,$value_recipe->deleted_at,$value_recipe->updated_at);
                    $data['recipe'][] = $value_recipe;
                }
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                if(!is_null($check_premium_user)){
                   
                    $data['premium_user'] = true;
                }else{
                    $data['premium_user'] = false;
                }
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data], 200);
            }else{

                return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function recipe_list_by_category(Request $request){
        $user_id = $request->header('UserId');
        $category_id = $request->category_id;

        if($category_id == ""){
            return response()->json(['status' => false,'message'=>'Please Enter CategoryId.'], 200);
        }
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        $data = array();
        $data1 = array();
        $rate_value = [1,2,3,4,5];
        if(!is_null($get_user)){
            $get_recipe = recipe_m::where(['category_id' => $category_id,'is_deleted' => 0,'is_hide'=>0])->orderBy('recipe_name')->get();
            if(count($get_recipe) > 0){
                foreach ($get_recipe as $key_recipe => $value_recipe) {
                    $data1 = [];
                    $value_recipe->description = ($value_recipe->description == null) ? '' : $value_recipe->description;
                    $get_recipe_image = recipe_image_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0])->orderBy('recipe_image_id','DESC')->get();
                    if(count($get_recipe_image)>0){
                     foreach ($get_recipe_image as $key_image => $value_image) {
                            if($value_image->recipe_image_name != null){
                                $value_image->recipe_image_name = asset("/public/storage/images/recipe_image") . "/" . $value_image->recipe_image_name;
                            }else{
                                $value_image->recipe_image_name = "";
                            }
                            unset($value_image->is_deleted,$value_image->deleted_at,$value_image->updated_at);
                            $data1[] =  $value_image;
                        }
                    }
                    if(count($data1)>0){
                        $value_recipe->recipe_image = $data1;
                    }else{
                        $value_recipe->recipe_image = $data1;
                    }
                    if($value_recipe->recipe_video != null){
                        $value_recipe->recipe_video = asset("/public/storage/images/recipe_video") . "/" . $value_recipe->recipe_video;
                    }else{
                       $value_recipe->recipe_video = "";
                    }
                    $rate_formula = 0;
                    $rate_count = 0;
                    $get_total_review = rate_m::where(['recipe_id' => $value_recipe->recipe_id, 'is_deleted' => 0])->get();
                    $value_recipe->get_total_review = count($get_total_review);
                    foreach ($rate_value as $key_rate_value => $value_rate_value) {
                        $get_rate = rate_m::where(['recipe_id' => $value_recipe->recipe_id,'is_deleted' => 0,'rate' => $value_rate_value])->get();
                        $rate_formula = $rate_formula+($value_rate_value * count($get_rate));
                        $rate_count = $rate_count+count($get_rate);

                    }

                    if($rate_count != 0){
                        $div = $rate_formula/$rate_count;
                    }else{
                        $div = 0;
                    }

                    $value_recipe->user_average_rate = $div;
                    unset($value_recipe->is_deleted,$value_recipe->deleted_at,$value_recipe->updated_at);
                    $data['recipe'][] = $value_recipe;
                }
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();

                if(!is_null($check_premium_user)){
                   
                    $data['premium_user'] = true;
                }else{
                    $data['premium_user'] = false;
                }
                return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Recipe get successfully.', 'data' => $data], 200);
            }else{

                return response()->json(['status' => false,'statusCode' => '0','message'=>"Recipe not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }
    
    public function cancel_user_subscription(Request $request){
        $user_id = $request->header('UserId');
        $get_user = user_m::where(['user_id' => $user_id, 'is_verify_email' => 'verify', 'is_deleted' => 0])->first();
        if(!is_null($get_user)){
            $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->first();
            if(!is_null($check_premium_user)){
                $check_premium_user = purchase_m::where(['user_id' => $get_user->user_id, 'is_deleted' => 0])->delete();
                if($check_premium_user){
                   return response()->json(['status' => true,'responseCode' => 3, 'message'=>'Subscription canceled successfully.'], 200); 
                }else{
                   return response()->json(['status' => false,'responseCode' => 1,'message'=>'Something went to wrong.'], 200);
                }
            }else{
                return response()->json(['status' => false,'statusCode' => '0','message'=>"Subscription details not found."], 200);
            }
        }else{
            return response()->json(['status' => false,'responseCode' => 1,'message'=>'User not Exist.'], 200);
        }
    }

    public function getSecureKey() {
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $stamp = time();
        $secure_key = $pre = $post = '';
        for ($p = 0; $p <= 10; $p++) {
            $pre .= substr($string, rand(0, strlen($string) - 1), 1);
        }

        for ($i = 0; $i < strlen($stamp); $i++) {
            $key = substr($string, substr($stamp, $i, 1), 1);
            $secure_key .= (rand(0, 1) == 0 ? $key : (rand(0, 1) == 1 ? strtoupper($key) : rand(0, 9)));
        }

        for ($p = 0; $p <= 10; $p++) {
            $post .= substr($string, rand(0, strlen($string) - 1), 1);
        }
        return $pre . '-' . $secure_key . $post;
    }

    public function generatePassword($length = 7) {
        $psw = '';
        $string = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        for ($p = 0; $p <= $length; $p++) {
            $psw .= substr($string, rand(0, strlen($string) - 1), 1);
        }
        return $psw;
    }
    
  

}