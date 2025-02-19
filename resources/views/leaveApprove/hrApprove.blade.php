@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="message"></div>
        <div class="header">
            <div class="container-fluid">
                <div class="header-body ml-1">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Approve Leave application
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid mt-4">
                <div class="row m-b-10">



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
                                                <th>Leave Type</th>
                                                <th>start Date</th>
                                                <th>End Date</th>
                                                <th>Leave Duration</th>
                                                <th>Day Remain</th>
                                                <th>Leave Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($leave_apply as $apply)
                                                <tr style="vertical-align:top">

                                                    <td><mark>{{ $apply->user->name }}</mark></td>
                                                    <td>{{ $apply->leave_type->leavename }}</td>
                                                    <td>{{ $apply->start_date }}</td>
                                                    <td>{{ $apply->end_date }}</td>
                                                    <td>{{ $apply->total_day }} days</td>
                                                    <td>{{ $apply->day_remain }} days</td>

                                                    <td>


                                                        @if (is_null($apply->statusHr))
                                                            <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                                        @elseif($apply->statusHr == 1)
                                                            <span class="p-2 mb-1 bg-success text-white">Approved</span>
                                                        @elseif($apply->statusHr == 0)
                                                            <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                                        @endif

                                                    </td>


                                                    @if ($apply->role == 'manager')
                                                        <td class="d-flex">
                                                            @if (is_null($apply->statusHr))
                                                                <a href="{{ route('leave.hrApprove', $apply->id) }}"
                                                                    title="approve"
                                                                    class=" m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                                    data-id="<?php echo $apply->id; ?>">Approve</a>
                                                                <a href="{{ route('leave.hrDecline', $apply->id) }}"
                                                                    title="reject"
                                                                    class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                                                    data-id="<?php echo $apply->id; ?>"
                                                                    data-value="Rejected">Reject</a><br>
                                                            @elseif($apply->statusHr == 1)

                                                            @elseif($apply->statusHr == 0)
                                                            @endif
                                                        </td>
                                                    @elseif($apply->role !== 'manager')
                                                        <td class="d-flex">
                                                            @if (is_null($apply->statusManager))
                                                                <span class="p-2 mb-1 bg-info text-white">Waiting For
                                                                    Approval from the Manager</span>
                                                            @elseif($apply->statusManager == 1)
                                                                @if (is_null($apply->statusHr))
                                                                    <a href="{{ route('leave.hrApprove', $apply->id) }}"
                                                                        title="approve"
                                                                        class=" m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                                        data-id="<?php echo $apply->id; ?>">Approve</a>
                                                                        <button class="view-leave-modal btn btn-warning mr-2"
    data-toggle="modal"
    data-asset="{{ $apply->id }}"
    data-asset-id="{{ $apply->id }}"
    data-target="#RejectModal"
    onclick="setLeaveId(this)">
    Reject
</button>
                                                                @elseif($apply->statusHr == 1)

                                                                @elseif($apply->statusHr == 0)
                                                                @endif
                                                            @elseif($apply->statusManager == 0)
                                                                <span class="p-2 mb-1 bg-danger text-white">Rejected by
                                                                    {{ $apply->managerApprover }}</span>
                                                            @endif
                                                        </td>
                                                    @endif

                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                                       <div>
      <div class="modal fade" id="RejectModal" tabindex="-1" role="dialog" aria-labelledby="RejectModal" aria-hidden="true">    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="RejectModal">Rejection Reasons</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <form role="form" method="POST" action="{{ route('leave.hrDecline') }}" id="loanvalueform"
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

                                      <input type="hidden" id="asset_id_input" name="leave_id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Rejection Reason</label>
                                    <textarea type="text" name="rejection_reason" id="example-email2" class="form-control"
                                        placeholder="" required></textarea>
                                </div>

                              
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <?= csrf_field() ?>
                        </form>

            </div>

        </div>
    </div>
</div>
            </div>
             </div>
             
               <script>
function setLeaveId(button) {
    // Get the asset_id from the clicked button's data-asset-id attribute
    var leaveId = button.getAttribute('data-asset-id');

    // Set the asset_id in the hidden input field in the modal
    document.getElementById('asset_id_input').value = leaveId;
}
</script>

            @endsection
