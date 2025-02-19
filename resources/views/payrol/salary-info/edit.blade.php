@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Your existing HTML structure here -->

    <div class="container-fluid">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 ">Edit Salary</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('salary.update', $employee_salary->id) }}">
                            @csrf
                            @method('PATCH') <!-- Use PATCH method to update the record -->
                            <div class="form-group">
                                <label for="employee_name">Employee Name</label>
                                <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $employee_salary->user->name }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="basic_salary">Basic Salary</label>
                                <input type="number" class="form-control" id="basic_salary" name="basic_salary" value="{{ $employee_salary->basic_salary }}" required>
                            </div>
                            <div class="form-group">
                                <label for="start_date">Payment Start Date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $employee_salary->start_date }}" required>
                            </div>
                            <div class="form-group">
                                <label for="end_date">Payment End Date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $employee_salary->end_date }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
