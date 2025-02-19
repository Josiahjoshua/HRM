@extends('layouts.app')

@section('content')
    <div class="page-wrapper">
        <div class="message"></div>
        <div class="header">
            <div class="container-fluid">
                <div class="header-body ml-1">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Leave application
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid mt-4">
                <div class="row m-b-10">

                    <div class="col-12">
                        <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                                data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                    aria-hidden="true"></i> Add Application </a></button>
                    </div>

                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0"> Application List
                                </h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example"
                                        class="display nowrap table table-hover table-striped table-bordered"
                                        cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee Name</th>
                                                <th>PIN</th>
                                                <th>Leave Type</th>
                                                <th>start Date</th>
                                                <th>End Date</th>
                                                <th>Leave Duration</th>
                                                <th>Day Remain</th>
                                                <th>Leave Status</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($leave_apply as $apply)
                                                <tr style="vertical-align:top">

                                                    <td><mark>{{ $apply->employee->name }}</mark></td>
                                                    <td>{{ $apply->employee->em_code }}</td>
                                                    <td>{{ $apply->leave_type->leavename }}</td>
                                                    <td>{{ $apply->start_date }}</td>
                                                    <td>{{ $apply->end_date }}</td>
                                                    <td>{{ $apply->total_day }} days</td>
                                                    <td>{{ $apply->day_remain }} days</td>



                                                    <td>



                                                        @if (is_null($apply->num_approvals))
                                                            <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                                        @elseif($apply->num_approvals == 1)
                                                            <span class="p-2 mb-1 bg-info text-white">Approved by 1</span>
                                                        @elseif($apply->num_approvals == 2)
                                                            <span class="p-2 mb-1 bg-info text-white">Approved by 2</span>
                                                        @elseif($apply->num_approvals == 3)
                                                            <span class="p-2 mb-1 bg-success text-white">Approved by
                                                                3</span>
                                                        @elseif($apply->num_approvals == 0)
                                                            <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                                        @endif
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
                <div class="modal fade" id="appmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h4 class="modal-title" id="exampleModalLabel1">Leave Application</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                            </div>
                            <form method="post" action="{{ route('leave_apply.store') }}" id="leaveapply"
                                enctype="multipart/form-data">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label>Employee</label>
                                        <select class="js-example-basic-single" tabindex="1" name="first_name"
                                            style="width:100%" required>
                                            <option value="">Select Here</option>
                                            @foreach ($employee as $employees)
                                                <option value="{{ $employees->id }}">{{ $employees->first_name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Leave Type</label>
                                        <select class="js-example-basic-single" tabindex="1" name="leave_type_id"
                                            id="leavetype"style="width:100%" required>
                                            <option value="">Select Here..</option>
                                            @foreach ($leave_type as $leave)
                                                <option value="{{ $leave->id }}"> {{ $leave->leavename }} </option>
                                            @endforeach
                                        </select>
                                    </div>


                                    <div class="form-group">
                                        <label class="control-label" id="hourlyFix">Start Date</label>
                                        <input type="date" name="startdate" class="form-control" id="recipient-name1"
                                            required>
                                    </div>
                                    <div class="form-group" id="enddate">
                                        <label class="control-label">End Date</label>
                                        <input type="date" name="enddate" class="form-control" id="recipient-name1">
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Description</label>
                                        <textarea class="form-control" name="reason" id="message-text1" required></textarea>
                                    </div>
                                    <div class="form-group">
                                        <input hide="hidden" type="hidden" class="form-control" name="total_day"
                                            id="message-text1" required minlength="10">
                                    </div>
                                    <div class="form-group">
                                        <input hide="hidden" type="hidden" class="form-control" name="day_remain"
                                            id="message-text1" required minlength="10">
                                    </div>

                                </div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label class="control-label">Select Approvers</label>

                                        <select class="js-example-basic-multiple" data-placeholder="Choose Approver"
                                            multiple="multiple" tabindex="1" class="form-control" name="assignto[]">
                                            @foreach ($employee as $collaborators)
                                                <option value="{{ $collaborators->id }}">{{ $collaborators->first_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <input type="hidden" name="id" class="form-control" id="recipient-name1"
                                        required>
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <?= csrf_field() ?>
                            </form>
                        </div>
                    </div>
                </div>
                <script>
                    // In your Javascript (external .js resource or <script> tag)
                    $(document).ready(function() {
                        $('.js-example-basic-single ').select2({
                            dropdownParent: $("#appmodel")
                        });
                    });
                </script>
                <script>
                    $(document).ready(function() {
                        var table = $('#example').DataTable({
                            lengthChange: false,
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#example_wrapper .col-md-6:eq(0)');
                    });
                </script>
                <script>
                    // In your Javascript (external .js resource or <script> tag)
                    $(document).ready(function() {
                        $('.js-example-basic-multiple').select2();
                    });
                </script>
            @endsection
