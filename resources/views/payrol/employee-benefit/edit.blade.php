@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- ... (Existing HTML code) ... -->

    <!-- Edit Form -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Edit Benefit</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('employee-benefit.update', $benefit->id) }}">
                        @csrf
                        @method('PATCH')
                        <!-- Edit form fields go here -->
                        <div class="form-group">
                            <label class="control-label">Assign To</label>
                            <select class="js-example-basic-single" data-placeholder="Choose an Employee" tabindex="1" name="employee_id" style="width: 100%" required>
                                <option value="{{ $benefit->user->id }}">{{ $benefit->user->name }}</option>
                                @foreach($employee as $employees)
                                    <option value="{{ $employees->id }}">{{ $employees->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Benefit Assigned</label>
                            <select class="form-select" aria-label="Choose a Benefit" tabindex="1" name="benefit_id" style="width: 100%" required>
                                <option value="{{ $benefit->benefit->id }}">{{ $benefit->benefit->name }}</option>
                                @foreach($benefits as $benefite)
                                    <option value="{{ $benefite->id }}">{{ $benefite->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Effective Date</label>
                            <input type="date" name="effective_date" class="form-control" value="{{ $benefit->effective_date }}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">End date</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $benefit->end_date }}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount</label>
                            <input type="number" name="amount" step="any" class="form-control" value="{{ $benefit->amount }}">
                        </div>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ... (Remaining HTML code) ... -->
</div>

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $("#editBenefit")
        });
    });
</script>
@endsection
