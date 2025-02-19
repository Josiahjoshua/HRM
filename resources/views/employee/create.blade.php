@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Add Employees
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employees</li>
                        <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                            <script>
                              function goBack() {
                                window.history.back();
                              }
                            </script></li>
                    </ol>
                </div>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </section>
    <div class="col-12 ">
        <div class="card card-primary card-outline card-tabs">
            <div class="card-header p-0 pt-1 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-three-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-three-home-tab" data-toggle="pill" href="#custom-tabs-three-home" role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Registration</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-three-profile-tab" data-toggle="pill" href="#custom-tabs-three-profile" role="tab" aria-controls="custom-tabs-three-profile" aria-selected="false">Excel Registration</a>
                    </li> -->
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-three-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-three-home" role="tabpanel" aria-labelledby="custom-tabs-three-home-tab">
                        <div class="card card-outline-info tab-pane fade show active" id="registration">
                            
                            <div class="card-body">

                                <form class="row" method="post" action="{{route('employee.store')}}" enctype="multipart/form-data">
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Full Name</label>
                                        <input type="text" name="name" class="form-control form-control-line" placeholder="Full name" minlength="2" required>
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Department</label>
                                        <select name="dep_name" value="" class="form-control custom-select" required>
                                            <option>Select Department</option>
                                            @foreach ($employees as $employee)
                                            <option value="{{ $employee->id }}"> {{ $employee->dep_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Designation </label>
                                        <select name="des_name" class="form-control custom-select" required>
                                            <option>Select Designation</option>
                                            @foreach ($value as $employees)
                                            <option value="{{ $employees->id }}"> {{ $employees->des_name }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Gender </label>
                                        <select name="gender" class="form-control custom-select" required>
                                            <option>Select Gender</option>
                                            <option value="MALE">Male</option>
                                            <option value="FEMALE">Female</option>
                                        </select>
                                    </div>
                                  
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Contact Number </label>
                                        <input type="text" name="em_phone" class="form-control"  placeholder="0710153085" minlength="10" maxlength="15" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Email </label>
                                        <input type="email" id="example-email2" name="email" class="form-control" placeholder="email@mail.com" minlength="7" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Address</label>
                                        <input type="text" name="em_address" class="form-control"  placeholder="tabata Po.Box 120" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="dob" class="form-control" placeholder="date of birth" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" placeholder="start date" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Upload Contrat</label>
                                        <input type="file" name="contract" class="form-control" placeholder="contract" required>
                                    </div>
                                    <div class="form-actions col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>

                                    </div>
                                    <?= csrf_field() ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="custom-tabs-three-profile" role="tabpanel" aria-labelledby="custom-tabs-three-profile-tab">
                        <div class="card bg-light mb-3" style="max-width: 60rem">
                            <div class="card-header">Upload the Employee From Excel File</div>
                            <div class="card-body">
                                <h5 class="card-title">
                                    <br>
                                    <p class="card-text pt-4">This part allows you to upload all employee information.</p>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <input id="fileSelect" type="file" name="select_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" />
                                        <div class="col-sm-offset-8 col-sm-8">
                                            <hr class="sidebar-divider d-none d-md-block">
                                            <button type="submit" name="submit" class="btn btn-info"> <i class="fa fa-check"></i> Save</button>
                                        </div>
                                        <?= csrf_field() ?>
                                    </form>
                                </h5>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
           
        </div>
    </div>

</div>



@endsection