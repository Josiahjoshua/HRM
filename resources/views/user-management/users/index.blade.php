@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Users
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
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

        @if(Session::get('success', false))
    <?php $data = Session::get('success'); ?>
    @if (is_array($data))
        @foreach ($data as $msg)
            <div class="alert alert-success" role="alert">
                <i class="fa fa-check"></i>
                {{ $msg }}
            </div>
        @endforeach
    @else
        <div class="alert alert-success" role="alert">
            <i class="fa fa-check"></i>
            {{ $data }}
        </div>
    @endif
@endif

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
    </section>
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
                                        <th>Role</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>

                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->roles[0]->name ?? '' }}</td>
                                        <td>
                                            <div class="d-flex">
                                                
                                               @can('Update users') <button href="{{ route('users.edit', $user->id) }}" data-id="{{$user->id}}" class="btn btn-info mr-3" data-toggle="modal" data-target="#editRole">Role</button>
                                               
                                            <!--    <form action="{{ route('users.destroy', $user->id) }}" method="post">-->
                                            <!--    @csrf-->
                                            <!--    @method('DELETE')-->
                                            <!--    <button class="ml-4 btn btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>-->
                                            <!--    <?= csrf_field() ?>-->
                                            <!--</form>-->
                                            
    <button class="view-ChangePassword-modal btn btn-primary mr-2"
    data-toggle="modal"
    data-asset="{{ $user->id }}"
    data-asset-id="{{ $user->id }}"
    data-target="#ChangePassword"
    onclick="setUserId(this)">
    Change Password
</button>
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
    </section>
</div>
</section>
<!-- create-modal-role -->

<div class="modal fade" id="editRole" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title" id="exampleModalLabel">Edit User Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editRoleForm" method="post">
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Role</label>
                        <div class="col-sm-6">
                            <select name="role" id="role">
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">
                                    {{$role->name}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0 d-flex justify-content-center">
                    <button type="submit" class="btn btn-success">Save</button>
                </div>
                @csrf
            </form>
        </div>
    </div>
</div>
<!--<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header border-bottom-0">-->
<!--                <h5 class="modal-title" id="exampleModalLabel">Add User</h5>-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                    <span aria-hidden="true">&times;</span>-->
<!--                </button>-->
<!--            </div>-->
<!--            <form id="addForm" action="{{route('users.store')}}" method="post">-->
<!--                <div class="modal-body">-->
<!--                    <div class="form-group row">-->
<!--                        <label for="name" class="col-sm-2 col-form-label">Name</label>-->
<!--                        <div class="col-sm-8">-->
<!--                            <input id="name" class="form-control" name="name" />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group row">-->
<!--                        <label for="email" class="col-sm-2 col-form-label">Email</label>-->
<!--                        <div class="col-sm-8">-->
<!--                            <input id="email" class="form-control" name="email" />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                    <div class="form-group row">-->
<!--                        <label for="password" class="col-sm-2 col-form-label">Password</label>-->

<!--                        <div class="col-sm-8">-->

<!--                            <input id="password" type="password" class="form-control " name="password" />-->

<!--                        </div>-->
<!--                    </div>-->
                  

<!--                        <input id="password-reset" type="hidden" class="form-control " name="password_reset" />-->


<!--                </div>-->
<!--                <div class="modal-footer border-top-0 d-flex justify-content-center">-->
<!--                    <button type="submit" class="btn btn-success">Save</button>-->
<!--                </div>-->
<!--                @csrf-->
<!--            </form>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

        <div>
      <div class="modal fade" id="ChangePassword" tabindex="-1" role="dialog" aria-labelledby="ChangePassword" aria-hidden="true" >    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ChangePassword">Admin Change User Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form role="form" method="POST" action="{{ route('editUserPassword') }}" id="loanvalueform"
                            enctype="multipart/form-data">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                                      <input type="hidden" id="user_id" name="user_id" value="">
                            <div class="modal-body">
                            <div class="form-group">
                            <label for="new_password" class="control-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password"
                                pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                title="Password must be at least 8 characters long and include at least one letter, one number, and one special character."
                                required>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="control-label">Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control"
                                id="confirm_password" required>
                        </div>
                              
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                                <?= csrf_field() ?>
                        </form>

            </div>

        </div>
    </div>
</div>
            </div>
             </div>
</section>
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
<script>
   $(function() {  $('#editRole').on('show.bs.modal', function(event) {
        let button = event.relatedTarget;
        let id = $(button).data('id');
        let action = "{{ route('users.roles.update', 'user_id') }}";
        action = action.replace('user_id', id);
        $('#editRoleForm').attr('action', action);
    })
   })
</script>

<script>
function setUserId(button) {
    var userId = button.getAttribute('data-asset-id');
    document.getElementById('user_id').value = userId;
}
</script>

@endsection