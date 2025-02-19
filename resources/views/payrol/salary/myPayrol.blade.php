@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- ... (Existing HTML code) ... -->

    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Monthly Employee Payroll </h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employeePayroll" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Basic Salary</th>
                                    <th>Benefit</th>
                                    <th>Work Overtime</th>
                                    <th>Deduction</th>
                                    <th>Net Salary</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payrollData as $data)
                                <tr>
                                    <td>{{ $data->month }}</td>
                                    <td>{{ number_format($data->salary) }}</td>
                                    <td>{{ number_format($data->benefits )}}</td>
                                    <td>{{ number_format($data->workovertimes )}}</td>
                                    <td>{{ number_format($data->deductions) }}</td>
                                    <td>{{ number_format($data->salary + $data->benefits + $data->workovertimes - $data->deductions) }}</td>
                                    <td>
                                        <a href="{{ route('generate_payslip', $data->month)}}" title="compute" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $data->id; ?>" >Generate Payslip</a>
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

    <!-- ... (Remaining HTML code) ... -->
</div>

<script>
    $(document).ready(function() {
        $('#employeePayroll').DataTable({
            lengthChange: false,
            buttons: ['copy', 'excel', 'pdf', 'colvis']
        });
    });
</script>

@endsection
