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
               Perdeims
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
        <div class="row m-b-10">
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Perdeim</a></button>
            
            </div>
        </div>
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
                                <tfoot>
                                <tr>
                                        
                                        <th>employee name</th>
                                        <th>reason</th>
                                        <th>Amount</th>
                                        <th>Perdeim Status</th>
                                        <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach( $perdeim as $perdeims)
                                <tr>
                                
                                <td>{{$perdeims->user->name }}</td>
                                <td>{{$perdeims->reason }}</td>
                                <td>{{$perdeims->amount}}</td>
                                <td>
                                            @if(is_null($perdeims->status))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($perdeims->status == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved</span>
                  @elseif($perdeims->status == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>
                 @endif</td>
                 <td class="row">
                
                                        @if(is_null($perdeims->status))
                                            <a href="{{route('perdeim.approve', $perdeims->id)}}" title="approve" hidden="hidden" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapproval" data-id="<?php echo $perdeims->id; ?>">Approve</a>
                                            <a href="{{route('perdeim.decline', $perdeims->id)}}" title="reject" hidden="hidden" class="m-2 btn btn-sm btn-info waves-effect waves-light  Status" data-id = "<?php echo $perdeims->id; ?>" data-value="Rejected" >Reject</a><br>
                                            <a href="{{ route('perdeim.edit', $perdeims->id)}}" title="Edit" hidden="hidden" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $perdeims->id; ?>" >Edit</a>
                                            @elseif($perdeims->status == 1)
                                            <a href="{{ route('perdeim-employee.show', $perdeims->id)}}" title="retire"  class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $perdeims->id; ?>" >Retirement</a>
                                            @elseif($perdeims->status == 0)
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
        <div class="modal fade" id="leavemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Benefit</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" ction="{{route('perdeim-employee.store')}}" id="leaveform" enctype="multipart/form-data">
                        <div class="modal-body">
                          <div class="form-group">
                                <label>Employee</label>
                                <input type="text" name="employee_id" class="form-control" value="{{$employee->name}}" id="recipient-name1" readonly>
                            </div>
                              
                            <div class="form-group">
                                <label class="control-label">Reason</label>
                                <textarea  name="reason" class="form-control" id="recipient-name1" minlength="1" maxlength="35" value=""></textarea>
                            </div>
                                        
                            <div class="form-group">
                                <label class="control-label">Amount</label>
                                <input type="number" name="amount"  class="form-control" id="recipient-name1" value="">
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label">status</label>
                                <select class="form-control custom-select" data-placeholder="Choose a Category" tabindex="1" name="status" required>
                                    <option value="">Select Here</option>
                                    <option value="1">Active</option>
                                    <option value="0">InActive</option>
                                </select>
                            </div> -->
                            
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="" class="form-control" id="recipient-name1">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?=csrf_field()?> 
                    </form>
                </div>
            </div>
        </div>
    </div>
        <script>
        $(document).ready(function() {
    $('.js-example-basic-single ').select2({
              dropdownParent: $("#leavemodel")
      });
});
    </script>
     <script>
    $(document).ready(function() {
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
    @endsection