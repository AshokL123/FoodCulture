
@extends('header')

@section('title')
    Pemium Member
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
                            <h6>Premium Members</h6>
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
                                <a href="{{ url('/Premium_Members') }}">Premium Members</a> 
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
                                        <h6>Members List</h6>
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
                                                        <th>Purchase Date</th>
                                                        
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
               url: '{{ url("/premium_members_list") }}',
               success:function(data){
                    var json_obj = $.parseJSON(data);
                    $("#user_tbl_body").html(json_obj.user);
                    $('#user_tbl').DataTable({
                        "searching": true,
                         "ordering": true
                       
                    });
               }
            });
         }


    </script>
@endsection
