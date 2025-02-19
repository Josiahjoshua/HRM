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
    @can('Create Department')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-5">
            <div class="card card-outline-info">
                <h3 class="card-header">Add Department</h3>
                <div class="card-body">
                    <form method="post" action="department" enctype="multipart/form-data">
                        <div class="form-body">
                            <div class="row ">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label">Department Name</label>
                                        <input type="text" name="dep_name" id="department_name" value="" class="form-control" minlength="4" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary active "> Save</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>
        @endcan
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
                                @foreach ($dep as $department)
                                <tr>
                                    <td><?php echo $department->dep_name; ?></td>
                                    <td class="jsgrid-align-center ">
                                        <div class="row">
                                            @can('Edit Department')
                                            <a href="{{ route('department.edit', $department->id)}}" class="ml-2 btn btn-primary">Edit</a>
                                            @endcan
                                             @can('Delete Department')
                                            <form action="{{ route('department.destroy', $department->id )}}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="ml-2 btn btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                <?= csrf_field() ?>
                                            </form>
                                             @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection