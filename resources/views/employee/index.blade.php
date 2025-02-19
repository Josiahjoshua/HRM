@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            Employees
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

    @if (session()->get('success'))
    <div class="alert alert-success">
      {{ session()->get('success') }}
    </div>
    <br />
    @endif
    @can('Create employee')
     <div class="col-sm-6">
            <form style="display: inline" action="{{route('employee.create')}}" method="get">
      <button type="submit" class="btn btn-primary my-4">Click here to add employee</button>
    </form>
        </div> 
        @endcan
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">List of Employees</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>

                    <td>Employee Name</td>
                    <td>Gender</td>
                    <td>Email</td>
                    <td>Contact</td>
                    <td>Department</td>
                    <td>Desgnation</td>
                    <td>Date of Birth</td>
                    <td>Start Date</td>
                    <td>End Date</td>
                    <td>Download Contract</td>
                    <td>Action</td>
                  </tr>
                </thead>
                <tbody>
                  @foreach($employee as $employees)
                  <tr>

                    <td>{{$employees->name}}</td>
                    <td>{{$employees->em_gender}}</td>
                    <td>{{$employees->email}}</td>
                    <td>{{$employees->em_phone}}</td>
                    <td>@if($employees->department)
                        {{$employees->department->dep_name}}
                        @else
                        <span class="text-danger">Department unavailable</span>
                        @endif
                        </td>
                    <td>{{$employees->designation->des_name}}</td>
                    <td>{{$employees->dob}}</td>
                    <td>{{$employees->start_date}}</td>
                    <td>@if (is_Null($employees->end_date))
                       <span>Still Working</span>
                       @else
                       {{$employees->end_date}}
                    @endif</td>
                    <td><a href="{{ route('downloadContract', $employees->id) }}"
                      target="_blank">View Contract</a></td>


                      <td>
                        <div class="d-flex">
                            @can('Edit employee')
                          <a href="{{ route('employee.edit', $employees->id)}}" class="btn btn-primary">Edit</a>
                            @endcan
                          <a href="{{ route('employee.show', $employees->id)}}" hidden="hidden" class="ml-4 btn btn-success">Details</a>
                          @can('Delete employee')
                          <form action="{{ route('employee.destroy', $employees->id)}}" method="post">
                            @csrf
                            @method('DELETE')
                            <button  class="ml-4 btn btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                            <?= csrf_field() ?>
                          </form>
                          @endcan
                        </div>
                      </td>

                  </tr>
                  @endforeach
                </tbody>
              </table>
              <div>
              </div>
            </div>
          </div>
        </div>

      </div>
      <script>
        $(function() {
          $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
          }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
          $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
          });
        });
      </script>
      @endsection