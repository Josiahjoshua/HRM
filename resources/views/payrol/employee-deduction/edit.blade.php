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
                                    Edit Deduction
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
                            <h4 class="m-b-0">Edit Deduction Details</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('employee-deduction.update', $deduct->id) }}">
                                @csrf
                                @method('PATCH') <!-- Use PATCH method to update the record -->
                                <div class="form-group">
                                    <label for="employee_name">Employee Name</label>
                                    <input type="text" class="form-control" id="employee_name" name="employee_name"
                                           value="{{ $deduct->user->name }}" readonly>
                                </div>
                                <input type="hidden" name="employee_id" value="{{ $deduct->employee_id }}">                                
                                <div class="form-group">
                                    <label for="deduction_name">Deduction Name</label>
                                    <select class="form-control" id="deduction_name" name="deduction_id" required>
                                        <option value="{{ $deduct->deduction->id }}">{{ $deduct->deduction->name }}</option>
                                        @foreach ($deduction as $deductions)
                                            <option value="{{ $deductions->id }}">{{ $deductions->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="effective_date">Effective Date</label>
                                    <input type="date" class="form-control" id="effective_date" name="effective_date" value="{{ $deduct->effective_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">End date</label>
                                    <input type="date" name="end_date" class="form-control" value="{{ $deduct->end_date }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="amount">Amount</label>
                                    <input type="number" step="any" class="form-control" id="amount" name="amount"
                                           value="{{ $deduct->amount }}">
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
