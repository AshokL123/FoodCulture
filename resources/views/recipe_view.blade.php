
@extends('header')

@section('title')
    User
@endsection

@section('content')
   
     
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
                    <div class="page-header-title">
                        <i class="fa fa-list-ul bg-c-blue"></i>
                        <div class="d-inline">
                            <h6>Recipe</h6>
                        </div>
                    </div>
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
            <div class="main-body">
                <div class="page-wrapper">
                    <div class="page-body">
                        <!-- [ page content ] start -->
                        
                        <!-- [ page content ] end -->
                    <!-- </div>
                </div>

                <div class="page-wrapper">
                    <div class="page-body"> -->
                        <!-- [ page content ] start -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="padding-header">
                                        <div class="row">
                                          <div class="col-sm-10">
                                            <h6>Recipe List</h6>
                                          </div>
                                          <div class="col-sm-2">
                                            <a href="{{route('add_recipe')}}" class="btn btn-md btn-primary" tabindex="1" style="display: inline-block;float: right;">Add Recipe</a>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="recipe_tbl" class="table table-striped table-bordered nowrap tbl_font-13">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Recipe Name</th>
                                                        <th>View</th>
                                                        <th>Save</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="recipe_tbl_body">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                <!-- </div> -->

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
            
            list_recipe();
         
        });
       
        function list_recipe(){
            
            $.ajax({
            
               type:'POST',
               url: '{{ url("/view_recipe_list") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#recipe_tbl_body").html(json_obj.user);
                    $('#recipe_tbl').DataTable({
                        "searching": true,
                         "ordering": true,
                        columnDefs : [
                            { targets: [1], sortable: false},
                        ],
                        order: []
                    });
               }
            });
         }


        

        


        function get_recipe_id(id){

            swal({
                  title: "Are you sure?",
                  text: "You want to delete these Recipe!",
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
                       url: '<?php echo url('/recipe_delete'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              $("#tr_"+ id).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "Recipe can't delete.", "error");
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
        
        function recipe_hide_show(id,is_hide){
            if(is_hide == 0){
              var text_msg = "You want to hide these Recipe!";
              var text_msg1 = "Recipe can't hide.";
            }else{
              var text_msg = "You want to show these Recipe!";
              var text_msg1 = "Recipe can't show.";
            }
            swal({
                  title: "Are you sure?",
                  text: text_msg,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Yes",
                  cancelButtonText: "No",
                  closeOnConfirm: false,
                  closeOnCancel: false
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                       
                       type:'get',
                       data:{id: id,"_token": "{{ csrf_token() }}"},
                       url: '<?php echo url('/hide_show_recipe'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                             
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", text_msg1, "error");
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

    </script>
@endsection
