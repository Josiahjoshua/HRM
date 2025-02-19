@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row page-titles">
        <div class="header">
            <div class="container-fluid">
                <div class="header-body ml-3">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Manager Approve Perdeims
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
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 "> Perdeim List </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                        <th>Employee name</th>
                                        <th>Description</th>
                                        <th>Perdeim</th>
                                        <th>Allowance</th>
                                        <th>Approval Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($perdeim as $perdeims)
                                    <tr class="text-nowrap">

                                        <td class="d-flex">
                                            @if ($perdeims->user)
                                            {{ $perdeims->user->name }}
                                            @else
                                            <span class="text-danger">Data unavailable</span>
                                            @endif
                                        </td>
                                        <td>{{ $perdeims->reason }}</td>
                                        <td>{{ $perdeims->amount }}</td>
                                        <td>{{ $perdeims->allowance }}</td>
                                        <td>
                                            @if (is_null($perdeims->statusManager))
                                            <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                            @elseif($perdeims->statusManager == 1)
                                            <span class="p-2 mb-1 bg-success text-white">Approved</span>
                                            @elseif($perdeims->statusManager == 0)
                                            <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                            @endif

                                            @if (isset($perdeims->allowance))
                                            @if (is_null($perdeims->amount_used))
                                            <span class="text-danger">Not yet retired</span>
                                            @else
                                            <span class="text-success">Retired</span>
                                            @endif
                                            @else
                                            @endif
                                        </td>

                                        <td class="d-flex">
                                            @if (is_null($perdeims->statusManager))
                                            <a href="{{ route('perdeim.managerApprove', $perdeims->id) }}"
                                                title="approve"
                                                class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                data-id="<?php echo $perdeims->id; ?>">Approve</a>
                                            {{-- <a href="{{route('perdeim.managerDecline', $perdeims->id)}}"
                                                title="reject"
                                                class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                                data-id="<?php echo $perdeims->id; ?>"
                                                data-value="Rejected">Reject</a><br> --}}

                                            <button class="view-leave-modal btn btn-warning mr-2" data-toggle="modal"
                                                data-asset="{{ $perdeims->id }}" data-asset-id="{{ $perdeims->id }}"
                                                data-target="#RejectModal" onclick="setperdeimId(this)">
                                                Reject
                                            </button>
                                            @elseif($perdeims->statusManager == 1)

                                            @elseif($perdeims->statusManager == 0)
                                            @endif

                                            @if (isset($perdeims->allowance))
                                            @if (isset($perdeims->amount_used))
                                            <button class="view-details btn btn-primary mr-2" data-toggle="modal"
                                                data-target="#DetailsModel{{ $perdeims->id }}">
                                                View Retirement Details
                                            </button>
                                            @endif
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


        @foreach ($perdeim as $perdeims)
        <div class="modal fade" id="DetailsModel{{ $perdeims->id }}" tabindex="-1" role="dialog"
            aria-labelledby="DetailsModel{{ $perdeims->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="DetailsModalLabel">List of Perdeim Retires</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="loan123" class="display nowrap table table-hover table-striped table-bordered"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>


                                    <th>Amount Used </th>
                                    <th>File Title</th>
                                    <th>Proof</th>
                                    <th>Status</th>
                                    <th>Action</th>

                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($perdeimRetire as $perdeimRetires)
                                <tr>
                                    @if ($perdeimRetires->perdeim_id == $perdeims->id)
                                    <td>{{ $perdeimRetires->amount_used }}</td>
                                    <td>{{ $perdeimRetires->file_title }}</td>
                                    <td><a href="{{ route('retire.download', $perdeimRetires->id) }}"
                                            target="_blank">download</a></td>
                                    <td>
                                        @if (is_null($perdeimRetires->statusManager))
                                        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                        @elseif($perdeimRetires->statusManager == 1)
                                        <span class="p-2 mb-1 bg-success text-white">Approved</span>
                                        @elseif($perdeimRetires->statusManager == 0)
                                        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                        @endif
                                    </td>

                                    <td class="d-flex">
                                        @if (is_null($perdeimRetires->statusManager))
                                        <a href="{{ route('perdeim.managerApproveRetirement', $perdeimRetires->id) }}"
                                            title="approve"
                                            class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                            data-id="<?php echo $perdeimRetires->id; ?>">Approve</a>
                                        {{-- <a href="{{route('perdeim.managerApproveRetirement', $perdeimRetires->id)}}"
                                            title="reject"
                                            class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                            data-id="<?php echo $perdeimRetires->id; ?>"
                                            data-value="Rejected">Reject</a><br> --}}

                                        <button class="view-leave-modal btn btn-warning mr-2" data-toggle="modal"
                                            data-asset="{{ $perdeimRetires->id }}"
                                            data-asset-id="{{ $perdeimRetires->id }}" data-target="#RejectRetirementModal{{ $perdeimRetires->id }}"
                                            onclick="setperdeimRetireId(this)">
                                            Reject
                                        </button>
                                        @elseif($perdeimRetires->statusManager == 1)

                                        @elseif($perdeimRetires->statusManager == 0)
                                        @endif

                                    </td>
                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>



<div>
    <div class="modal fade" id="RejectRetirementModal{{ $perdeimRetires->id }}" tabindex="-1" role="dialog" aria-labelledby="RejectRetirementModal{{ $perdeimRetires->id }}"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RejectRetirementModal{{ $perdeimRetires->id }}">Rejection Reasons</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{ route('perdeim.managerDeclineRetirement') }}" id="loanvalueform"
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

                        <input type="hidden" id="perdeim_id_input" name="perdeim_retire_id" value="">
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



<div>
    <div class="modal fade" id="RejectModal" tabindex="-1" role="dialog" aria-labelledby="RejectModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="RejectModal">Rejection Reasons</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{ route('perdeim.managerDecline') }}" id="loanvalueform"
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

                        <input type="hidden" id="asset_id_input" name="perdeim_id" value="">
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

<script>
    function setperdeimId(button) {
            // Get the asset_id from the clicked button's data-asset-id attribute
            var perdeimId = button.getAttribute('data-asset-id');

            // Set the asset_id in the hidden input field in the modal
            document.getElementById('asset_id_input').value = perdeimId;
        }
</script>

<script>
    function setperdeimRetireId(button) {
            // Get the asset_id from the clicked button's data-asset-id attribute
            var perdeimRetireId = button.getAttribute('data-asset-id');

            // Set the asset_id in the hidden input field in the modal
            document.getElementById('perdeim_id_input').value = perdeimRetireId;
        }
</script>

@endsection