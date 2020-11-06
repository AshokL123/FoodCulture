
@extends('header')

@section('title')
    Change Password
@endsection

@section('content')

<!-- [ navigation menu ] end -->
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="fa fa-lock bg-c-blue"></i>
                        <div class="d-inline">
                            <h5>Change Password</h5>
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
                                <a href="{{ url('change_password') }}">Change Password</a> 
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
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Change Password</h5>
                                    </div>
                                    <div class="card-block">
                                        <form method="post" id="change_password">
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Old Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" id="old_password" name="old_password" class="form-control">
                                                </div>
                                                <span class="col-sm-4" id="error_old_password" ></span>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">New Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" id="new_password" name="new_password" class="form-control">
                                                </div>
                                                <span class="col-sm-4" id="error_new_password" ></span>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-2 col-form-label">Confirm Password</label>
                                                <div class="col-sm-5">
                                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                                                </div>
                                                <span class="col-sm-4" id="error_confirm_password" ></span>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2"></div>
                                                <span class="col-sm-4" id="error_message"></span>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-sm-2"></div>
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-primary btn-round waves-effect waves-light" >Change Password</button>
                                                </div>
                                            </div>
                                            
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- [ page content ] end -->
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

            $("#change_password").on("submit", function (e) {
                e.preventDefault();
                var old_password = $("#old_password").val();
                var new_password = $("#new_password").val();
                var confirm_password = $("#confirm_password").val();

                if (old_password == null || old_password == "") {
                    var data = "Please enter old password.";
                    $("#error_old_password").css('color','red');
                    $("#error_old_password").text(data);                    
                    return false;
                } else {
                    if (old_password.length < 6) {
                        var data = "Old Password must be more then 6 Character";
                        $("#error_old_password").css('color','red');
                        $("#error_old_password").text(data);
                        return false;
                    } else {
                        $("#error_old_password").text("");
                    }
                }

                if (new_password == null || new_password == "") {
                    var data = "Please enter new password.";
                    $("#error_new_password").css('color','red');
                    $("#error_new_password").text(data);
                    return false;
                } else {
                    if (new_password.length < 6) {
                        var data = "New Password must be more then 6 Character";
                        $("#error_new_password").css('color','red');                        
                        $("#error_new_password").text(data);
                        return false;
                    } else {
                        $("#error_new_password").text("");
                    }
                }

                if (confirm_password == null || confirm_password == "") {
                    var data = "Please enter confirm password.";
                    $("#error_confirm_password").css('color','red');
                    $("#error_confirm_password").text(data);
                    return false;
                } else {
                    if (confirm_password.length < 6) {
                        var data = "Confirm Password must be more then 6 Character";
                        $("#error_confirm_password").css('color','red');
                        $("#error_confirm_password").text(data);
                        return false;
                    } else {
                        $("#error_confirm_password").text("");
                    }
                }

                if (confirm_password != new_password) {
                    var data = "New Password and Confirm Password not Match.";
                    $("#error_confirm_password").css('color','red');
                    $("#error_confirm_password").text(data);
                    return false;
                } else {
                    $("#error_confirm_password").text("");
                }

                  $.ajax({
                    type: 'POST',
                    url: "{{ url('/change_password') }}",
                    data: {
                        old_password: old_password,
                        new_password: new_password
                    },
                    success: function (data)
                    {
                        if (data == 0) {
                            window.location.href = "{{ url('/welcome') }}";
                            $("#old_password").val("");
                            $("#new_password").val("");
                            $("#confirm_password").val("");                            
                            $("#error_message").css('color','green');
                            $("#error_message").text('Password Sucessfully Changed');
                        }
                        if (data == 1) {
                            $("#old_password").val("");
                            $("#new_password").val("");
                            $("#confirm_password").val("");                            
                            $("#error_message").css('color','red');
                            $("#error_message").text('Server Authentication Failed Please Try Again');
                        }
                        if (data == 3) {
                            $("#old_password").val("");
                            $("#new_password").val("");
                            $("#confirm_password").val("");                            
                            $("#error_message").css('color','red');
                            $("#error_message").text('Your Old Password Worng');
                        }

                    },
                    error: function () {
                        
                    }
                });
            });
        });
    </script>
@endsection
