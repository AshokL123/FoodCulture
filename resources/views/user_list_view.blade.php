
@extends('header')

@section('title')
    User
@endsection

@section('content')
   
<!-- [ navigation menu ] end -->
    
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
                            <h6>Users</h6>
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
                                <a href="{{ url('/user') }}">User</a> 
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
                                    <div class="col-sm-8">
                                        <h6>User List</h6>
                                    </div>
                                       </div>
                                    </div>
                                    <div class="padding-block">
                                        <div class="dt-responsive table-responsive">
                                            <table id="user_tbl" class="table table-striped table-bordered tbl_font-13">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>First Name</th>
                                                        <th>Last Name</th>
                                                        <th>Email</th>
                                                        <th>Age</th>
                                                        <th>Gender</th>
                                                        <th>ethnicity</th>
                                                        <th>Register Date</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="user_tbl_body">
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
        var truck_ids = '';
        $(document).ready(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            list_user();
         
        });

        function list_user(){
            
            $.ajax({
               type:'POST',
               url: '{{ url("/view_user") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#user_tbl_body").html(json_obj.user);
                    $('#user_tbl').DataTable({
                        "searching": true,
                         "ordering": true,
                        columnDefs : [
                            { targets: [8,3], sortable: false},
                        ],
                        order: []
                    });
               }
            });
         }


         


        function get_user_id(user_id){
            user_ids = user_id;
            swal({
                  title: "Are you sure?",
                  text: "You want to delete these user!",
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
                       data:{user_id: user_ids},
                       url: '<?php echo url('/delete_user'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              $("#tr_"+ user_ids).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                swal("Cancelled", "User can't delete.", "error");
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


        function get_block_unblock(user_id,type_status_user){
            user_ids = user_id;
            type_status_users = type_status_user;
            //alert(type_status_users);
            var mess_block_unblock = "";
            //var succ_block_unblock = "";
            if(type_status_users == "block"){
              mess_block_unblock = "You want to suspend this user!";
              //succ_block_unblock = "Suspend!";
              //succ_block_unblock_mss = "User has been suspend.";
            }else{
              mess_block_unblock = "You want to unsuspend this user!";
              //succ_block_unblock = "Continue!";
              //succ_block_unblock_mss = "User has been .";
            }
            swal({
                  title: "Are you sure?",
                  text: mess_block_unblock,
                  type: "warning",
                  showCancelButton: true,
                  confirmButtonClass: "btn-info",
                  confirmButtonText: "Ok",
                  cancelButtonText: "Cancel",
                  closeOnConfirm: false,
                  closeOnCancel: true
                },
                function(isConfirm) {
                  if (isConfirm) {
                    $.ajax({
                       type:'POST',
                       data:{user_id: user_ids,type_status_users: type_status_users},
                       url: '<?php echo url('/block_user'); ?>',
                       success:function(data){
                            console.log(data);

                            if(data == 0){
                              //$("#tr_"+ user_ids).remove();
                             // swal("Deleted!", "User has been deleted.", "success");
                             location.reload();
                            }else if(data == 1){
                                //swal("Cancelled", "User can't Suspend.", "error");
                                location.reload();
                            }else{
                                //swal("Cancelled", "Oops! Something went's Wrong.", "error");
                                location.reload();
                            }
                       },
                       error:function(data){
                          console.log(data);
                       }
                    });
                  } else {
                    //swal("Cancelled", "Your data is safe.", "error");
                  }
            });
        }
    </script>
@endsection
