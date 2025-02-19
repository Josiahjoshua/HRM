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
                                    Deductions
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
                <div class="col-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Assign Deduction</a></button>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Deductions assigned List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <th>Employee Name</th>
                                            <th>Deduction Name</th>
                                            <th>Effective date</th>
                                            <th>End date</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($deduction_employee as $deduct)
                                            <tr>

                                                <td>{{ $deduct->user->name }}</td>
                                                <td>{{ $deduct->deduction->name }}</td>
                                                <td>{{ $deduct->effective_date }}</td>
                                                <td>{{$deduct->end_date}}</td>
                                                <td>{{ $deduct->amount }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('employee-deduction.edit', $deduct->id) }}"
                                                        class="btn btn-primary">Edit</a>

                                                    <form action="{{ route('employee-deduction.destroy', $deduct->id) }}"
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
                            <h4 class="modal-title" id="exampleModalLabel1">Assign deduction</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" action="{{ route('employee-deduction.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group ">
                                    <label class="control-label">Assign To</label>

                                    <select class="js-example-basic-single" data-placeholder="Choose a Category"
                                        tabindex="1" name="employee_id" id="assignval" style="width: 100%" required>
                                        <option value="">Select here</option>
                                        @foreach ($employee as $employees)
                                            <option value="{{ $employees->id }}">{{ $employees->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group ">
                                    <label class="control-label">deduction assigned</label>

                                    <select class="form-select" aria-label="Default select example"
                                        data-placeholder="Choose a Category" tabindex="1" name="deduction_id"
                                        id="assignval" style="width: 100%" required>
                                        <option value="">Select here</option>
                                        @foreach ($deduction as $deductions)
                                            <option value="{{ $deductions->id }}">{{ $deductions->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">effective date</label>
                                    <input type="date" name="effective_date" class="form-control" id="recipient-name1"
                                          required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">End date</label>
                                    <input type="date" name="end_date" class="form-control" id="recipient-name1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">amount</label>
                                    <input type="number" name="amount" step="any" class="form-control"
                                        id="recipient-name1" value="">
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
