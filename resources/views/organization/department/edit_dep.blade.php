@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                      Departments
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Departments</li>
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
            <div class="message"></div> 
            <div class="container-fluid">         
                <div class="row">
                    <div class="col-lg-5">
                        <div class="card card-outline-info">
                        <h3 class="card-header">Edit Department</h3>
                            <div class="card-body">
                            <form method="post" action="{{ route('department.update', $dep->id ) }}">
                                        <div class="form-body">
                                            <div class="row ">
                                            @csrf
                                       @method('PATCH')    
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="control-label">Department Name</label>
                                                        <input type="text" name="dep_name" id="department_name" value="{{ $dep->dep_name }}"  class="form-control" minlength="4" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-actions">
                                            <button type="submit" class="btn btn-primary active ">Edit</button>
                                        </div>
                                        <?=csrf_field()?> 
                                    </form>
                            </div>
                        </div>
                       </div>
                    <div class="col-7">
                        <div class="card card-outline-info">
                        <h3 class="card-header"> Department List</h3>
                        <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="" class="display  table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Department Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Department Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>   
                                        <tbody>
                                           
                                            <tr>
                                                <td>{{$dep->dep_name}}</td>
                                                <td class="jsgrid-align-center ">
                                                   <div class="row">
                                                <a href="{{ route('department.edit', $dep->id)}}" class="ml-2 btn btn-primary">Edit</a>
                                               <form action="{{ route('department.destroy', $dep->id )}}" method="post">
                                                  @csrf
                                             @method('DELETE')
                  <button class="ml-2 btn btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                  <?=csrf_field()?>
                </form>
</div>
                                                </td>
                                            </tr>
                                        
                                        </tbody> 
                                       
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
</div>
    @endsection
    