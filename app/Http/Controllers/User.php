<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Crypt;
use DateTime;
use DateTimeZone;
use App\User_model as user_m;
use App\Authentication_model as auth_m;
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

class User extends Controller
{

    public function __construct()
    {
        if(session('admin_id') == ''){
            return redirect('/');
        }
    }

    public function user_index(){
        
        return view('user_list_view',['menu_name' => 'user']);            
    }

    public function Premium_Members(){
         
        return view('premium_members',['menu_name' => 'premium']);            
    }
    
    public function view_user(Request $request){
        
        $query = user_m::query();
        $query->where(['is_verify_email' => 'verify'])->orderBy('user_id', 'DESC');

        $get_users = $query->get();
        
        $no_record = false;
        $output = '';
        $no = 1;
        if(count($get_users) > 0){
            foreach ($get_users as $value) {

                $date = new DateTime($value->created_at);
                $date->setTimezone(new DateTimeZone(session('timezone')));
                $register_date =   $date->format('M d, Y h:i a');
             
                $icon_status = "";
                $color_back = "";
                $type_status_user = "";
                if($value->is_block_unblock == "0"){
                    $icon_status = "fa fa-ban";
                    $color_back = "#ff5370";
                    $type_status_user = "block";
                }else{
                    $icon_status = "fa fa-unlock-alt";
                    $color_back = "#2ed8b6";
                    $type_status_user = "unblock";
                }

                $name_user = "-";
                if($value->first_name != "" && $value->first_name != null && $value->first_name != 'null'){
                    $name_user = $value->first_name;
                }

                $last_name_user = "-";
                if($value->last_name != "" && $value->last_name != null && $value->last_name != 'null'){
                    $last_name_user = $value->last_name;
                }

                $output .= '
                    <tr id="tr_'. $value->user_id .'">
                        <td>'.$no.'</td>
                        <td>'. $name_user .'</td>
                        <td>'. $last_name_user .'</td>
                        <td style="white-space:pre-wrap">'. $value->email .'</td>
                        <td>'. $value->age .'</td>
                        <td style="white-space:pre-wrap">'. $value->gender .'</td>
                        <td style="white-space:pre-wrap">'. $value->ethnicity .'</td>
                        <td style="white-space:pre-wrap">'. $register_date .'</td>
                         
                        <td>
                            

                            <a href="javascript:void(0);" onclick="get_user_id('. $value->user_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>

                            

                        </td>
                    </tr>
                ';
                $no++;
            }
        }else{
            $no_record = true;
            $output = '
                
            ';

        }

        $data=[];
        $data['user'] = $output;
        echo json_encode($data);
    }

    public function user_delete(Request $request)
    {
        $id = $request->user_id;

      

        $get_user = user_m::where('user_id',$id)->first();
        if(!is_null($get_user)){

          
            $delete_user = user_m::where('user_id',$id)->delete();
            if($delete_user){
                
                
                
                $delete_auth = auth_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                $delete_comment = comment_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                $delete_favorite = favorite_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                $delete_purchase = purchase_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                $delete_rate = rate_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                $delete_shopping_list = shopping_list_m::where(['user_id' => $id,'is_deleted' => 0])->get();
                if(count($delete_shopping_list)>0){
                    foreach ($delete_shopping_list as $key => $value) {
                        $delete_shopping_list = list_item_model_m::where('shopping_list_id',$value->shopping_list_id)->delete();
                    }
                    $delete_shopping_list = shopping_list_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
                }
                $delete_user_notes = user_notes_m::where(['user_id' => $id,'is_deleted' => 0])->delete();
               
            }
            if($delete_user){
                echo 0;
            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
        
    }

    public function user_block(Request $request)
    {
        $user_id = $request->user_id;
        $type_status_users = $request->type_status_users;

        $get_user = user_m::where('user_id',$user_id)->get();

        if(count($get_user) > 0){

            if($type_status_users == "block"){
                 $edit_data = [
                        'is_block_unblock' => "1"                         
                    ];

            }else{
                $edit_data = [
                        'is_block_unblock' => "0"                         
                    ];
            }
            $update = user_m::where(['user_id' => $user_id, 'is_deleted' => 0, 'is_verify' => 'verify'])->update($edit_data);
             if($update){
                echo 0;
            }else{
                echo 1;
            }
        }
        
       
       
        
    }

    public function premium_members_list(Request $request){
        $get_user = user_m::where(['subscription_id' => 2, 'is_deleted' => 0])->get();
        $no_record = false;
        $output = '';
        $no = 1;
        if(count($get_user)>0){
            foreach ($get_user as $key => $value) {
              $purchase_details =  purchase_m::where(['user_id' => $value->user_id, 'is_deleted' => 0])->first();
              if(!is_null($purchase_details)){

                $purchase_date = "-";
                if($purchase_details->purchase_date != ""){
                    $date = new DateTime($purchase_details->purchase_date);
                    $date->setTimezone(new DateTimeZone(session('timezone')));
                    $purchase_date =   $date->format('M d, Y h:i a');
                    
                }
                $name_user = "-";
                if($value->first_name != ""){
                    $name_user = $value->first_name;
                }
                $last_name_user = "-";
                if($value->last_name != ""){
                    $last_name_user = $value->last_name;
                }

                $output .= '
                    <tr id="tr_'. $value->user_id .'">
                        <td>'. $no .'</td>
                        <td>'. $name_user .'</td>
                        <td>'. $last_name_user .'</td>
                        <td>'. $purchase_date .'</td></tr>';
                    $no++;
              }

            }


        }else{
            $no_record = true;
            $output = '';
        }
        $data=[];
        $data['user'] = $output;
        echo json_encode($data);
    }
}

   
