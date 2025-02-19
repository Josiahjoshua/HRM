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
        <div class="container-fluid">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0">Edit Deduction Details</h4>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('deduction.update', $deduct->id) }}">
                                @csrf
                                @method('PATCH') <!-- Use PATCH method to update the record -->
                                <div class="form-group">
                                    <label for="name">Deduction Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           value="{{ $deduct->name }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" id="description" name="description"
                                           value="{{ $deduct->description }}" required>
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
