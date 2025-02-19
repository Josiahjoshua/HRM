 
@extends('layouts.app')
@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="content-wrapper">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div><br />
        @endif

        <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
         <h1 class="h2 mb-0 text-gray-800">Edit Holiday</h1>
         </div>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="card bg-light mb-3" style="max-width: 50rem">
            <div class="align-items-center justify-content-between mb-4">
                <div class="card-body">
                    <form method="post" action="{{ route('holiday.update',$holiday->id )  }}">
                                            @csrf
                                       @method('PATCH')  
                        

                        
                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>holiday name:</b></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" value="{{$holiday->name}}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>Date:</b></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="date" value="{{$holiday->date}}" />
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
    </div>
    @endsection
