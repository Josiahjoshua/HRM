@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Edit Machine Timesheet
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Machine Timesheet</li>
                            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                  function goBack() {
                                    window.history.back();
                                  }
                                </script></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
        <div class="card">
            <div class="card-body">
<form role="form" method="post" action="{{ route('machineTimesheet.update', $timesheet->id) }}" id="loanvalueform"
    enctype="multipart/form-data">
    @csrf
    @method('PUT') 

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-group">
        <label class="control-label">Requested By</label>
        <select class="form-control select2 custom-select" name="employee_id" data-placeholder="Select Employee"
            tabindex="1" required>
            @foreach ($employee as $users)
                <option value="{{ $users->id }}" {{ $timesheet->employee_id == $users->id ? 'selected' : '' }}>
                    {{ $users->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label class="control-label">Machine Name</label>
        <select class="form-control select2 custom-select" name="machine_id" data-placeholder="Select Customer"
            tabindex="1" required>
            @foreach ($machine as $machines)
                <option value="{{ $machines->id }}" {{ $timesheet->machine_id == $machines->id ? 'selected' : '' }}>
                    {{ $machines->machine_name }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group">
        <label for="message-text" class="control-label">Date</label>
        <input type="date" name="date" class="form-control" id="recipient-name1" required value="{{ $timesheet->date }}">
    </div>

    <div class="form-group">
        <label class="control-label">Activities</label>
        <textarea class="form-control" name="activities" id="message-text1" required minlength="14"
            rows="4">{{ $timesheet->activities }}</textarea>
    </div>

    <div class="form-group">
        <label class "control-label">Starting hours</label>
        <input type="number" step="any" name="start_hour" value="{{ $timesheet->start_hour }}" class="form-control"
            id="recipient-name1">
    </div>

    <div class="form-group">
        <label class "control-label">Ending hours</label>
        <input type="number" step="any" name="end_hour" value="{{ $timesheet->end_hour }}" class="form-control"
            id="recipient-name1">
    </div>

    <div class="form-group">
        <label class "control-label">Fuel</label>
        <input type="number" step="any" name="fuel" value="{{ $timesheet->fuel }}" class="form-control"
            id="recipient-name1">
    </div>

</div>
<div class="modal-footer justify-content-between">
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>

        </div>
    </div>
     </div>
                </div>
            </div>
        </section>
    </div>
@endsection
