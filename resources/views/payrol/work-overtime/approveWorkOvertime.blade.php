@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="message"></div>
        <div class="row page-titles">
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body ml-3">
                        <div class="row align-items-end">
                            <div class="col">
                                <h1 class="header-title">
                                    Work Overtime
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid ">
            <div class="row m-b-10">
                {{-- <div class="col-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Add Work-Overtime</a></button>

                </div> --}}
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Work-Overtime list </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <th>Employee Name</th>
                                            <th>Date</th>
                                            <th>Total hours</th>
                                            <th>Amount@hour</th>
                                            <th>Total Amount</th>
                                            <th>Proof</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($work_overtime as $work)
                                            <tr>

                                                <td>{{ $work->user->name }}</td>
                                                <td>{{ $work->date }}</td>
                                                <td>{{ $work->total_hours }}</td>
                                                <td>{{ number_format($work->amount_per_hour) }}</td>
                                                <td>{{ number_format($work->amount_per_hour * $work->total_hours) }}</td>
                                                <td><a href="{{ route('work.download', $work->id) }}" target="_blank">View Proof</a></td>
                                

                                                <td>
                                                    @if (is_null($work->status))
                                                        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                                    @elseif($work->status == 1)
                                                        <span class="p-2 mb-1 bg-success text-white">Approved by {{ $work->approverName }}</span>
                                                    @elseif($work->status == 0)
                                                        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{ $work->approverName }}</span>
                                                    @endif
                                                </td>

                                                <td>
                                                    <div class="d-flex">
                                                        @if (is_null($work->status))
   
                                                        @can('update work-overtime')
                                                 
                                                        <a href="{{ route('work-overtime.approve', $work->id) }}"
                                                            title="approve"
                                                            class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                            data-id="<?php echo $work->id; ?>">Approve</a>
                                                        <a href="{{ route('work-overtime.decline', $work->id) }}"
                                                            title="reject"
                                                            class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                                            data-id="<?php echo $work->id; ?>"
                                                            data-value="Rejected">Reject</a><br>
                                                    @elseif($work->status == 1)

                                                    @elseif($work->status == 0)
                                                   
                                                    @endcan
                                                    @endif
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
            <div class="modal fade" id="leavemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Work-OverTime</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('work-overtime.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <input type="text" name="employee_id" class="form-control"
                                        value={{ $employee->name }} id="recipient-name1" readonly>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Upload Date</label>
                                    <input type="date" name="date" class="form-control" id="recipient-name1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Total Hours</label>
                                    <input type="number" step="any" name="hours" class="form-control" id="recipient-name1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Amount Per Hour</label>
                                    <input type="number" step="any" name="amountPerHour" class="form-control" id="recipient-name1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Proof</label>
                                    <input type="file" name="file_url" class="form-control" id="recipient-name1"
                                        required>
                                </div>

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
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single ').select2({
                    dropdownParent: $("#leavemodel")
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
    @endsection
