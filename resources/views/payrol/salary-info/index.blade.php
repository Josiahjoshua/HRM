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
                                    Basic Salary
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
                                aria-hidden="true"></i> Add Basic Salary</a></button>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> salary List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <th>Employee Name</th>
                                            <th>Payment Start Date</th>
                                            <th>Payment End Date</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($salary as $employee_salary)
                                            <tr>

                                                <td>{{ $employee_salary->user->name }}</td>
                                                <td>{{ $employee_salary->start_date }}</td>
                                                <td>{{ $employee_salary->end_date }}</td>
                                                <td>{{ number_format($employee_salary->basic_salary) }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('salary.edit', $employee_salary->id) }}"
                                                        class="btn btn-primary mr-3">Edit</a>
                                                    <form action="{{ route('salary.destroy', $employee_salary->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit"
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
                            <h4 class="modal-title" id="exampleModalLabel1">basic salary</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('salary.store') }}" id="leaveform"
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

                                <div class="form-group">
                                    <label class="control-label">Basic Salary</label>
                                    <input type="number" name="salary" class="form-control" id="recipient-name1"
                                        minlength="1" maxlength="35" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Payment Start Date</label>
                                    <input type="date" name="start_date" class="form-control" id="recipient-name1"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Payment End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="recipient-name1"
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
                    scrollX: true,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endsection
