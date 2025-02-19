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
                                    Director Approve Perdeims
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
                            <div class="table ">
                                <table id="example1" class="nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>Employee name</th>
                                            <th>Description</th>
                                            <th>Amount</th>
                                            <th>Allowance</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tfoot>

                                        <tbody>
                                            @foreach ($perdeim as $apply)
                                                <tr>

                                                    <td>
                                                        @if ($apply->user)
                                                            {{ $apply->user->name }}
                                                        @else
                                                            <span class="text-danger">Data unavailable</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $apply->reason }}</td>
                                                    <td>{{ $apply->amount }}</td>
                                                    <td>{{ $apply->allowance }}</td>



                                                    <td>


                                                        @if (is_null($apply->statusDr))
                                                            <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                                        @elseif($apply->statusDr == 1)
                                                            <span class="p-2 mb-1 bg-success text-white">Approved</span>
                                                        @elseif($apply->statusDr == 0)
                                                            <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                                        @endif

                                                        @if (isset($apply->allowance))
                                            @if (is_null($apply->amount_used))
                                            <span class="text-danger">Not yet retired</span>
                                            @else
                                            <span class="text-success">Retired</span>
                                            @endif
                                            @else
                                            @endif

                                                    </td>


                                                    @if ($apply->role == 'manager')
                                                        <td>
                                                            @if (is_null($apply->statusDr))
                                                                <a href="{{ route('perdeim.drApprove', $apply->id) }}"
                                                                    title="approve"
                                                                    class=" m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                                    data-id="<?php echo $apply->id; ?>">Approve</a>
                                                                <a href="{{ route('perdeim.drDecline', $apply->id) }}"
                                                                    title="reject"
                                                                    class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                                                    data-id="<?php echo $apply->id; ?>"
                                                                    data-value="Rejected">Reject</a><br>
                                                            @elseif($apply->statusDr == 1)

                                                            @elseif($apply->statusDr == 0)
                                                            @endif
                                                        </td>
                                                    @elseif($apply->role !== 'manager')
                                                        <td>
                                                            @if (is_null($apply->statusManager))
                                                                <span class="p-2 mb-1 bg-info text-white">Waiting For
                                                                     Manager's Approval</span>
                                                            @elseif($apply->statusManager == 1)
                                                                <span class="p-2 mb-1 bg-success text-white">Approved by
                                                                    {{ $apply->managerApprover }}</span>
                                                                @if (is_null($apply->statusDr))
                                                                    <a href="{{ route('perdeim.drApprove', $apply->id) }}"
                                                                        title="approve"
                                                                        class=" m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval"
                                                                        data-id="<?php echo $apply->id; ?>">Approve</a>
                                                                    {{-- <a href="{{ route('perdeim.drDecline', $apply->id) }}"
                                                                        title="reject"
                                                                        class="m-2 btn btn-sm btn-info waves-effect waves-light  Status"
                                                                        data-id="<?php echo $apply->id; ?>"
                                                                        data-value="Rejected">Reject</a><br> --}}

                                                                        <button class="view-leave-modal btn btn-warning mr-2"
                                                                        data-toggle="modal" data-asset="{{ $apply->id }}"
                                                                        data-asset-id="{{ $apply->id }}"
                                                                        data-target="#RejectModal{{ $apply->id }}"
                                                                        onclick="setperdeimId(this)">
                                                                        Reject
                                                                    </button>
                                                                @elseif($apply->statusDr == 1)

                                                                @elseif($apply->statusDr == 0)
                                                                @endif
                                                            @elseif($apply->statusManager == 0)
                                                                <span class="p-2 mb-1 bg-danger text-white">Rejected by
                                                                    {{ $apply->managerApprover }}</span>

                                                            @endif

                                                            @if (isset($apply->allowance))
                                                            @if (isset($apply->amount_used))
                                                            <button class="view-details btn btn-primary mr-2" data-toggle="modal"
                                                                data-target="#DetailsModel{{ $apply->id }}">
                                                                View Allowance Details
                                                            </button>
                                                            @endif
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
            <div class="modal fade" id="RejectModal{{ $apply->id }}" tabindex="-1" role="dialog"
                aria-labelledby="RejectModal{{ $apply->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="RejectModal{{ $apply->id }}">Rejection Reasons
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="POST" action="{{ route('perdeim.drDecline') }}"
                                id="loanvalueform" enctype="multipart/form-data">
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
                                        <textarea type="text" name="rejection_reason" id="example-email2" class="form-control" placeholder="" required></textarea>
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


        @foreach ($perdeim as $perdeims)
        <div>
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
                                    <th>Approval</th>
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
                                        @if (is_null($perdeimRetires->statusDr))
                                        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                        @elseif($perdeimRetires->statusDr == 1)
                                        <span class="p-2 mb-1 bg-success text-white">Approved</span>
                                        @elseif($perdeimRetires->statusDr == 0)
                                        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                                        @endif
                                    </td>

                                    <td class="d-flex">
                                        @if(is_Null($perdeimRetires->statusManager))
                                        <span class="p-2 mb-1 bg-info text-white">Waiting manager's Approval</span>
                                        @elseif ($perdeimRetires->statusManager == 1)
                                        @if (is_Null($perdeimRetires->statusDr))
                                        <a href="{{ route('perdeim.drApproveRetirement', $perdeimRetires->id) }}"
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
                                        @else
                                        @endif
                                        @else
                                        <span class="p-2 mb-1 bg-danger text-white">Rejected by the manager</span>
                                       

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
    </div>
        @endforeach

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
                            <form role="form" method="POST" action="{{ route('perdeim.drDeclineRetirement') }}" id="loanvalueform"
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

        <script>
            $(function() {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    // "buttons": ["copy", "csv", "excel"],
                    "scrollX": true // Add this line to enable horizontal scrolling
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
