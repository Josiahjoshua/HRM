@extends('layouts.app')

@section('content')
<div class="content-wrapper">  
<div class="card-body">
   <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Update User Information</h1>
    </div>
    <hr class="sidebar-divider d-none d-md-block">
    <div class="card bg-light mb-3" style="max-width: 50rem">
        <div class="align-items-center justify-content-between mb-4">
            <div class="card-body">
                <form method="post" action="{{ route('users.update', $user->id) }}">
                    <div class="form-group row">
                        @csrf
                        @method('PATCH')
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="name"
                                value="{{ $user->name }}" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" name="email"
                                value="{{ $user->email }}" />
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Password</label>
                        <div class="col-sm-8">
                            <input type="password"  class="form-control" name="password"
                                value="{{ $user->password }}" id="password" />
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="button" class="col-sm-2 col-form-label"></label>
                        <div class="col-sm-offset-8 col-sm-8">
                            <button type="submit" class="btn btn-primary">Update Data</button>
                        </div>
                    </div>

                    <?= csrf_field() ?>
                </form>
            </div>
        </div>
    </div>
@endsection



