@extends('header')

@section('title')
   
@endsection

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/css-toggle-switch@latest/dist/toggle-switch.css" />
    
<style type="text/css">
    .list-group-item {
        padding: 1px 1.25rem;
    }
    body ul {
      padding: 0px;
    }
    body ul .draggable {
      will-change: transform;
      font-family: "Raleway", sans-serif;
      font-weight: 500;
      /*height: 50px;*/
      list-style-type: none;
      margin: 5px;
      /*background-color: #263544;
      color: #b7c0cd;*/
      color: #000000;
      background-color: rgb(64 153 255 / 14%);
      /*width: 250px;*/
      line-height: 2.75;
      /*padding-left: 10px;*/
      cursor: move;
      transition: all 200ms;
      user-select: none;
     /* margin: 10px auto;*/
      position: relative;
      border-radius: 4px;
    }
    body ul .draggable:after {
      content: 'drag me';
      right: 7px;
      font-size: 10px;
      position: absolute;
      cursor: pointer;
      line-height: 5;
      transition: all 200ms;
      transition-timing-function: cubic-bezier(0.48, 0.72, 0.62, 1.5);
      transform: translateX(120%);
      opacity: 0;
    }
    body ul .draggable:hover:after {
      opacity: 3;
      transform: translate(0);
    }
     
    .over {
      transform: scale(1.1, 1.1);
    }
</style>    
<!-- [ navigation menu ] end -->
<div class="loading">Loading&#8230;</div>
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
                                    <div class="col-lg-5">
                                        <div class="card">
                                            <div class="padding-header">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <h5>Category List</h5>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="padding-block">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                    <ul id="category_list" class="list-group list-group-hover list-group-striped">
                                                        @foreach ($list as $value)
                                                        <li class="list-group-item draggable" draggable="true" data-id="{{$value->category_id}}" value="{{$value->category_id}}">{{$value->category_name}}</li>
                                                        
                                                        @endforeach
                                                    </ul>
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
        
        $(".loading").css("display", "none");
        
        var listItens = document.querySelectorAll('.draggable');
        [].forEach.call(listItens, function(item) {
            
          addEventsDragAndDrop(item);
          
        });

        function addEventsDragAndDrop(el) {
          el.addEventListener('dragstart', dragStart, false);
          el.addEventListener('dragenter', dragEnter, false);
          el.addEventListener('dragover', dragOver, false);
          el.addEventListener('dragleave', dragLeave, false);
          el.addEventListener('drop', dragDrop, false);
          el.addEventListener('dragend', dragEnd, false);
        }
        // Code By Webdevtrick ( https://webdevtrick.com )
        var btn = document.querySelector('.add');
        var remove = document.querySelector('.draggable');
        var first_li;
        var end_li;
        function dragStart(e) {
          this.style.opacity = '2';
          dragSrcEl = this;
          e.dataTransfer.effectAllowed = 'move';
          e.dataTransfer.setData('text/html', this.innerHTML);
         
          first_li = $(this).val();
        };
         
        function dragEnter(e) {
          this.classList.add('over');
          
        }
         
        function dragLeave(e) {
          e.stopPropagation();
          this.classList.remove('over');
        }
         
        function dragOver(e) {
          e.preventDefault();
          e.dataTransfer.dropEffect = 'move';

          return false;
        }
         
        function dragDrop(e) {
          if (dragSrcEl != this) {
            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = e.dataTransfer.getData('text/html');
            var end_li="";
            console.log($(this).val());
            end_li = $(this).val();
            sort_category(first_li,end_li);
          }
          return false;
        }
         
        function dragEnd(e) {
          var listItens = document.querySelectorAll('.draggable');
            
          [].forEach.call(listItens, function(item) {
            
            item.classList.remove('over');
            
          });
          this.style.opacity = '1';
       
        }
         
        
         

         
      

        function sort_category(first,second){
            console.log(first+"   ");
            console.log(second);
            $.ajax({
               type:'POST',
               data:{first_cat:first,second_cat:second},
               url: '{{ url("/sort_category") }}',
               success:function(data){
                   if(data == 0){
                       
                   }else{
                        var json_obj = $.parseJSON(data);
                        $("#category_list").html(json_obj.list);
                        var listItens = document.querySelectorAll('.draggable');
                        [].forEach.call(listItens, function(item) {
                            
                          addEventsDragAndDrop(item);
                          
                        });
                        first_li = "";
                        end_li = "";
                   }
                
               },beforeSend: function(){
                    $(".loading").css("display", "block");
                    
               },complete: function(){
                    $(".loading").css("display", "none");
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
