@extends('layouts.app')

@section('content')
<div class="content-wrapper">
        <div class="message"></div>
        <div class="row page-titles">
            <div class="container-fluid">
                <div class="header-body ml-3">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Assets
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assetsmodel"
                        data-whatever="@getbootstrap"><i class="fe fe-plus"></i>
                        <a class="text-white"><i class="" aria-hidden="true"></i> Assign Assets </a>
                    </button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0"> Assets Employee List</h4>

                        </div>

                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Employee Name</th>
                                            <th>Asset Name</th>
                                            <th>Asset Serial No</th>
                                            <th>Status</th>
                                            <th>Assigned In</th>
                                            <th>Returned In</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($asset_list->asset_employees as $asset_employees)
                                            <tr>
                                                <td>{{ @$asset_employees->user->name }}</td>
                                                <td>{{ @$asset_employees->assetlist->asset_name }}</td>
                                                <td>{{ @$asset_employees->serial_number }}</td>
                                                <td>{{ ucwords($asset_employees->status) }}</td>
                                                <td>{{ date('Y-m-d', strtotime($asset_employees->created_at)) }}</td>
                                                <td>@if ($asset_employees->return_date != null)
                                                    {{ date('Y-m-d', strtotime($asset_employees->return_date)) }}
                                                    @else
                                                    -
                                                @endif

                                             </td>
                                                <td>
                                                    @if ($asset_employees->status == 'assigned')
                                                    <a href="{{ route('assetlist.employee.returned', ['assetlist' => $asset_list->id, 'employee' => $asset_employees->id]) }}"
                                                        class="btn btn-info">Return Asset</a>
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
            <div class="modal fade" id="assetsmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Add Asset </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post"
                            action="{{ route('assetlist.employeeAsset.store', ['assetlist' => $asset_list->id]) }}"
                            id="btnSubmit" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Employee Name </label>
                                            <select name="employee_id" class="select2 form-control" style="width: 100%"
                                                required value="">
                                                <option value="">Select Employee Name</option>
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"> {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Assets Serial No.</label>
                                            <input type="text" name="serial_number" class="form-control"
                                                id="serial_number" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="control-label">Status</label>
                                            <select name="status" class="select2 form-control" style="width: 100%" required
                                                value="">
                                                <option value="">Select Status</option>
                                                <option value="assigned">Assigned</option>
                                                <option value="returned">Returned</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @push('scripts')
                <script>
                    $(document).ready(function() {
                        $('.select2').select2({
                            dropdownParent: $("#assetsmodel")
                        });
                        var table = $('#example').DataTable({
                            lengthChange: false,
                            ordering: false,
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#example_wrapper .col-md-6:eq(0)');
                    });
                </script>
            @endpush
        @endsection
