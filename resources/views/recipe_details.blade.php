<?php

    $recipe = json_decode($recipe);
    if(!empty($recipe)){
           
            $recipe_id = $recipe->recipe_id;
            $recipe_name = $recipe->recipe_name;
            $instruction = $recipe->instruction;
            $description = $recipe->description;
            $recipe_type = $recipe->recipe_type;
            $time_to_cook = $recipe->time_to_cook;
            $no_people = $recipe->no_people_serve;
            $recipe_video = $recipe->recipe_video;
    }


?>
@extends('header')

@section('title')
   
@endsection

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/css-toggle-switch@latest/dist/toggle-switch.css" />
   
    
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
                                                <h5>Recipe Details</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row" id="div_recipe_images">
                                                    
                                                        
                                                        <label class="col-sm-12">
                                                        
                                                                <div class="slideshow-container mb-2" id="show_image">
                                                                     
                                                                  

                                                                 
                                                                </div>
                                                          
                                                        </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">Recipe Name</label>
                                                    <label class="col-sm-7">{{$recipe_name}}</label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">Description</label>
                                                    
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-12">{{$description}}</label>
                                                    
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">Recipe_type</label>
                                                    <label class="col-sm-7">{{$recipe_type}}</label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">Time to cook</label>
                                                    <label class="col-sm-7">{{$time_to_cook}}</label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">No of People to Serve</label>
                                                    <label class="col-sm-7">{{$no_people}}</label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-5 label-bold">Instruction</label>
                                                    
                                                </div>
                                                <div class="row mb-2">
                                                    <label class="col-sm-12">{{$instruction}}</label>
                                                    
                                                </div>
                                                <div class="row">
                                                  <div class="col-sm-12">
                                                                
                                                
                                                    <div class="videos">
                                                        <center>
                                                        <a href="{{asset('public/storage/images/recipe_video')}}/{{$recipe_video}}" class="video" target="_blank">
                                                            <span class="fa fa-play" aria-hidden="true" style="font-size: 40px;"></span>
                                                        <video src="{{asset('public/storage/images/recipe_video')}}/{{$recipe_video}}"></video></a></center>
                                                    </div>
                                                </div></div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="text_user_id" id="txt_user_id" value="">
                            <div class="col-lg-7">
                                <div class="col-sm-12">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                        <div class="col-sm-9">
                                            <h6 style="text-transform: capitalize;">Ingredients List</h6>
                                          </div>
                                          <div class="col-sm-3">
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

                <!-- </div> -->
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

            list_indredients();
           
        });


         if("{{$recipe_video}}" == ""){
            $('.videos').hide();
         }

         if("{{count($recipe_image)}}" == 0){
            $("#div_recipe_images").hide();
         }else{
            var html = "";
            <?php foreach ($recipe_image as $key => $value): ?>
          
              html += `<div class="mySlides1">
                            <a href="{{asset('public/storage/images/recipe_image')}}/{{$value->recipe_image_name}}" target="_blank">
                            <img src="{{asset('public/storage/images/recipe_image')}}/{{$value->recipe_image_name}}" height="200" width="100%" style="object-fit: cover;border-radius: 4px;"></a>
                          </div>`;
            

            <?php endforeach ?>
            html += `<a class="slider_prev" onclick="plusSlides(-1, 0)">&#10094;</a>
                          <a class="slider_next" onclick="plusSlides(1, 0)">&#10095;</a>`;
            $("#show_image").html(html);
         }



         function list_indredients(){
            var id="{{$recipe_id}}";
            $.ajax({
               type:'POST',
               data:{recipe_id:id},
               url: '{{ url("/get_recipe_ingredients") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#Indredients_tbl_body").html(json_obj.ingredients);
                    $('#Indredients_tbl').DataTable({
                        "searching": true,
                         "ordering": true,
                       
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
    <script type="text/javascript">
        var slideIndex = [1,1];
        var slideId = ["mySlides1"]
        showSlides(1, 0);
       

        function plusSlides(n, no) {
          showSlides(slideIndex[no] += n, no);
        }

        function showSlides(n, no) {
          var i;
          var x = document.getElementsByClassName(slideId[no]);
          if (n > x.length) {slideIndex[no] = 1}    
          if (n < 1) {slideIndex[no] = x.length}
          for (i = 0; i < x.length; i++) {
             x[i].style.display = "none";  
          }
          x[slideIndex[no]-1].style.display = "block";  
        }
</script>

   
@endsection
