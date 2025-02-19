 
@extends('layouts.app')
@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>

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

        <!-- <div class="d-sm-flex align-items-center justify-content-between mb-4"> 
         <h1 class="h3 mb-0 text-gray-800">Add student</h1>
         </div> -->
        <hr class="sidebar-divider d-none d-md-block">
        <div class="card bg-light mb-3" style="max-width: 50rem">
            <div class="align-items-center justify-content-between mb-4">
                <div class="card-body">
                    <form method="post" action="{{ route('leave_type.update',$leave_type->id )  }}">
                                            @csrf
                                       @method('PATCH')  
                        

                        
                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>Leave type:</b></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="leavename" value="{{$leave_type->leavename}}" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>Number of days:</b></label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" name="day_no" value="{{$leave_type->day_no}}" />
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
