@extends('layouts.app')

@section('content')
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
        
         <div class="col-sm-6">
         <h1 class="h2 mb-0 text-gray-800 mr-5">Edit leave application</h1></div>
                             <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('leave.index') }}">Leave</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                  function goBack() {
                                    window.history.back();
                                  }
                                </script></li>
                        </ol>
                    </div>
         </div>
        <hr class="sidebar-divider d-none d-md-block">
        <div class="card bg-light mb-3" style="max-width: 50rem">
            <div class="align-items-center justify-content-between mb-4">
                <div class="card-body">
                    <form method="post" action="{{ route('leave_apply.update',$leave_apply->id )  }}" enctype="multipart/form-data">
                    @csrf
                                       @method('PUT') 
                        <!--<div class="form-group row">-->
                        <!--    <label for="productName" class="col-sm-2 col-form-label"><b>Employee Name:</b></label>-->
                        <!--    <div class="col-sm-6">-->
                        <!--        <select class="form-control" name="first_name">-->
                        <!--        @foreach ($employee as $employees)-->
                        <!--           <option value="{{ $employees->id }}"> {{ $employees->first_name }} </option>-->
                        <!--         @endforeach-->
                        <!--        </select>-->
                        <!--    </div>-->
                        <!--</div>-->
                        <div class="form-group row">
                            <label for="productName" class="col-sm-2 col-form-label"><b>Leave type:</b></label>
                            <div class="col-sm-6">
                                <select class="form-control" name="leave_type_id">
                                @foreach ($leave_type as $leave)
                                        <option value="{{ $leave->id }}" @if($leave->id == $leave_apply->leave_id) selected @endif> {{ $leave->leavename }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        @if($leave_apply->leave_id == 4)
                        @if(is_Null($leave_apply->proof))
                        <span class="text-danger">No proof was uploaded</span>


                                   @else
                                        <a href="{{ route('proof.download', $leave_apply->id) }}" target="_blank">View Proof</a>


                                    @endif
                                     <div class="form-group">
                                        <label for="proof">Proof of Sickness:</label>
                                       <input type="file" class="form-control" id="proof" name="proof" accept=".pdf,.jpeg,.jpg,.png">
                                    </div>
                                    @endif

                        <div class="form-group row mt-3">
                            <label for="productquantity" class="col-sm-2 col-form-label"><b>Start Date:</b></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="startdate" value="{{ $leave_apply->start_date}}" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="productprice" class="col-sm-2 col-form-label"><b>End Date:</b></label>
                            <div class="col-sm-4">
                                <input type="date" class="form-control" name="enddate" value="{{ $leave_apply->end_date}}" />
                            </div>
                        </div>
                      <div class="form-group row">
    <label for="productprice" class="col-sm-2 col-form-label"><b>Description:</b></label>
    <div class="col-sm-4">
        <textarea class="form-control" name="reason">{{ $leave_apply->reason }}</textarea>
    </div>
</div>

                        <div class="form-group">
                                <input hide="hidden" type="hidden" class="form-control"  name="total_day" value="{{$leave_apply->total_day}}" id="message-text1" required minlength="10">                                                
                            </div>
                            <div class="form-group">
                                <input hide="hidden" type="hidden" class="form-control"  name="day_remain" value="{{$leave_apply->day_remain}}" id="message-text1" required minlength="10">                                                
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
