
@extends('header')

@section('title')
    Dashboard
@endsection

@section('content')

<!-- [ navigation menu ] end -->
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header card">
            <div class="row align-items-end">
                <div class="col-lg-8">
                    <div class="page-header-title">
                        <i class="feather icon-home bg-c-blue"></i>
                        <div class="d-inline">
                            <h6>Dashboard</h6>
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
                                <a href="{{ url('welcome') }}">Dashboard</a> 
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
                            
                            <div class="col-xl-3 col-md-12">
                                <div class="card comp-card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-b-25">Users</h6>
                                                <h3 class="f-w-700 text-c-blue">{{$users}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{url('/user')}}" style="cursor: default;"><i class="fa fa-users bg-c-blue"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-12">
                                <div class="card comp-card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-b-25">Categories</h6>
                                                <h3 class="f-w-700 text-c-blue">{{$category}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{url('/Category')}}" style="cursor: default;"><i class="fa fa-list-ul bg-c-blue"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-12">
                                <div class="card comp-card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-b-25">Recipes</h6>
                                                <h3 class="f-w-700 text-c-blue">{{$recipe}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{url('/Recipe')}}" style="cursor: default;"><i class="fa fa-utensils bg-c-blue"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-12">
                                <div class="card comp-card">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <h6 class="m-b-25">Premium Members</h6>
                                                <h3 class="f-w-700 text-c-blue">{{$premium}}</h3>
                                            </div>
                                            <div class="col-auto">
                                                <a href="{{url('/Premium_Members')}}" style="cursor: default;"><i class="fa fa fa-user-plus bg-c-blue"></i></a>
                                            </div>
                                        </div>
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

