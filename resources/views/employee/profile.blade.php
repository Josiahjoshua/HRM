@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                        <li class="breadcrumb-item active">Employee Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="/storage/{{$employee->em_image}}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$employee->name}}</h3>

                            <p class="text-muted text-center">{{$employee->department->dep_name}}</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Designation</b> <a class="float-right">{{$employee->designation->des_name}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>birthdate</b> <a class="float-right">{{$employee->em_birthday}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone number</b> <a class="float-right">{{$employee->em_phone}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$employee->email}}</a>
                                </li>
								<li class="list-group-item">
                                    <b>National id Number</b> <a class="float-right">{{$employee->em_nid}}</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About {{$employee->name}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i>Gender</strong>

                            <p class="text-muted">
                                {{$employee->em_gender}}
                            </p>

                            <hr>

                            <strong><i class="fas fa-map-marker-alt mr-1"></i>Address</strong>

                            <p class="text-muted"> {{$employee->em_address}}</p>
                            <hr>
                            <strong><i class="fas fa-clock mr-1"></i>Date of Joining</strong>

                            <p class="text-muted">{{$employee->em_joining_date}}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
			</div>
		</div>
	</section>

</div>
@endsection