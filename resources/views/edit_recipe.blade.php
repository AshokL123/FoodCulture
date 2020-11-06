<?php

    $recipe = json_decode($recipe);
    if(!empty($recipe)){
           
            $recipe_id = $recipe->recipe_id;
            $recipe_name = $recipe->recipe_name;
            $instruction = $recipe->instruction;
            $recipe_type = $recipe->recipe_type;
            $no_people = $recipe->no_people_serve;
            $recipe_video = $recipe->recipe_video;
            $description = $recipe->description;
        }

    $recipe_image = json_decode($recipe_image);
    
    if(!empty($recipe_image)){

        $recipe_image = $recipe_image->recipe_image_name;
           }


?>
@extends('header')

@section('title')
   
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/css-toggle-switch@latest/dist/toggle-switch.css" />
    
     <style type="text/css">
        select.form-control, select.form-control:focus, select.form-control:hover {
         border: 1px solid #ccc;
    
        }
    </style>
<!-- [ navigation menu ] end --> 
<div id="snackbar"></div>       
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
            <div class="alert alert-success alert-dismissible fade show background-success " style="display: none;" id="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                <p id="alert_message"></p>
            </div>
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <!-- <div class="page-header-title">
                        <i class="fa fa-calendar-alt bg-c-blue"></i>
                        <div class="d-inline">
                            <h6>Event</h6>
                        </div>
                    </div> -->
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="{{ url('welcome') }}"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/Recipe') }}">Recipe</a> 
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <div class="pcoded-inner-content">
            <div class="body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!-- [ page content ] start -->

                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5>Edit Recipe Details</h5>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="padding-block">
                                        <div class="row">
                                            
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <form method="post" action="{{URL::to('/update_recipe')}}/{{$recipe_id}}" id="frm-insert" enctype="multipart/form-data" name="frm_insert">
                                                        {{csrf_field()}}
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Category Name</label>
                                                            <input type="hidden" name="recipe_id" id="recipe_id" value="{{$recipe_id}}">
                                                            <select  name="category"  id="category" class="form-control">
                                                                <option value="">Select Category</option>
                                                                @foreach ($category as $value)
                                                                <option value="{{$value->category_id}}">{{$value->category_name}}</option>
                                                                @endforeach
                                                            </select>
                                                            <span class="help-block"  id="error_category"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Recipe Name</label>
                                                            <input  name="recipe_name" type="text" class="form-control" id="recipe_name" placeholder="Enter Recipe Name" value="{{$recipe_name}}" >
                                                            <span class="help-block"  id="error_recipe_name"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Description</label>
                                                            <textarea  name="description" class="form-control" id="description" placeholder="Enter description" rows="5"></textarea>
                                                            <span class="help-block"  id="error_description"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Instruction</label>
                                                            <textarea  name="instruction" class="form-control" id="instruction" placeholder="Enter instruction" rows="5"></textarea>
                                                            <span class="help-block"  id="error_instruction"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label for="cc-number" class="control-label mb-1">Time to Cook</label>
                                                                    <input type="text" class="form-control" id="duration5" name="time_to_cook">
                                                                    <!-- <p>Seconds: <span id="duration-label5"></span></p> -->

                                                                    <span class="help-block"  id="error_time_to_cook"></span>
                                                                </div>
                                                            </div>   
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col col-md-4">
                                                            <label class="form-control-label">Recipe Type:</label>
                                                            </div>
                                                            <div class="col col-md-8">

                                                                <div class="form-check-inline form-check">
                                                                    <label for="inline-radio1" class="form-check-label ">
                                                                        <input type="radio" id="recipe_type" name="recipe_type" value="free" class="form-check-input" >Free
                                                                    </label>
                                                                    <label for="inline-radio2" class="form-check-label " style="margin-left:10px;">
                                                                        <input type="radio" id="recipe_type" name="recipe_type" value="paid" class="form-check-input">Paid
                                                                    </label>
                                                                    
                                                                   
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                        <div class="row form-group">
                                                            
                                                                <div class="col col-md-6">
                                                            <label for="cc-number" class="form-control-label">No. of People to Serve:</label></div>
                                                            
                                                            <div class="col col-md-6">
                                                            <input  name="people" type="number" class="form-control" id="people" placeholder="Enter No of People" ></div>
                                                            <span class="help-block"  id="error_people"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-12"><button class="confirm btn btn-md btn-primary" tabindex="1" style="display: inline-block;" type="submit">Update</button>
                                                            <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;">Cancel</button>
                                                            </div>
                                                        </div>
                                                         </form>
                                                    </div>
                                                </div>
                                                </div>
                                               
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="col-sm-12">
                                        <div class="card">
                                            <div class="padding-header">
                                                <div class="row">
                                                <div class="col-sm-9">
                                                    <h6 style="text-transform: capitalize;">Ingredients List</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;" data-toggle="modal" data-target="#add_item_model">Add Ingredients</button>
                                                </div></div>
                                            </div>
                                            <div class="padding-block">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="dt-responsive table-responsive">
                                                            <table id="Indredients_tbl" class="table table-striped table-bordered nowrap tbl_font-13" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>No</th>
                                                                        <th>Indredients Name</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="Indredients_tbl_body">
                                                                </tbody>
                                                            </table>
                                                                
                                                         </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pcoded-inner-content">
            <div class="body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!-- [ page content ] start -->

                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                <div class="col-sm-9">
                                                    <h6 style="text-transform: capitalize;">Recipe Images</h6>
                                                </div>
                                                <div class="col-sm-3">
                                                    <button class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;" data-toggle="modal" data-target="#add_image_model">Add Image</button>
                                                </div></div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="padding-block">
                                        <div class="row">
                                            
                                            <div class="col-sm-12">
                                                <div class="dt-responsive table-responsive">
                                                            <table id="image_tbl" class="table table-striped table-bordered nowrap tbl_font-13" >
                                                                <thead>
                                                                    <tr>
                                                                       
                                                                        <th>Image</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody id="image_tbl_body">
                                                                </tbody>
                                                            </table>
                                                                
                                                         </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                <div class="col-sm-9">
                                                    <h6 style="text-transform: capitalize;">Recipe Video</h6>
                                                </div>
                                                <!--<div class="col-sm-3">
                                                    <button class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;" onclick="video_edit()">Edit</button>
                                                </div>--></div>
                                            </div>
                                        </div>
                                    </div>
                                    

                                    <div class="padding-block">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="videos mb-3">
                                                        <center>
                                                        <a href="{{asset('public/storage/images/recipe_video')}}/{{$recipe_video}}" class="video" target="_blank">
                                                        <span class="fa fa-play" aria-hidden="true" style="font-size: 40px;"></span>
                                                        <video src="{{asset('public/storage/images/recipe_video')}}/{{$recipe_video}}" ></video></a>
                                                       </a>
                                                        </center>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12">
                                                        <div class="row form-group" id="edit_video_div">
                                                            <div class="col col-md-3">
                                                                <label class=" form-control-label">Update Video:</label>
                                                            </div>
                                                            <div class="col col-md-6">
                                                                <form method="post" action="{{URL::to('/update_video')}}/{{$recipe_id}}" id="frm_video" enctype="multipart/form-data" name="frm_video">
                                                                <input name="video_recipe_id" type="hidden" value="{{$recipe_id}}">
                                                                <input  name="videoupload" type="file"  id="videoupload" style="display: inline-block;"></br>
                                                                <span class="help-block"  id="error_video"></span>
                                                            </div>
                                                            <div class="col col-md-3">
                                                                <button class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;">Upload<span class="fa fa-spinner fa-spin" aria-hidden="true" style="color: #fff;margin-left:10px; " id="loading" ></span></button>

                                                            </div></form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="modal fade-scale" id="add_image_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Add image &nbsp;

            <button type="button" class="close cancel_btn" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-12"> 
                        <div class="form-group has-success"> 
                          <form method="post" action="{{URL::to('/add_image')}}/{{$recipe_id}}" id="image_insert" enctype="multipart/form-data" name="image_insert">
                            {{csrf_field()}}
                            <div style="max-height: 380px;">
                              <input type="file" id="imgupload" name="image"/>
                              
                                <img src="{{asset('public/assets/images/placeholder_square.png')}}" alt="" id="OpenImgUpload" style="width: 100%;object-fit: contain;max-height: 385px;"><span class="help-block" id="error_image"></span>
                            </div>
                        </div>
                        <div class="row">
                        
                         
                            <div class="col-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Save</button>
                            <button class="cancel btn btn-md cancel_btn" tabindex="1" style="display: inline-block;" type="reset">Cancel</button>
                            </div>
                         
                        </div>
                    </div>
                   </form></div>
                </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="modal fade-scale" id="add_item_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-md" role="document">
         <div class="modal-content">
          <div class="modal-header">
            Add Ingredients &nbsp;

            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true" id="add_ingre_close">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    
                    
                    <div class="col-lg-12">
                        <form method="post" action="{{URL::to('/add_ingredients')}}/{{$recipe_id}}" id="frm-item-insert" enctype="multipart/form-data" name="frm-item-insert">
                            {{csrf_field()}}
                             
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Ingredients Name</label>
                            <input  name="ingredient" type="text" class="form-control" id="ingredient" placeholder="Enter Ingredients Name" >
                            <span class="help-block"  id="error_ingredient"></span>
                        </div>
                       
                        <div class="row">
                        
                         
                            <div class="col-lg-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Add</button>
                            <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset">Cancel</button>
                            </div>
                         
                        </div>
                    </div></form></div>
                </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="modal fade-scale" id="edit_item_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            Edit Ingredients &nbsp;

            <button type="button" class="close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    
                    
                    <div class="col-lg-12">
                        <form method="post" action="{{URL::to('/update_ingredients_details')}}" id="frm-update" enctype="multipart/form-data" name="frm_update">
                            {{csrf_field()}}
                             
                        <div class="form-group">
                            <label for="cc-number" class="control-label mb-1">Ingredients Name</label>
                            <input type="hidden" name="edit_id" id="edit_id">
                            <input  name="edit_ingredients_name" type="text" class="form-control" id="edit_ingredients_name" placeholder="Enter Ingredients Name" >
                            <span class="help-block"  id="error_ingredients_name"></span>
                        </div>
                       
                        <div class="row">
                        
                         
                            <div class="col-lg-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Update</button>
                            <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset">Cancel</button>
                            </div>
                         
                        </div>
                    </div></form></div>
                </div>                            
            </div>
          </div>
        </div>
      </div>
    </div>


@endsection

@section('script')
<script type="text/javascript">

        $("#loading").hide();

        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            list_indredients();
            list_recipe_image();
            

            $('#duration5').durationPicker({
                showDays: false,
                showSeconds: true,
              onChanged: function (newVal) {
                $('#duration-label5').text(newVal);
              }
            });
        });
        function htmlDecode(value) {
    return $('<div/>').html(value).text();
}
        $('#instruction').val(htmlDecode(`{{preg_replace( "/<br>|\n/", "", $instruction)}}`));
        $('#description').val(htmlDecode(`{{preg_replace( "/<br>|\n/", "", $description)}}`));
        $('#category').val(htmlDecode("{{$category_name}}"));
        $('#duration5').val("{{$time_to_cook}}");
        $('#people').val("{{$no_people}}");
        $("input[name='recipe_type']").each(function() {
                    if($(this).val()=="{{$recipe_type}}") {
                        if (this.value == 'free') {
                            $("input[name=recipe_type][value=free]").prop("checked",true);
                            $("input[name=recipe_type][value=paid]").prop("checked",false);
                           
                        }
                        else{
                            $("input[name=recipe_type][value=free]").prop("checked",false);
                            $("input[name=recipe_type][value=paid]").prop("checked",true);
                    
                        }
                    } 
                }); 

        $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#error_image').empty();
                    $('#OpenImgUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgupload").change(function(){ readURL(this); });

        $(document).on('click','#add_ingre_close',function(e){
           
            $('#frm-item-insert').trigger('reset');
            $('.help-block').empty();
        });

        $(document).on('click','.cancel_btn',function(e){
            document.getElementById('OpenImgUpload').src="{{asset('public/assets/images/placeholder_square.png')}}";
            $('.help-block').empty();
        });

        function list_indredients(){
            var id="{{$recipe_id}}";
            $.ajax({
               type:'POST',
               data:{recipe_id:id},
               url: '{{ url("/get_ingredients") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#Indredients_tbl_body").html(json_obj.ingredients);
                    $('#Indredients_tbl').DataTable({
                        "searching": true,
                         "ordering": true,
                        columnDefs : [
                            { targets: [1], sortable: false},
                        ],
                        order: []
                    });
               },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
            });
         }

         function list_recipe_image(){
            var id="{{$recipe_id}}";
            $.ajax({
               type:'POST',
               data:{recipe_id:id},
               url: '{{ url("/get_image") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#image_tbl_body").html(json_obj.image);
                    $('#image_tbl').DataTable({
                        "searching": false,
                         "ordering": false,
                      
                    });
               },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
            });
         }

         function video_edit(){
            $('#edit_video_div').show();
         }

        $('#frm-insert').on('submit',function(e){
            e.preventDefault();
            if($('#category').val()=="")
            {
                $('#error_category').text('Please select Category');
                return false;
            }
            else{
                $('#error_category').empty();
            }
            if($('#recipe_name').val()=="")
            {
                $('#error_recipe_name').text('Recipe Name is required');
                return false;
            }
            else{
                $('#error_recipe_name').empty();
            }
            if($('#description').val()=="")
            {
                $('#error_description').text('Description is required');
                return false;
            }
            else{
                $('#error_description').empty();
            }
            if($('#instruction').val()=="")
            {
                $('#error_instruction').text('Instruction is required');
                return false;
            }
            else{
                $('#error_instruction').empty();
            }
            if($('#duration5').val()=="")
            {
                $('#error_time_to_cook').text('Time to cook field is required');
                return false;
            }
            else{
                $('#error_time_to_cook').empty();
            }
            if($('#people').val()=="")
            {
                $('#error_people').text('This field is required');
                return false;
            }
            else{
                $('#error_people').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                    if(data == 2){
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }else{
                        
                        location.reload();

                      
                    }

                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });

         $('#frm_video').on('submit',function(e){
            e.preventDefault();
            if($('#videoupload').val()=="")
            {
                $('#error_video').text('Please Choose Video File');
                return false;
            }
            else{
                var filename = $('#videoupload').val();
                if ( /\.(flv|mp4|m3u8|ts|3gp|mov|avi|wmv)$/i.test(filename) ) {
                    $('#error_video').empty();
                }else{
                    $('#error_video').text('Please Upload Valid Video file');
                    return false;
                }
                
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
            $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                    if(data == 2){
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }else if(data == 1){
                        
                        location.reload();

                      
                    }else{
                         var text="Something went to wrong";
                         showsnackbar(text);
                    }

                  
                }, beforeSend: function(){
                  
                 
                      $("#loading").show();
                  },
              complete: function(){
                    
                        $("#loading").hide();
               },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
            });

        });

        

         $('#image_insert').on('submit',function(e){
            e.preventDefault();
            
            if($('#imgupload').val()=="")
            {
                $('#error_image').text('Recipe Image is required');
                return false;
            }
            else{
                $('#error_image').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                    if(data == 0){
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }else{
                        
                        location.reload();

                      
                    }

                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });

         $(document).on('click','#edit',function(e){
        
            var id=$(this).data('id');
          
           
            $.ajax({ 
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type: 'post',
                url: '{{URL::to("/edit_ingredients")}}', 
                data: {id:id, },
                dataType: 'json',
                success: function (data) 
                {
                    
                    $.each(data,function(i,value){
                    console.log(value);
                    $('#edit_id').val(value.ingredients_id);
                    $('#edit_ingredients_name').val(value.ingredients_name);
                    
                     
                    
                    
                   
                    })
                    
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
                });

   
        })

         $('#frm-item-insert').on('submit',function(e){
            e.preventDefault();
            if($('#ingredient').val()=="")
            {
                $('#error_ingredient').text('Ingredient Name is required');
                return false;
            }
            else{
                $('#error_ingredient').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {

                  if(data == 0){
                    $('.help-block').empty();
                    $('#error_ingredient').text('Ingredient is already exists');
                  }else{
                     
                        location.reload();
                    }

                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });

         $('#frm-update').on('submit',function(e){
            e.preventDefault();
            if($('#edit_ingredients_name').val()=="")
            {
                $('#error_ingredients_name').text('Ingredient Name is required');
                return false;
            }
            else{
                $('#error_ingredients_name').empty();
            }
            var url=$(this).attr('action');
            var post=$(this).attr('method');
             $.ajax({

                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                type:post,
                url:url,
                data: new FormData( this ),
                processData: false,
                contentType: false,
                dataTy:'json',
                success:function(data)
                {
                  if(data == 0){
                    $('.help-block').empty();
                    $('#error_ingredients_name').text('Ingredient is already exists');
                  }
                  if(data == 1){
                    location.reload();
                  }
                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });


        function get_item_id(id){

            swal({
                  title: "Are you sure?",
                  text: "You want to delete these Ingredient!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Yes, delete it!",
                  cancelButtonText: "No, cancel it!",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                       type:'POST',
                       data:{id: id},
                       url: '<?php echo url('/ingredients_delete'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              $("#tr_"+ id).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "Ingredient can't delete.", "error");
                            }else{
                                swal("Cancelled", "Oops! Something went's Wrong.", "error");
                            }
                       },error: function(XMLHttpRequest, textStatus, errorThrown) {
                            var text="Something went to wrong";
                            showsnackbar(text);
                        }
                    });
                  } else {
                    swal("Cancelled", "Your data is safe.", "error");
                  }
            });
        }

         if("{{$recipe_video}}" == ""){
            $('.videos').hide();
         }

        function get_image_id(id){

            swal({
                  title: "Are you sure?",
                  text: "You want to delete these Image!",
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Yes, delete it!",
                  cancelButtonText: "No, cancel it!",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                       type:'POST',
                       data:{id: id},
                       url: '<?php echo url('/image_delete'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              $("#tr_"+ id).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "Image can't delete.", "error");
                            }else{
                                swal("Cancelled", "Oops! Something went's Wrong.", "error");
                            }
                       },error: function(XMLHttpRequest, textStatus, errorThrown) {
                            var text="Something went to wrong";
                            showsnackbar(text);
                        }
                    });
                  } else {
                    swal("Cancelled", "Your data is safe.", "error");
                  }
            });
        }

        function showsnackbar(text){
            var x = document.getElementById("snackbar");
            x.innerHTML = text+"<button id='dismiss' type='button' onclick='hidesnackbar();' class='close' style='padding-left:20px'><span aria-hidden='true' class='fa fa-times' style='font-size: 20px;color:#fff'></span></button> ";
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", "");  x.innerHTML = "";}, 3000);
        }
        function hidesnackbar() {
           var x = document.getElementById("snackbar");
            x.innerHTML='';
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, -1);
        } 

         
    </script>
   
@endsection
