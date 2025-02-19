@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h4 class="modal-title">Edit Casual Worker</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Edit Casual Worker</li>
          </ol>
        </div>
      </div>
    </div> 
     <div class="tab-pane " id="bank" role="tabpanel" style="width:50%">
      <div class="card">
       <div class="card-body">
        <form role="form" method="post" action="{{route('casual.update', $casual->id)}}" id="loanvalueform" enctype="multipart/form-data">
        @csrf
        @method('PUT')

          <div class="modal-body">
              <div class="form-group">
              <label class="control-label">Worker Name</label>
              <input type="text" name="worker_name" class="form-control" value="{{ $casual->worker_name }}"  required> 
          </div>
        <div class="form-group">
              <label class="control-label">Amount</label>
              <input type="number" name="amount" class="form-control" value="{{ $casual->amount }}"  required> 
          </div> 
           <div class="form-group">
              <label class="control-label">Phone Number</label>
              <input type="number" name="phone" class="form-control" value="{{ $casual->phone }}"  required> 
          </div> 
            <div class="form-group">
              <label class="control-label">location</label>
              <input type="text" name="location" class="form-control" value="{{ $casual->location }}"  required> 
          </div>
          <div class="form-group">
              <label class="control-label">Start date</label>
              <input type="date" name="start_date" class="form-control" value="{{ $casual->start_date }}"  required> 
          </div> 
            <div class="form-group">
              <label class="control-label">End Date</label>
              <input type="date" name="end_date" class="form-control" value="{{ $casual->end_date }}"  required> 
          </div>
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Changes</button>
          </div>
          <?= csrf_field() ?>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection