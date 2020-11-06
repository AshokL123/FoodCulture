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
use App\Recipe_image_model as recipe_image_m;
use Carbon\Carbon;
use Session;
class Recipe extends Controller
{
    

    public function __construct()
    {
        if(session('admin_id') == ''){
            return redirect('/admin');
        }
       
    }


    public function recipe(Request $request){
        
        return view('recipe_view',['menu_name' => 'recipe']);            
    }

    public function add_recipe_view(){
        
        $category = category_m::where(['is_deleted' => 0])->orderBy('category_id', 'DESC')->get();
        return view('add_recipe',['menu_name' => 'recipe','category' => $category]);            
    }

    public function edit_recipe_view($id){
  
            $recipe = recipe_m::where(['recipe_id' => $id])->first();
            $category = category_m::where(['is_deleted' => 0])->get();
            $cat = '';
            $get_recipe_name = array();
            $duration = 0;
            $get_recipe_image = recipe_image_m::where(['recipe_id' => $id])->first();
            if(!is_null($recipe)){
                $get_recipe_name = category_m::where(['category_id' => $recipe->category_id])->first();
                if(!is_null($get_recipe_name)){
                    $cat = $get_recipe_name->category_id;
                }
                $get_time = $recipe->time_to_cook;
                if(!is_null($get_time)){
                    if(strpos($get_time,':') !== false){
                  
                        $time_to_cook1 = explode(':',$get_time);
                   
                        $hh = $time_to_cook1[0];
                        $mm = $time_to_cook1[1];
                        $ss = $time_to_cook1[2];
                      
                        $second = ((($hh) * 60 + $mm) * 60)+$ss;
                        $duration = $second;
                    }
                }
            }
            return view('edit_recipe',['menu_name' => 'recipe','recipe' => $recipe, 'category_name' => $cat, 'category' => $category, 'recipe_image' => $get_recipe_image, 'time_to_cook' => $duration]);            
    }

    public function get_recipe_image($id){
  
           $get_recipe_image = recipe_image_m::where(['recipe_id' => $id])->get();
           return  $get_recipe_image;          
    }

    public function recipe_details($id){
  
            $recipe = recipe_m::where(['recipe_id' => $id])->first();
            $get_recipe_image = recipe_image_m::where(['recipe_id' => $id])->orderBy('recipe_image_id','DESC')->get();
           
            return view('recipe_details',['menu_name' => 'recipe','recipe' => $recipe,'recipe_image' => $get_recipe_image]);            
    }

    

    public function view_recipe_list(Request $request){
        Session::flush();
       
        $timezone = 'Asia/Kolkata';
                if ($request->timezone != '' && $request->timezone != 'Asia/Culcatta' ) {
                   $timezone = $request->timezone;
                }
        
        session(['admin_id' => 1, 'timezone' => $timezone]);
        
        $query = recipe_m::query();
        $query->where(['is_deleted' => 0])->orderBy('recipe_id', 'DESC');

        $get_recipe = $query->get();
        
        $no_record = false;
        $output = '';
        $no = 1;
        if(count($get_recipe) > 0){
            foreach ($get_recipe as $value) {

               
                
                $save_count = shopping_list_m::where(['recipe_id' => $value->recipe_id, 'is_deleted' => 0])->get();

                $recipe_name = "-";
                if($value->recipe_name != ""){
                    $recipe_name = $value->recipe_name;
                }

                $save = count($save_count);


                $get_recipe_image = recipe_image_m::where(['recipe_id' => $value->recipe_id])->first();
                
                if(!is_null($get_recipe_image)){
                $recipe_image = asset("public/storage/images/recipe_image/".$get_recipe_image->recipe_image_name); 
                }else{
                    $recipe_image = "";
                }
                
                $icon_status = "";
                $color_back = "";
                $type_status_user = "";
                if($value->is_hide == 0){
                    $icon_status = "fa fa-unlock-alt";
                    $color_back = "#147360";
                    $type_status_user = "hide";
                }else{
                    $icon_status = "fa fa-ban";
                    $color_back = "#a52a2a";
                    
                    $type_status_user = "show";
                }
              
                $output .= '<tr id="tr_'. $value->recipe_id .'"><td width="10">'.$no.'</td><td style="white-space:pre-wrap">'. $recipe_name .'</td><td>'. $value->is_view .'</td><td>'. $save .'</td><td style="width:260px"><a href="'. url("/Recipe/Details/" . $value->recipe_id)  .'"><button  class="btn waves-effect waves-light btn-success btn-icon" title="Detail" style="margin-right:0px;" id="add_btn"><i class="fa fa-eye" ></i></button></a>&nbsp;<a href="'. url("/Recipe/" . $value->recipe_id)  .'" id="edit" data-id="'.$value->recipe_id.'"><button  class="btn waves-effect waves-light btn-info btn-icon" title="Edit" style="margin-right:0px;" id="add_btn"><i class="fa fa-edit" ></i></button></a>&nbsp;<a href="javascript:void(0);" onclick="get_recipe_id('. $value->recipe_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon" title="Delete"><i class="fa fa-trash"></i></button></a>&nbsp;<a href="javascript:void(0);" onclick="recipe_hide_show('.$value->recipe_id .','.$value->is_hide.')"><button id="show_hide_btn" class="btn waves-effect waves-light btn-icon" title="'.$type_status_user.'" style="background-color:'.$color_back.';color:#ffffff"><i class="'.$icon_status.'"></i></button></a></td></tr>';
                $no++;
            }
        }else{
            $no_record = true;
            $output = '
                
            ';

        }

        
        $data['user'] = $output;
        
        echo json_encode($data);
    }



    public function add_recipe(Request $request)
    {
            $data = array();

            $category = $request->input('category');

            $recipe_name = $request->input('recipe_name');

            $instruction = $request->input('instruction');
            
            $description = $request->input('description');
            
            $recipe_id = $request->input('recipe_id');

            $seconds = (int)$request->input('time_to_cook');
            $dt1 = new DateTime("@0");
            $dt2 = new DateTime("@$seconds");
            $time_to_cook = $dt1->diff($dt2)->format('%H:%I:%S');
            

            $filename = $request->file('file');
            $video_file = $request->file('recipe_video');
            $video_fileName = "";

            $recipe_type = $request->input('recipe_type');

            $people = $request->input('people');

            if($request->ajax())
            {
                if(is_null($recipe_id)){
                    $recipe_exists = recipe_m::where('recipe_name', $request->input('recipe_name'))->exists();
                    if($recipe_exists)
                    {
                        echo 0;
                    }else{
                    if(!is_null($video_file)){
          
                        

                        $video_fileName = 'recipe_video_'.time().'_'.str_random(10).'.'.$video_file->getClientOriginalExtension();
                            

                        $video_path = $video_file->storeAs('public/images/recipe_video', $video_fileName);
                    }
                    $add_data = [
                        'category_id' => $category,
                        'recipe_name' => $recipe_name,
                        'instruction' => $instruction,
                        'recipe_video' => $video_fileName,
                        'time_to_cook' => $time_to_cook,
                        'no_people_serve' => $people,
                        'recipe_type' => $recipe_type,
                        'description' => $description
                    ];

                    $recipe=recipe_m::create($add_data);

                    if($recipe){

                        if ($request->hasFile('file')) {

                            foreach ($filename as $n => $file) {
                                $k= $n+1;
                               
                                $filenames = 'recipe_'.rand().'.'.$filename[$n]->getClientOriginalExtension();

                                $path = $file->storeAs('public/images/recipe_image',$filenames);

                                $add_image_data = [
                                        'recipe_id' => $recipe->recipe_id,
                                        'recipe_image_name' => $filenames,
                                        
                                ];

                                $recipe_image=recipe_image_m::create($add_image_data);

                                if(!$recipe_image){
                                   echo 1;
                                }
                            }
                            
                        }
                        $recipe->flag = "add";
                        
                        
                        
                        return $recipe;
                    }
                }
                }else{
                    $get_recipe_id = recipe_m::where(['recipe_id' => $recipe_id])->first();
                    
                    if(!is_null($get_recipe_id)){
                    
                    if(!is_null($filename)){
                        foreach ($filename as $n => $file) {
                            $k= $n+1;
                            /*$filenames = $filename[$n]->getClientOriginalName();*/
                            $filenames = 'recipe_'.rand().'.'.$filename[$n]->getClientOriginalExtension();

                            $path = $file->storeAs('public/images/recipe_image',$filenames);

                            $edit_image_data = [
                                    'recipe_id' => $get_recipe_id->recipe_id,
                                    'recipe_image_name' => $filenames,
                                    
                            ];

                            $recipe_image=recipe_image_m::create($edit_image_data);

                            if(!$recipe_image){
                               echo 1;
                            }
                        }
                    }
                    if(!is_null($video_file)){
                        $video_fileName = 'recipe_video_'.time().'_'.str_random(10).'.'.$video_file->getClientOriginalExtension();
                        

                        $video_path = $video_file->storeAs('public/images/recipe_video', $video_fileName);

                        $get_recipe = recipe_m::where(['recipe_id' => $get_recipe_id->recipe_id])->first();

                        $data_update['recipe_video'] = $video_fileName;

                        $update_recipe=recipe_m::where(['recipe_id' => $get_recipe_id->recipe_id])->update($data_update);

                        if($update_recipe){
                            if(!is_null($get_recipe)){
                                if($get_recipe->recipe_video != ""){
                                    $path = 'public/storage/images/recipe_video/';
                                    $image_name = $path.$get_recipe->recipe_video;
                            
                                    if (file_exists($image_name)) {
                                        @unlink($image_name);
                                    }
                                }
                            }
                        }
                    }
                    $edit_data = [
                        'category_id' => $category,
                        'recipe_name' => $recipe_name,
                        'instruction' => $instruction,
                        'time_to_cook' => $time_to_cook,
                        'no_people_serve' => $people,
                        'recipe_type' => $recipe_type,
                        'description' => $description
                    ];
                    $recipe=recipe_m::where(['recipe_id' => $get_recipe_id->recipe_id])->update($edit_data);
                    
                    if($recipe){
                        echo "update";
                    }else{
                        echo 1;
                    }
                }else{
                    echo 1;
                }
            }
            }
        
    }

  

    public function update_recipe(Request $request,$recipe_id)
    {
            
            $recipe_name = $request->input('recipe_name');

            $instruction = $request->input('instruction');

            $recipe_type = $request->input('recipe_type');

            $category = $request->input('category');

            $description = $request->input('description');
            
            $seconds = (int)$request->input('time_to_cook');
            $dt1 = new DateTime("@0");
            $dt2 = new DateTime("@$seconds");
            $time_to_cook = $dt1->diff($dt2)->format('%H:%I:%S');

            $people = $request->input('people');

            $filename = $request->file('file');
            if($request->ajax())
            {
            if(!is_null($filename)){
                foreach ($filename as $n => $file) {
                    $k= $n+1;
                    /*$filenames = $filename[$n]->getClientOriginalName();*/
                    $filenames = 'recipe_'.rand().'.'.$filename[$n]->getClientOriginalExtension();

                    $path = $file->storeAs('public/images/recipe_image',$filenames);

                    $image_data = [
                            'recipe_id' => $recipe_id,
                            'recipe_image_name' => $filenames,
                            
                    ];

                    $recipe_image=recipe_image_m::create($image_data);

                    if(!$recipe_image){
                       echo 4;
                    }
                }
            }


            $video_file = $request->file('recipe_video');
            
            if(!is_null($video_file)){
                $video_fileName = 'recipe_video_'.time().'_'.str_random(10).'.'.$video_file->getClientOriginalExtension();
                

                $video_path = $video_file->storeAs('public/images/recipe_video', $video_fileName);

                $get_recipe = recipe_m::where(['recipe_id' => $recipe_id])->first();

                $data_update['recipe_video'] = $video_fileName;

                $update_recipe=recipe_m::where(['recipe_id' => $recipe_id])->update($data_update);

                if($update_recipe){
                    if(!is_null($get_recipe)){
                        if($get_recipe->recipe_video != ""){
                            $path = 'public/storage/images/recipe_video/';
                            $image_name = $path.$get_recipe->recipe_video;
                    
                            if (file_exists($image_name)) {
                                @unlink($image_name);
                            }
                        }
                    }
                }
            }

            
                
                $data = [
                    'recipe_name' => $recipe_name,
                    'instruction' => $instruction,
                    'recipe_type' => $recipe_type,
                    'category_id' => $category,
                    'time_to_cook' => $time_to_cook,
                    'no_people_serve' => $people,
                    'description' => $description
                ];
                $recipe=recipe_m::where(['recipe_id' => $recipe_id])->update($data);
        
                if($recipe){
                
                    echo 1;
                }else{
                    echo 1;
                }
            }
        
        
    }

    public function update_video(Request $request,$recipe_id)
    {
            

            $video_file = $request->file('videoupload');
            

            $video_fileName = 'recipe_video_'.time().'_'.str_random(10).'.'.$video_file->getClientOriginalExtension();
                

            $video_path = $video_file->storeAs('public/images/recipe_video', $video_fileName);

            

            $data = [
                    'recipe_video' => $video_fileName
                ];

           

       
            if($request->ajax())
            {
                $get_recipe = recipe_m::where(['recipe_id' => $recipe_id])->first();
                
                $recipe=recipe_m::where(['recipe_id' => $recipe_id])->update($data);

                if($recipe){
                    if(!is_null($get_recipe)){
                        if($get_recipe->recipe_video != ""){
                            $path = 'public/storage/images/recipe_video/';
                            $image_name = $path.$get_recipe->recipe_video;
                    
                            if (file_exists($image_name)) {
                                @unlink($image_name);
                            }
                        }
                    }
                    echo 1;
                }else{
                    echo 2;
                }
            }
        
        
    }

    public function recipe_delete(Request $request)
    {
        session()->regenerate();
        $id = $request->id;
        $get_recipe = recipe_m::where(['recipe_id' => $id])->first();
       
      
        if(!is_null($get_recipe)){
             $get_recipe_image = recipe_image_m::where(['recipe_id' => $get_recipe->recipe_id])->get();
            if(count($get_recipe_image)>0)
            {
                foreach ($get_recipe_image as $key_image => $value_image) {
                    if($value_image->recipe_image_name != ""){
                        $path = 'public/storage/images/recipe_image/';
                        $image_name = $path.$value_image->recipe_image_name;
                
                        if (file_exists($image_name)) {
                            @unlink($image_name);
                        }
                    }
                }
                
            }

            if($get_recipe->recipe_video != ""){
                $video_path = 'public/storage/images/recipe_video/';
                $video_name = $video_path.$get_recipe->recipe_video;
        
                if (file_exists($video_name)) {
                    @unlink($video_name);
                }
            }


            $delete_recipe = recipe_m::where('recipe_id',$id)->delete();
            $delete_recipe_image = recipe_image_m::where('recipe_id',$id)->delete();
            $delete_comment = comment_m::where('recipe_id',$id)->delete();
            $delete_favorite = favorite_m::where('recipe_id',$id)->delete();
            $delete_ingredients = ingredients_m::where('recipe_id',$id)->delete();
            $get_shopping_list = shopping_list_m::where('recipe_id',$id)->get();
            foreach ($get_shopping_list as $key => $value) {
                $delete_list_item = list_item_model_m::where('shopping_list_id',$value->shopping_list_id)->delete();
            }
            $delete_shopping_list = shopping_list_m::where('recipe_id',$id)->delete();
            $delete_rate = rate_m::where(['recipe_id' => $id])->delete();
            $delete_add_notes = user_notes_m::where(['recipe_id' => $id])->delete();
            
           
            if($delete_recipe){
                echo 0;
            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
        
    }


    public function add_ingredients(Request $request,$recipe_id)
    {
        $ingredients_name = $request->input('ingredient');
       
        $flag = $request->input('flag');
        $add_ingredients_exists = ingredients_m::where(['ingredients_name' => $ingredients_name, 'recipe_id' => $recipe_id])->exists();
        if($add_ingredients_exists)
        {
            echo 0;
        }
        else{

            $data = array();

           
   
            if($request->ajax())
            {
                $data = [
                    'ingredients_name' => $ingredients_name,
                    'recipe_id' => $recipe_id,
                ];
                $no_record = false;
                $output = '';
                $no = 1;
                $ingredients=ingredients_m::create($data);

                if($ingredients){
                
                    $get_ingredients = ingredients_m::where(['recipe_id' => $ingredients->recipe_id])->orderBy('ingredients_id','DESC')->get();

                    if(count($get_ingredients) > 0){
                        foreach ($get_ingredients as $value) {
                            if($flag == ''){
                               echo 1;
                            }else{
                                $output .= '
                                <tr id="tr_'. $value->ingredients_id .'">
                                <td width="10">'.$no.'</td>
                                <td style="white-space:pre-wrap">'. $value->ingredients_name .'</td>
                                <td style="width:100px">
                                
                                <a href="javascript:void(0);" id="edit" data-id="'.$value->ingredients_id.'" data-toggle="modal" data-target="#edit_item_model"><button  class="btn waves-effect waves-light btn-info btn-icon" title="Edit" style="margin-right:0px;" id="add_btn"><i class="fa fa-edit" ></i></button></a>&nbsp;
                                <a href="javascript:void(0);" onclick="get_item_id('. $value->ingredients_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>
                                

                            

                                </td>
                                </tr>';
                            }

                            $no++;
                        }
                    }else{
                        $no_record = true;
                        $output = '';
                    }

                    $data=[];
                    $data['ingredients'] = $output;
                    echo json_encode($data);
                }
            }
        }
    }
    
    
    public function get_ingredients(Request $request){
        $id = $request->recipe_id;
        $no_record = false;
        $output = '';
        $no = 1;
        $get_ingredients = ingredients_m::where(['recipe_id' => $id])->orderBy('ingredients_id','DESC')->get();
        if(count($get_ingredients) > 0){
            foreach ($get_ingredients as $value) {
                $output .= '
                    <tr id="tr_'. $value->ingredients_id .'">
                    <td width="10">'.$no.'</td>
                    <td  style="white-space:pre-wrap">'. $value->ingredients_name .'</td>
                     <td style="width:100px">
                                
                            <a href="javascript:void(0);" id="edit" data-id="'.$value->ingredients_id.'" data-toggle="modal" data-target="#edit_item_model"><button  class="btn waves-effect waves-light btn-info btn-icon" title="Edit" style="margin-right:0px;" id="add_btn"><i class="fa fa-edit" ></i></button></a>&nbsp;
                            <a href="javascript:void(0);" onclick="get_item_id('. $value->ingredients_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>

                            

                                </td>

                    </tr>';
                $no++;
            }
        }else{
            $no_record = true;
            $output = '';
        }

        $data=[];
        $data['ingredients'] = $output;
        echo json_encode($data);
    }

    public function get_recipe_ingredients(Request $request){
        $id = $request->recipe_id;
        $no_record = false;
        $output = '';
        $no = 1;
        $get_ingredients = ingredients_m::where(['recipe_id' => $id])->orderBy('ingredients_id','DESC')->get();
        if(count($get_ingredients) > 0){
            foreach ($get_ingredients as $value) {
                $output .= '
                    <tr id="tr_'. $value->ingredients_id .'">
                    <td width="10">'.$no.'</td>
                    <td style="white-space:pre-wrap">'. $value->ingredients_name .'</td>

                    </tr>';
                $no++;
            }
        }else{
            $no_record = true;
            $output = '';
        }

        $data=[];
        $data['ingredients'] = $output;
        echo json_encode($data);
    }


    public function edit_ingredients(Request $request)
    {
        if($request->ajax())
        {
            $id=$request->id;
         
            $ingredients = ingredients_m::where(['ingredients_id' => $id])->get();
            
            return $ingredients;   
        }
    }

     public function update_ingredients_details(Request $request)
    {
      
            $ingredients_id = $request->input('edit_id');
            $ingredients_name = $request->input('edit_ingredients_name');
            
            $no_record = false;
            $output = '';
            $no = 1;
            if($request->ajax())
            {

                $data = ['ingredients_name' => $ingredients_name];
                
                $ingredients = ingredients_m::where(['ingredients_id' => $ingredients_id])->update($data);

                $ing_id = ingredients_m::where(['ingredients_id' => $ingredients_id])->first();

                if($ingredients){
                
                    echo 1;
                    
                }else{
                    echo 2;
                }
            }
        
    }

      public function update_ingredients(Request $request)
    {
      
            $ingredients_id = $request->input('edit_id');
            $ingredients_name = $request->input('edit_ingredients_name');
            
            $no_record = false;
            $output = '';
            $no = 1;
            if($request->ajax())
            {

                $data = ['ingredients_name' => $ingredients_name];
                
                $ingredients = ingredients_m::where(['ingredients_id' => $ingredients_id])->update($data);

                $ing_id = ingredients_m::where(['ingredients_id' => $ingredients_id])->first();

                if($ingredients){
                    $get_ingredients = ingredients_m::where(['recipe_id' => $ing_id->recipe_id])->orderBy('ingredients_id','DESC')->get();

                    if(count($get_ingredients) > 0){
                        foreach ($get_ingredients as $value) {
                            $output .= '
                                <tr id="tr_'. $value->ingredients_id .'">
                                <td width="10">'.$no.'</td>
                                <td style="white-space:pre-wrap">'. $value->ingredients_name .'</td>
                                <td style="width:100px">
                                
                                <a href="javascript:void(0);" id="edit" data-id="'.$value->ingredients_id.'" data-toggle="modal" data-target="#edit_item_model"><button  class="btn waves-effect waves-light btn-info btn-icon" title="Edit" style="margin-right:0px;" id="add_btn"><i class="fa fa-edit" ></i></button></a>&nbsp;
                                
                                <a href="javascript:void(0);" onclick="get_item_id('. $value->ingredients_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>
                            

                                </td>
                                </tr>';
                            $no++;
                        }
                    }else{
                        $no_record = true;
                        $output = '';
                    }

                    $data=[];
                    $data['ingredients'] = $output;
                    echo json_encode($data);
                    
                }else{
                    echo 2;
                }
            }
        
    }

    public function ingredients_delete(Request $request)
    {
    
        $id = $request->id;
        $get_ingredients = ingredients_m::where(['ingredients_id' => $id])->first();
      
        if(!is_null($get_ingredients)){

            

            $delete_ingredients= ingredients_m::where('ingredients_id',$id)->delete();
           
            if($delete_ingredients){
                echo 0;
                $delete_shopping_list_item = list_item_model_m::where(['ingredients_id' => $id])->delete();
                
            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
        
    }

    public function get_image(Request $request){
        $id = $request->recipe_id;
        $no_record = false;
        $output = '';
        $no = 1;
        $get_image = recipe_image_m::where(['recipe_id' => $id])->orderBy('recipe_image_id','DESC')->get();
        if(count($get_image) > 0){
            foreach ($get_image as $value) {
                $recipe_image = asset("public/storage/images/recipe_image/".$value->recipe_image_name); 
                $output .= '
                    <tr id="tr_'. $value->recipe_image_id .'">
                   
                    <td style="width:100px;padding: .99rem"><img src='.$recipe_image.' style="width:100px;  max-height:100px; object-fit: cover;"></td>
                     <td style="width:100px">
                                
                            <a href="javascript:void(0);" onclick="get_image_id('. $value->recipe_image_id .')"><button id="delete_btn" class="btn waves-effect waves-light btn-danger btn-icon"   title="Delete"><i class="fa fa-trash"></i></button></a>

                            

                                </td>

                    </tr>';
                $no++;
            }
        }else{
            $no_record = true;
            $output = '';
        }

        $data=[];
        $data['image'] = $output;
        echo json_encode($data);
    }

    public function image_delete(Request $request){
        $id = $request->id;
        $get_image = recipe_image_m::where(['recipe_image_id' => $id])->first();
      
        if(!is_null($get_image)){

            

            $delete_image= recipe_image_m::where('recipe_image_id',$id)->delete();
           
            if($delete_image){
                if($get_image->recipe_image_name != ""){
                        $path = 'public/storage/images/recipe_image/';
                        $image_name = $path.$get_image->recipe_image_name;
                
                        if (file_exists($image_name)) {
                            @unlink($image_name);
                        }
                    }
                
                echo 0;
            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
    }

    public function add_image(Request $request,$id){
      
        $recipe_image = $request->file('image');

        $filenames = 'recipe_'.rand().'.'.$recipe_image->getClientOriginalExtension();

        $path = $recipe_image->storeAs('public/images/recipe_image',$filenames);

        $data = [
                'recipe_id' => $id,
                'recipe_image_name' => $filenames,
                
        ];

        $recipe_image=recipe_image_m::create($data);

        if($recipe_image){
           echo 1;
        }else{
            echo 0;
        }

    }
    
    public function hide_show_recipe(Request $request){
        session()->regenerate();
        $id = $request->id;
        $get_recipe = recipe_m::where(['recipe_id' => $id])->first();
       
      
        if(!is_null($get_recipe)){
            if($get_recipe->is_hide == 0){
                $update_data = ['is_hide' => 1];
            }else{
                $update_data = ['is_hide' => 0];
            }
            $update_id = recipe_m::where(['recipe_id' => $id,'is_deleted'=>0])->update($update_data);
           
            if($update_id){
                echo 0;

            }else{
                echo 1;
            }
        }
        else{
            echo 1;
        }
    }
    

    
}

   
