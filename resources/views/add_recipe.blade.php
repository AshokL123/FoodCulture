@extends('header')

@section('title')
  Add Recipe
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
                                <a href="{{ url('/Recipe') }}">Recipes</a> 
                            </li>
                        </ul>
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
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5>Add Recipe</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="row">
                                            
                                            <div class="col-sm-6">

                                                <label for="cc-number" class="control-label mb-1">Upload Recipe Image</label>  
                                              
                                                <div class="row">
                                              
                                                </div>
                                                <form action="{{URL::to('/add_recipe')}}" class="dropzone"  id="my-dropzone" method="post">
                                                {{csrf_field()}}
                                                </form>
                                                <span id="error_recipe_image" class="help-block"></span>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                      
                                   
                                                        <div class="form-group">
                                                            <form id="recipe-insert" method="post">
                                                            <label for="cc-number" class="control-label mb-1">Category Name</label>
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
                                                            <input  name="recipe_id" type="hidden" class="form-control cc-name valid" id="recipe_id">
                                                           
                                                            <input  name="recipe_name" type="text" class="form-control" id="recipe_name" placeholder="Enter Recipe Name" >
                                                            <span class="help-block"  id="error_recipe_name"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Description</label>
                                                            <textarea  name="description" type="text" class="form-control" id="description" placeholder="Enter description" ></textarea>
                                                            <span class="help-block"  id="error_description"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="cc-number" class="control-label mb-1">Instruction</label>
                                                            <textarea  name="instruction" type="text" class="form-control" id="instruction" placeholder="Enter instruction" ></textarea>
                                                            <span class="help-block"  id="error_instruction"></span>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-sm-7">
                                                                <div class="form-group">
                                                                    <label class="control-label mb-1">Time to Cook</label>
                                                                    <input type="text" class="form-control" id="duration5" name="time_to_cook">
                                                                    
                                                                    <span class="help-block"  id="error_time_to_cook"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-5">
                                                                <label class="control-label mb-2">No. of People to Serve</label>
                                                               <input  name="people" type="number" class="form-control" id="people" placeholder="Enter No of People" >
                                                                <span class="help-block"  id="error_people"></span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row form-group">
                                                            <div class="col col-md-3">
                                                            <label class=" form-control-label">Recipe Type: </label>
                                                            </div>
                                                            <div class="col col-md-9">
                                                                <div class="form-check-inline form-check">
                                                                    <label for="inline-radio1" class="form-check-label ">
                                                                        <input type="radio" id="recipe_type" name="recipe_type" value="free" class="form-check-input" checked="checked">Free
                                                                    </label>
                                                                    <label for="inline-radio2" class="form-check-label " style="margin-left:10px;">
                                                                        <input type="radio" id="recipe_type" name="recipe_type" value="paid" class="form-check-input">Paid
                                                                    </label>
                                                                    
                                                                   
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row form-group">
                                                            <div class="col col-md-5">
                                                            <label class=" form-control-label">Upload Recipe Video: </label>
                                                            </div>
                                                            <div class="col col-md-7">

                                                                <input  name="recipe_video" type="file"  id="recipe_video" style="display: inline-block;" accept="video/*"><br/>
                                                                <span class="help-block"  id="error_recipe_video"></span></div>
                                                        </div>
                                                    </form>
                                                        <div class="row">
                                                            <div class="col-12" id="insert_div">
                                                               
                                                                <button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit" id="submit-all">Save</button>
                                                                <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset" id="cancel_btn">Cancel</button>
                                                            
                                                            </div>
                                                            <div class="col-12" id="update_div">
                                                               
                                                                <button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit" id="update-all">Save</button>
                                                                <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset" id="cancel_btn">Cancel</button>
                                                            
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
        
        


        <div class="pcoded-inner-content" id="ind_content">
            <div class="body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!-- [ page content ] start -->

                        <div class="row">
                           
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-9">
                                                <h6 style="text-transform: capitalize;">Ingredients List</h6>
                                            </div>
                                            <div class="col-sm-3">
                                                <button class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;" data-toggle="modal" data-target="#add_item_model">Add Ingredients</button>
                                            </div>
                                        </div>
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
</div>

<div class="modal fade-scale" id="edit_item_model" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                Edit Ingredients &nbsp;
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                      <div class="row">
                        
                        
                        <div class="col-lg-12">
                            <form method="post" action="{{URL::to('/update_ingredients')}}" id="frm-update" enctype="multipart/form-data" name="frm_update">
                                {{csrf_field()}}
                                 <input type="hidden" id="edit_id" name="edit_id"/>

                                <div class="form-group">
                                    <label for="cc-number" class="control-label mb-1">Ingredients Name</label>
                                    <input type="hidden" id="flag" name="flag" value="true"/>
                                    <input  name="edit_ingredients_name" type="text" class="form-control" id="edit_ingredients_name" placeholder="Enter Ingredients Name" >
                                    <span class="help-block"  id="error_ingredients_name"></span>
                                </div>
                               
                                <div class="row">
                                
                                 
                                    <div class="col-lg-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Update</button>
                                    <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset">Cancel</button>
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
                                <form method="post" id="frm-item-insert" enctype="multipart/form-data" name="frm-item-insert">
                                    {{csrf_field()}}
                                     
                                    <div class="form-group">
                                        <label for="cc-number" class="control-label mb-1">Ingredients Name</label>

                                        <input type="hidden" id="flag" name="flag" value="true"/>
                                        <input  name="ingredient" type="text" class="form-control" id="ingredient" placeholder="Enter Ingredients Name" >
                                        <span class="help-block"  id="error_ingredient"></span>
                                    </div>
                                   
                                    <div class="row">
                                    
                                     
                                        <div class="col-lg-12"><button class="confirm btn btn-md btn-inverse" tabindex="1" style="display: inline-block;" type="submit">Add</button>
                                        <button class="cancel btn btn-md btn-default" tabindex="2" style="display: inline-block;" type="reset">Cancel</button>
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
    </div>

@endsection

@section('script')
<script type="text/javascript">


        $(document).ready(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#update_div').hide();
            $('#ind_content').hide();
           
        });

        
        $('#duration5').durationPicker({
            showDays: false,
            showSeconds: true,
          onChanged: function (newVal) {
            $('#duration-label5').text(newVal);
          }
        });

        $('#OpenImgUpload').click(function(){ $('#imgupload').trigger('click'); });
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var x = document.getElementById("error_image");

                    x.innerHTML = "";
                    $('#OpenImgUpload').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgupload").change(function(){ readURL(this); });

        $(document).on('click','#cancel_btn',function(e){
            $('#recipe-insert').trigger('reset');
            $('.help-block').empty();
        });

        $(document).on('click','#add_ingre_close',function(e){
           
            $('#frm-item-insert').trigger('reset');
            $('.help-block').empty();
        });
        

         
        $( "#ingredient" ).keydown(function() {
            $('#error_ingredient').empty();
        });
       

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
            var recipe_id = $('#recipe_id').val();
            var url="{{URL::to('/add_ingredients')}}/"+recipe_id;
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
                      
                      $('.help-block').empty();
                      $('#frm-item-insert').trigger('reset');
                      $('#add_item_model').modal('hide');
                      $('#Indredients_tbl').DataTable().destroy();
                      
                      $('#Indredients_tbl_body').empty();
                      var json_obj = $.parseJSON(data);
                        $("#Indredients_tbl_body").html(json_obj.ingredients);
                        $('#Indredients_tbl').DataTable({
                            "searching": true,
                             "ordering": true,
                            columnDefs : [
                            { targets: [2], sortable: false},
                            ],
                            order: []
                        });
                    }

                  
                },error: function(XMLHttpRequest, textStatus, errorThrown) {
                    var text="Something went to wrong";
                    showsnackbar(text);
                }
              });
          });

        $('#Indredients_tbl').DataTable({});

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
                    
                        $('#edit_id').val(value.ingredients_id);
                        $('#edit_ingredients_name').val(value.ingredients_name);
                        
                    })
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
                  else{
                    
                     $('.help-block').empty();
                      $('#frm-update').trigger('reset');
                      $('#edit_item_model').modal('hide');
                      $('#Indredients_tbl').DataTable().destroy();
                      
                      $('#Indredients_tbl_body').empty();
                      var json_obj = $.parseJSON(data);
                        $("#Indredients_tbl_body").html(json_obj.ingredients);
                        $('#Indredients_tbl').DataTable({
                            "searching": true,
                             "ordering": true,
                            columnDefs : [
                            { targets: [2], sortable: false},
                            ],
                            order: []
                        });
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
                  closeOnConfirm: true,
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
                             
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "Ingredient can't delete.", "error");
                            }else{
                                swal("Cancelled", "Oops! Something went's Wrong.", "error");
                            }
                       },
                       error:function(data){
                          console.log(data);
                       }
                    });
                  } else {
                    swal("Cancelled", "Your data is safe.", "error");
                  }
            });
        }

        $( "#recipe_name" ).keydown(function() {
             $('#error_recipe_name').empty();
        });
        $( "#description" ).keydown(function() {
             $('#error_description').empty();
        });
        $( "#instruction" ).keydown(function() {
             $('#error_instruction').empty();
        });
        $( "#duration2" ).keydown(function() {
            
            $('#error_time_to_cook').empty();
            
        });
        $( "#people" ).keydown(function() {
             $('#error_people').empty();
        });
        $( "#people" ).change(function() {
            if($('#people').val()=="")
            {
                $('#error_people').text('This field is required');
                return false;
            }
            else{
                $('#error_people').empty();
            }
        });
        $( "#recipe_video" ).change(function() {
            if($('#recipe_video').val()=="")
            {

                $('#error_recipe_video').text('Please Upload Recipe Video file');
                return false;
            }
            else{
                var filename = $('#recipe_video').val();
                if ( /\.(flv|mp4|m3u8|ts|3gp|mov|avi|wmv)$/i.test(filename) ) {
                    $('#error_recipe_video').empty();
                }else{
                    $('#error_recipe_video').text('Please Upload Valid Video file');
                return false;
                }
                
            }
        });
        $( "#category" ).change(function() {
            if($('#category').val()=="")
            {
                $('#error_category').text('Please select Category');
                return false;
            }
            else{
                $('#error_category').empty();
            }
        });

      
       
        Dropzone.options.myDropzone = {
         
            maxFilesize: 1024, //mb- Image files not above this size
            uploadMultiple: true, // set to true to allow multiple image uploads
            parallelUploads: 20, //all images should upload same time
            maxFiles: 20, //number of images a user should upload at an instance
            acceptedFiles: ".png,.jpg,.jpeg,.gif", //allowed file types, .pdf or anyother would throw error
            addRemoveLinks: true, // add a remove link underneath each image to 
            autoProcessQueue: false,
            // Prevents Dropzone from uploading dropped files immediately
            removedfile: function(file) {
                var name = file.name; 
                    
                    var _ref;
                    return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
                },
                init: function() {
                        
                        var submitButton = document.querySelector("#submit-all");
                        myDropzone = this; // closure
                        submitButton.addEventListener("click", function() {
                        if($("#recipe_id").val()==""){
                            


                            if (myDropzone.getQueuedFiles().length > 0) {  
                                $('#error_recipe_image').empty();                      
                                
                            }else{
                               
                                store_recipe();
                            }
                            if($('#recipe_video').val()!="")
                            {

                                
                                var filename = $('#recipe_video').val();
                                if ( /\.(flv|mp4|m3u8|ts|3gp|mov|avi|wmv)$/i.test(filename) ) {
                                    $('#error_recipe_video').empty();
                                }else{
                                    $('#error_recipe_video').text('Please Upload Valid Video file');
                                return false;
                                }
                                
                            }

                        }else{
                     
                            if (myDropzone.getQueuedFiles().length > 0) {  
                                $('#error_recipe_image').empty();                      
                                
                            }else{
                                 update_recipe();
                            }
                            if($('#recipe_video').val()!="")
                            {

                                
                                var filename = $('#recipe_video').val();
                                if ( /\.(flv|mp4|m3u8|ts|3gp|mov|avi|wmv)$/i.test(filename) ) {
                                    $('#error_recipe_video').empty();
                                }else{
                                    $('#error_recipe_video').text('Please Upload Valid Video file');
                                return false;
                                }
                                
                            }
                        }
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
                        if($('#duration2').val()=="")
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
                        
                        
                        
                        myDropzone.processQueue();  
                       
                        
                         // Tell Dropzone to process all queued files.
                    });
                    // You might want to show the submit button only when 
                    // files are dropped here:
                    this.on("addedfile", function() {
                      // Show submit button here and/or inform user to click it.
                    });

                    
                    this.on('sendingmultiple', function (data, xhr, formData) {
                   
                                formData.append("recipe_name", $("#recipe_name").val());
                                formData.append("update_form", $("#update_input").val());
                                formData.append("category", $("#category").val());
                                formData.append("description", $("#description").val());
                                formData.append("instruction", $("#instruction").val());
                                formData.append("time_to_cook", $("#duration5").val());
                                formData.append("people", $("#people").val());
                                formData.append("recipe_type",$("input[name='recipe_type']:checked").val());
                                formData.append('recipe_video', $("#recipe_video").get(0).files[0]);
                                formData.append("recipe_id", $("#recipe_id").val());
                                

                            });
                        this.on("success", function(file, responseText) {
                       
                            if(responseText == 0){
                                 $('.help-block').empty();
                                 $('#error_recipe_name').text('Recipe Name already exists');
                            }else if(responseText == 1){
                                var text="Something went to wrong";
                                showsnackbar(text);
                            }
                            else{
                               
                                $(".dz-remove").hide();
                              
                                $('#recipe_video').val('');
                               
                                if(responseText.flag == 'add'){
                                    
                                    $('#recipe_id').val(responseText.recipe_id);
                                    
                                    
                                    var text="Recipe Inserted Successfully";
                                    showsnackbar(text);
                                    $('#ind_content').show();
                                     $('html, body').animate({
                                            scrollTop: $("#ind_content").offset().top
                                        }, 1000);

                                }
                                if(responseText == 'update'){
                                   
                                    var text="Recipe updated Successfully";
                                    showsnackbar(text);

                                }
                            }
                            
                        });
                    
                    
                    this.on('error', function(file, data) {

                        $(file.previewElement).find('.dz-error-message').hide();
                        
                        var text="Something went to wrong";
                        showsnackbar(text);
                    });
                }
            };
            
            
          

            function update_recipe(){
                var recipe_id = $('#recipe_id').val();
                var url=`{{URL::to('/update_recipe')}}/${recipe_id}`;
                var post=$('#recipe-insert').attr('method');
                var form=document.getElementById("recipe-insert");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:post,
                    url:url,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    dataTy:'json',
                   success:function(data){

                    if(data == 0){
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }if(data == 1){
                        var text="Recipe updated Successfully";
                        showsnackbar(text);
                        $('#recipe_video').val('');
                    }
                        
                   },error: function(XMLHttpRequest, textStatus, errorThrown) {
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }
                });
             }

             function store_recipe(){
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
                if($('#duration2').val()=="")
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
                if($('#recipe_video').val()!="")
                {

                    
                    var filename = $('#recipe_video').val();
                    if ( /\.(flv|mp4|m3u8|ts|3gp|mov|avi|wmv)$/i.test(filename) ) {
                        $('#error_recipe_video').empty();
                    }else{
                        $('#error_recipe_video').text('Please Upload Valid Video file');
                        return false;
                    }
                    
                }
                var url=`{{URL::to('/add_recipe')}}`;
                var post=$('#recipe-insert').attr('method');
                var form=document.getElementById("recipe-insert");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    type:post,
                    url:url,
                    data: new FormData(form),
                    processData: false,
                    contentType: false,
                    dataTy:'json',
                   success:function(data){
                            console.log(data);
                            if(data == 0){
                                 $('.help-block').empty();
                                 $('#error_recipe_name').text('Recipe Name already exists');
                            }else if(data == 1){
                                var text="Something went to wrong";
                                showsnackbar(text);
                            }
                            else{
                               
                                $(".dz-remove").hide();
                               /* $(".dz-hidden-input").prop("disabled",true);*/
                                $('#recipe_video').val('');
                               
                                if(data.flag == 'add'){
                                    
                                    $('#recipe_id').val(data.recipe_id);
                                   
                                    var text="Recipe Inserted Successfully";
                                    showsnackbar(text);
                                    $('#ind_content').show();
                                     $('html, body').animate({
                                            scrollTop: $("#ind_content").offset().top
                                        }, 1000);

                                }
                                if(data == 'update'){
                                   
                                    var text="Recipe updated Successfully";
                                    showsnackbar(text);

                                }
                                

                                
                                
                               

                            }
                        
                   },error: function(XMLHttpRequest, textStatus, errorThrown) {
                        var text="Something went to wrong";
                        showsnackbar(text);
                    }
                });
             }

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
                        
                            var recipe_id=$("#recipe_id").val();
                            if(data == 0){
                                $('.sweet-alert').hide();
                                $('.sweet-overlay').hide();
                                $("body").removeClass(" stop-scrolling");
                              
                                list_indredients(recipe_id);
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

            function list_indredients(recipe_id){
               
                $.ajax({
                   type:'POST',
                   data:{recipe_id:recipe_id},
                   url: '{{ url("/get_ingredients") }}',
                   success:function(data){

                        $('#Indredients_tbl').DataTable().destroy();
                      
                      $('#Indredients_tbl_body').empty();
                      var json_obj = $.parseJSON(data);
                        $("#Indredients_tbl_body").html(json_obj.ingredients);
                        $('#Indredients_tbl').DataTable({
                            "searching": true,
                             "ordering": true,
                            columnDefs : [
                            { targets: [2], sortable: false},
                            ],
                            order: []
                        });

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
