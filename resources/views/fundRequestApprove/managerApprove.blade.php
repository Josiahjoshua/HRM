@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="row page-titles">
    <div class="header">
      <div class="container-fluid">
            <div class="header-body ml-3">
              <div class="row align-items-end">
                   <div class="col">
                      <h1 class="header-title">
           Manager  Approve  Fund Request
                       </h1>
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
                        <h4 class="m-b-0 "> Fund Request List  </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>

                                         <th>Employee Name</th>
                                        <th>Reason</th>
                                        <th>Amount</th>
                                        <th>Request Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach( $fundrequest as $perdeims)
                                <tr>

                                <td>{{$perdeims->user->name }}</td>
                                <td>{{$perdeims->reason }}</td>
                                <td>{{$perdeims->amount}}</td>
                                <td>
                                            @if(is_null($perdeims->statusManager))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($perdeims->statusManager == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved</span>
                  @elseif($perdeims->statusManager == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                 @endif</td>
                                     
                                        <td class="d-flex">
                                        @if(is_null($perdeims->statusManager))
                                            <a href="{{route('fundrequest.managerApprove', $perdeims->id)}}" title="approve" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval" data-id="<?php echo $perdeims->id; ?>">Approve</a>
                                            <a href="{{route('fundrequest.managerDecline', $perdeims->id)}}" title="reject" class="m-2 btn btn-sm btn-info waves-effect waves-light  Status" data-id = "<?php echo $perdeims->id; ?>" data-value="Rejected" >Reject</a><br>
                                            @elseif($perdeims->statusManager == 1)
                                            @elseif($perdeims->statusManager == 0)
                                        @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                            </tbody>   
                            </table>
                                               
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    @endsection