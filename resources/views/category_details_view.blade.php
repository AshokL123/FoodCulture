<?php

    $category = json_decode($category);
    if(!empty($category)){
           
            $category_id = $category->category_id;
            $category_name = $category->category_name;
            $category_image = $category->category_image;
            $description = $category->description;

        }


?>
@extends('header')

@section('title')
   Category
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
                   
                </div>
                <div class="col-lg-4">
                    <div class="page-header-breadcrumb">
                        <ul class=" breadcrumb breadcrumb-title">
                            <li class="breadcrumb-item">
                                <a href="{{ url('welcome') }}"><i class="feather icon-home"></i></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ url('/Category') }}">Categories</a> 
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
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <h5>Category Details</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="row">
                                                    <label class="col-sm-12">
                                                        <a href="{{asset('public/storage/images/category')}}/{{$category_image}}" target="_blank">
                                                            <img src="{{asset('public/storage/images/category')}}/{{$category_image}}" height="250" width="100%" style="object-fit: contain;border-radius: 4px;">
                                                        </a>
                                                    </label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 label-bold">Category Name</label>
                                                    <label class="col-sm-8">{{$category_name}}</label>
                                                </div>
                                                <div class="row">
                                                    <label class="col-sm-4 label-bold">Description</label>
                                                    <label class="col-sm-8">{{$description}}</label>
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

            
           
        });


         

        

        

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
