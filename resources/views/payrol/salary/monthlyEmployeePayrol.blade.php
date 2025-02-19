@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- ... (Existing HTML code) ... -->

    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Monthly Employee Payroll - {{ $month }}</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="employeePayroll" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Salary</th>
                                    <th>Benefit</th>
                                    <th>Work Overtime</th>
                                    <th>Deduction</th>
                                    <th>Net Salary</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payrollData as $data)
                                <tr>
                                    <td>{{ $data->employee_name }}</td>
                                    <td>{{ number_format($data->salary) }}</td>
                                    <td>{{ number_format($data->benefits )}}</td>
                                    <td>{{ number_format($data->workovertime )}}</td>
                                    <td>{{ number_format($data->deductions) }}</td>
                                    <td>{{ number_format($data->salary + $data->benefits + $data->workovertime - $data->deductions) }}</td>
                                    
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
