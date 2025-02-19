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
         <h1 class="h2 mb-0 text-gray-800">Edit Earn leave</h1>
         </div>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="card bg-light mb-3" style="max-width: 50rem">
            <div class="align-items-center justify-content-between mb-4">
                <div class="card-body">
                    <form method="post" action="{{ route('leave_earn.update',$leave_earn->id )  }}">
                    @csrf
                                       @method('PUT') 
                        <div class="form-group row">
                            <label for="productName" class="col-sm-2 col-form-label"><b>Employee Name:</b></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="first_name">
                                @foreach ($employee as $employees)
                                   <option value="{{ $employees->id }}"> {{ $employees->first_name }} </option>
                                 @endforeach
                                </select>
                            </div>
                        </div>
                         <div class="form-group row">
                            <label for="productquantity" class="col-sm-2 col-form-label"><b>Start Date:</b></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="start_date" value="{{ $leave_earn->start_date}}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>End Date:</b></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="end_date" value="{{ $leave_earn->end_date}}" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                                <input hide="hidden" type="hidden" class="form-control"  name="total_earndays" value="{{$leave_earn->total_earndays}}" id="message-text1" required minlength="10">                                                
                            </div>
                            

                        <div class="form-group row">
                            <label for="button" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-offset-8 col-sm-8">
                                <button type="submit" class="btn btn-primary">update</button>
                            </div>
                        </div>

                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>

        </div>
    </div>
    @endsection
