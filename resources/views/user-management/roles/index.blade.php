@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Roles
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Roles</li>
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
        @can('Add user role')
        <div class="col-sm-6">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> click here to add Roles</button>
        </div>
        @endcan
    </section>
    <!-- Roles-list -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">List of Roles</h3>
                        </div>
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              
                                <tbody>
                                    @foreach ($roles as $role)
                                    <tr>
                                        
                                        <td>{{ $role->name }}</td>
                                        <td>
                                            <div class="d-flex">
                                               
                                                <a href="{{ route('roles.edit', $role->id) }}" class="edit-button">
                                                    <i class="fas fa-pencil-alt"></i> Assign Permissions
                                                </a>

                                                <form action="{{ route('roles.destroy', $role->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="ml-4 delete-button" type="submit" onclick="return confirm('Are you sure  you want to delete?')"><i class="fas fa-trash-alt"></i> Delete</button>
                                                    <?= csrf_field() ?>
                                                </form>
                                               
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
    </section>
</div>
<!-- create-modal-role -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Role</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form role="form" action="{{route('roles.store')}}" method="post" id="loanvalueform" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message-text" class="control-label">Name</label>
                            <input type="text" name="name" class="form-control" id="recipient-name1">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                    <?= csrf_field() ?>
                </form>
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