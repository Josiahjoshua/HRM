@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Add your edit form code here -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1>Edit Perdeim</h1>
                <form method="POST" action="{{ route('perdeim.update', $perdeim->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input type="date" class="form-control" name="date" value="{{ $perdeim->date }}" required />
                    </div>
                    <div class="form-group">
                        <label for="reason">Description:</label>
                        <input type="text" name="reason" class="form-control" value="{{ $perdeim->reason }}">
                    </div>

                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="text" name="amount" class="form-control" value="{{ $perdeim->amount }}">
                    </div>


                    <!-- Add other form fields here -->

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
