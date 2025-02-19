@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row page-titles">
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body ml-4">
                        <div class="row align-items-end">
                            <div class="col">
                                <h1 class="header-title">
                                    Leave Type
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">
            <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Add Leave Types</a></button>
                    <!--<button type="button" class="btn btn-primary"><i class="fa fa-bars"></i><i class=""-->
                    <!--        aria-hidden="true"></i> Leave Application</a></button>-->
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Leave List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example23" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>ID </th>
                                            <th>Leave Type</th>
                                            <th>Number Of Days</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>ID </th>
                                            <th>Leave Type</th>
                                            <th>Number Of Days</th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @foreach ($leave_type as $leave)
                                            <tr>
                                                <td>{{ $leave->id }}</td>
                                                <td>{{ $leave->leavename }}</td>
                                                <td>{{ $leave->day_no }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('leave_type.edit', $leave->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <form action="{{ route('leave_type.destroy', $leave->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="ml-4 btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                        <?= csrf_field() ?>
                                                    </form>
                                                </td>
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
            <div class="modal fade" id="leavemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Leave</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('leave_type.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">

                                <div class="form-group">
                                    <label class="control-label">Leave name</label>
                                    <input type="text" name="leavename" class="form-control" id="recipient-name1"
                                        minlength="1" maxlength="35" value="" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Day</label>
                                    <input type="number" name="day_no" class="form-control" id="recipient-name1"
                                        value="">
                                </div>
                                <!-- <div class="form-group">
                                    <label class="control-label">status</label>
                                    <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" required>
                                        <option value="">Select Here</option>
                                        <option value="1">Active</option>
                                        <option value="0">InActive</option>
                                    </select>
                                </div> -->

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="" class="form-control"
                                    id="recipient-name1">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".leavetype").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute
                    var iid = $(this).attr('data-id');
                    $('#leaveform').trigger("reset");
                    $('#leavemodel').modal('show');
                    $.ajax({
                        url: 'LeaveTypebYID?id=' + iid,
                        method: 'GET',
                        data: '',
                        dataType: 'json',
                    }).done(function(response) {
                        console.log(response);
                        // Populate the form fields with the data returned from server
                        $('#leaveform').find('[name="id"]').val(response.leavetypevalue.type_id).end();
                        $('#leaveform').find('[name="leavename"]').val(response.leavetypevalue.name)
                            .end();
                        $('#leaveform').find('[name="leaveday"]').val(response.leavetypevalue.leave_day)
                            .end();

                    });
                });
            });
        </script>
        <script type="text/javascript">
            $(document).ready(function() {
                $(".holidelet").click(function(e) {
                    e.preventDefault(e);
                    // Get the record's ID via attribute
                    var iid = $(this).attr('data-id');
                    $.ajax({
                        url: 'HOLIvalueDelet?id=' + iid,
                        method: 'GET',
                        data: 'data',
                    }).done(function(response) {
                        console.log(response);
                        $(".message").fadeIn('fast').delay(3000).fadeOut('fast').html(response);
                        window.setTimeout(function() {
                            location.reload()
                        }, 2000)
                        // Populate the form fields with the data returned from server
                    });
                });
            });
        </script>
    @endsection
