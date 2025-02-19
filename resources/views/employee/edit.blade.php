@extends('layouts.app')

@section('content')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Edit Employee
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
        </div>
    </section>
            
    <div class="container-fluid">    
        <div class="row mt-4">
                    <div class="col-12" >
            
                            <div class="tab-content">
                            <div class="card card-outline-info tab-pane fade show active"  id="home" role="tabpanel">
                            <div class="card-body">
                                <form class="row" method="post" action="{{ route('employee.update', $employee->id ) }}" enctype="multipart/form-data">
                                            @csrf
                                       @method('PUT') 
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Full Name </label>
                                        <input type="text" id="" name="name" class="form-control form-control-line" value="{{ $employee->name }}" placeholder="Your name" minlength="2" required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Department</label>
                                        <select name="dep_name" class="form-control custom-select" required>
                                            <option>Select Department</option>
                                            @foreach ($department as $dept)
                                            <option value="{{ $dept->id }}"{{ $dept->id == $employee->department_id ? ' selected' : '' }}>
                                                {{ $dept->dep_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Designation</label>
                                        <select name="des_name" class="form-control custom-select" required>
                                            <option>Select Designation</option>
                                            @foreach ($designation as $desig)
                                            <option value="{{ $desig->id }}"{{ $desig->id == $employee->designation_id ? ' selected' : '' }}>
                                                {{ $desig->des_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Gender </label>
                                        <select name="gender" class="form-control custom-select" required>
                                            <option>Select Gender</option>
                                            <option value="MALE" {{ $employee->em_gender=== 'MALE' ? 'Selected' : '' }}>Male</option>
                                            <option value="FEMALE" {{ $employee->em_gender=== 'FEMALE' ? 'Selected' : '' }}>Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Contact Number </label>
                                        <input type="text" name="em_phone" class="form-control" value="{{ $employee->em_phone }}" placeholder="+25501231456" minlength="10" maxlength="15" required> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>End of Contract</label>
                                        <input type="date" name="end_date" id="example-email2"  value="{{ $employee->em_contract_end }}" class="form-control" placeholder=""> 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Email </label>
                                        <input type="email" id="example-email2" name="email" value="{{ $employee->email }}" class="form-control" placeholder="email@mail.com" minlength="7" required > 
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Address</label>
                                        <input type="text" name="em_address" class="form-control" value="{{ $employee->em_address }}" required> 
                                    </div>

                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Date Of Birth</label>
                                        <input type="date" name="dob" class="form-control" value="{{ $employee->dob }}" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ $employee->start_date }}" required>
                                    </div>
                                    <div class="form-group col-md-3 m-t-20">
                                        <label>Upload Contrat</label>
                                        <input type="file" name="contract" class="form-control" value="{{ $employee->contract }}">
                                    </div>
                                    <div class="form-actions col-md-12">
                                        <button type="submit" class="btn btn-info"> <i class="fa fa-check"></i> Update</button>
                                    </div>
                                    <?=csrf_field()?>  
                                </form>
                                 </div>
                                 </div>
            
                        </div>
</div>
                  
                </div>
              
            </div>
                    </div>
                </div>
    </div> 
</div>           

@endsection