@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- ... (Existing HTML code) ... -->

    <!-- Edit Form -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card card-outline-info">
                <div class="card-header">
                    <h4 class="m-b-0">Edit Work Overtime</h4>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('work-overtime.update', $work->id) }}">
                        @csrf
                        @method('PATCH')
                        <!-- Edit form fields go here -->
                        <div class="form-group">
                            <label class="control-label">Employee Name</label>
                            <input type="text" name="employee_id" class="form-control" value="{{ $work->user->name }}" readonly>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ $work->date }}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Total Hours</label>
                            <input type="number" step="any" name="total_hours" class="form-control" value="{{ $work->total_hours }}" required>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Amount Per Hour</label>
                            <input type="number" step="any" name="amount_per_hour" class="form-control" value="{{ $work->amount_per_hour }}" required>
                        </div>
                        <div class="form-group">
                            <label for="proof" class="control-label">Proof</label>
                            <input type="file" name="file_url" class="form-control" id="proof">
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
        // Initialize any JavaScript functionality here if needed
    });
</script>
@endsection
