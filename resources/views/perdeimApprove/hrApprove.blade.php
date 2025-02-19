@extends('layouts.app')

@section('content')
<div class="page-wrapper">
    <div class="message"></div>
    <div class="row page-titles">
    <div class="header">
      <div class="container-fluid">
            <div class="header-body ml-3">
              <div class="row align-items-end">
                   <div class="col">
                      <h1 class="header-title">
              Director Approve Perdeims
                       </h1>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
            </div>
    </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid ">
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0 "> Perdeim List  </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                         <th>employee name</th>
                                        <th>reason</th>
                                        <th>Amount</th>
                                        <th>Perdeim Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach( $perdeim as $apply)
                                <tr>

                                <td>{{$apply->user->name }}</td>
                                <td>{{$apply->reason }}</td>
                                <td>{{$apply->amount}}</td>
                                                             <td>
                  
 
  @if(is_null($apply->statusHr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($apply->statusHr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved</span>
                  @elseif($apply->statusHr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
            
                 @endif</td>
                 

            @if(is_null($apply->statusHr))
                <a href="{{route('perdeim.hrApprove', $apply->id)}}" title="approve" class=" m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval" data-id="<?php echo $apply->id; ?>">Approve</a>
                <a href="{{route('perdeim.hrDecline', $apply->id)}}" title="reject" class="m-2 btn btn-sm btn-info waves-effect waves-light  Status" data-id = "<?php echo $apply->id; ?>" data-value="Rejected" >Reject</a><br>
            @elseif($apply->statusHr == 1)
            @elseif($apply->statusHr == 0)
            @endif

   
</td>
 @endif
                                    </tr>
                                    @endforeach
                                            </tbody>   
                            </table>
                                               
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection