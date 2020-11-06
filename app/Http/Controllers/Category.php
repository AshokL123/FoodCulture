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

class Category extends Controller
{

    public function __construct()
    {
        if(session('admin_id') == ''){
            return redirect('/admin');
        }
    }

   
    
    public function category(){
       
        return view('category_view',['menu_name' => 'category']);            
    }

    public function sort_category_view(){
       
        $query = category_m::query();
        $query->where(['is_deleted' => 0])->orderBy('cat_order','DESC');
        $list = $query->get(); 

        return view('sort_category_view',['menu_name' => 'category','list' => $list]);            
    }

    public function sort_category(Request $request){
        $first_cat = $request->first_cat;
        $second_cat = $request->second_cat;
        $first_cat_order = "";
        $second_cat_order = "";
        
        if($first_cat != "" && $second_cat != ""){
            $get_first_cat = category_m::where(['category_id' => $first_cat, 'is_deleted' => 0])->first();
            if(!is_null($get_first_cat)){
                $first_cat_order = $get_first_cat->cat_order;
            }
            $get_second_cat = category_m::where(['category_id' => $second_cat, 'is_deleted' => 0])->first();
            if(!is_null($get_second_cat)){
                $second_cat_order = $get_second_cat->cat_order;
            }
           
            if($first_cat_order != "" && $second_cat_order != ""){
                $update_first_cat = category_m::where(['category_id' => $first_cat, 'is_deleted' => 0])->update(['cat_order' => $second_cat_order]);
                $update_second_cat = category_m::where(['category_id' => $second_cat, 'is_deleted' => 0])->update(['cat_order' => $first_cat_order]);
            }
            $output = "";
            $get_category_list = category_m::where(['is_deleted' => 0])->orderBy('cat_order','DESC')->get();
            foreach ($get_category_list as $key => $value) {
                $output .= '<li class="list-group-item draggable" draggable="true" data-id='.$value->category_id.' value='.$value->category_id.'>'.$value->category_name.'</li>';
            }
            $data['list'] = $output;
            echo json_encode($data);
        }else{
            echo 0;
        }
        
    }
    

    public function view_category_list(Request $request){
        
        $query = category_m::query();
        $query->where(['is_deleted' => 0])->orderBy('cat_order', 'DESC');

        $get_category = $query->get();
        
        $no_record = false;
        $output = '';
        $no = 1;
        if(count($get_category) > 0){
            foreach ($get_category as $value) {

                
               

                $category_name = "-";
                if($value->category_name != ""){
                    $category_name = $value->category_name;
                }

                $category_image = asset("public/storage/images/category/".$value->category_image); 

                $output .= '
                    <tr id="tr_'. $value->category_id .'">
                        <td width="10">'.$no.'</td>
                        <td style="width:100px;padding: .99rem"><img src='.$category_image.' style="width:100px;  max-height:100px; object-fit: contain;"></td>
                        <td>'. $category_name .'</td>
                        <td style="width:260px">
                            <a href="'. url("/Category/" . $value->category_id)  .'"><button  class="btn waves-effect waves-light btn-success btn-icon" title="Detail" style="margin-right:0px;" id="add_btn"><i class="fa fa-eye" ></i></button></a>&nbsp;
                            <a href="javascript:void(0);" id="edit" data-id="'.$value->category_id.'" data-toggle="modal" data-target="#edit_cat_model"><button  class="btn waves-effect waves-light btn-info btn-icon" title="Edit" style="margin-right:0px;" id="add_btn"><i class="fa fa-edit" ></i></button></a>&nbsp;
                            <a href="javascript:void(0);" onclick="get_cat_id('. $value->category_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>

                            

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

    public function add_category(Request $request)
    {
        $cat_exists = category_m::where('category_name', $request->input('cat_name'))->exists();
        if($cat_exists)
        {
            echo 0;
        }
        else{
            $cat_order = 1;
            $get_category = category_m::where(['is_deleted' => 0])->get();
            if(count($get_category)>0){
                $get_max_cat_order = category_m::max('cat_order');
                $cat_order = $get_max_cat_order+1;
            }
            $cat_name = $request->input('cat_name');
            $description = $request->input('cat_des');
            $file = $request->file('image') ;
                
            $fileName = 'category_'.rand().'.'.$file->getClientOriginalExtension();
            
           
            $path = $file->storeAs('public/images/category', $fileName);
            
            
            if($request->ajax())
            {
                $data1=array('category_name'=>$cat_name,"category_image"=>$fileName,"description"=>$description,'cat_order'=>$cat_order);
                $category=category_m::create($data1);

                if($category){
                    $get_user = user_m::where(['is_deleted' => 0,'device_type'=>'android'])->get();
                    if(count($get_user)>0){
                        $device_token = [];
                        foreach ($get_user as $key => $value) {
                            $device_token[] = $value->device_token;
                        }
                        $message = 'A new category has been released! Please feel free to check it out!';
                        $badge = 1;
                        $notifiction_result = user_m::android_send_push_notification($device_token, $message, $badge);
                                        
                        if($notifiction_result){
                            
                            $edit_user_data = [
                                                'noti_badge' => $badge
                                            ];

                            $update_user_data = user_m::where(['is_deleted' => 0])->update($edit_user_data);
                        }
                    }
                    $get_ios_user = user_m::where(['is_deleted' => 0,'device_type'=>'ios'])->get();
                    if(count($get_ios_user)>0){
                        
                        foreach ($get_ios_user as $key => $value) {
                            $device_token = $value->device_token;
                            $message = 'A new category has been released! Please feel free to check it out!';
                            $badge = 1;
                           
                            $notifiction_result = user_m::ios_send_push_notification($device_token, $message, $badge);
                            if($notifiction_result){
                               
                                $edit_user_data = [
                                                    'noti_badge' => $badge
                                                ];
    
                                $update_user_data = user_m::where(['is_deleted' => 0,'user_id'=>$value->user_id])->update($edit_user_data);
                            }
                        }
                       
                        

                    }
                    echo 1;
                }
            }
        }
    }

    public function edit_category(Request $request)
    {
        if($request->ajax())
        {
            $cat_id=$request->id;
         
            $category = category_m::where(['category_id' => $cat_id])->get();
            
            return $category;   
        }
    }

    public function update_category(Request $request)
    {
      
            $category_id = $request->input('edit_id');
            $cat_name = $request->input('edit_name');
            $description = $request->input('edit_des');
            $edit_image_name = $request->input('edit_image_name');
            
            $file = $request->file('edit_image') ;
            $data1=['category_name'=>$cat_name,"description"=>$description];
            if(!is_null($file)){
                $fileName = 'category_'.rand().'.'.$file->getClientOriginalExtension();
            
           
                $path = $file->storeAs('public/images/category', $fileName);
                $data1['category_image'] = $fileName;

                if($edit_image_name != ""){
                    $path = 'public/storage/images/category/';
                    $image_name = $path.$edit_image_name;
            
                    if (file_exists($image_name)) {
                        @unlink($image_name);
                    }
                }

            }
            
            
            if($request->ajax())
            {
                
                $category=category_m::where(['category_id' => $category_id])->update($data1);

                if($category){
                
                    echo 1;
                }
            }
        
    }

    public function category_delete(Request $request)
    {
    
        $id = $request->id;
        $get_category = category_m::where(['category_id' => $id])->first();
      
        if(!is_null($get_category)){

            if($get_category->category_image != ""){
                    $path = 'public/storage/images/category/';
                    $image_name = $path.$get_category->category_image;
            
                    if (file_exists($image_name)) {
                        @unlink($image_name);
                    }
                }

            $delete_category = category_m::where('category_id',$id)->delete();
           
            if($delete_category){
                echo 0;
            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
        
    }

    public function view_category_detail($id)
    {
         $get_category = category_m::where(['category_id' => $id])->first();
         return view('category_details_view',['menu_name' => 'category','category' => $get_category]);
    }
    
    
    
}

   
