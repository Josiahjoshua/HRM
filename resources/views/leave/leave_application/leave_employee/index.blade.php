@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <div class="message"></div>
    <div class="header">
      <div class="container-fluid">
            <div class="header-body ml-1">
              <div class="row align-items-end">
                   <div class="col">
                      <h1 class="header-title">
                Leave application
                       </h1>
                    </div>
                </div> 
            </div> 
        </div>
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid mt-4">
        <div class="row m-b-10">
           
            <div class="col-12">
                <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal" data-target="#appmodel" data-whatever="@getbootstrap" class="text-white"><i class="" aria-hidden="true"></i> Add Application </a></button>
            </div>
          
        </div>
        <div class="row mt-4">
            <div class="col-12">
                <div class="card card-outline-info">
                    <div class="card-header">
                        <h4 class="m-b-0"> Application List
                        </h4>
                    </div>
                   
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Employee Name</th>
                                        <th>Leave Type</th>
                                        <th>start Date</th>
                                        <th>End Date</th>
                                        <th>Leave Duration</th>
                                        <th>Day Remain</th>
                                        <th>Leave Status</th>
                                        <th>Action</th> 
                                    </tr>
                                </thead>
                             
                                <tbody>
                                    
                                @foreach($leave_apply as $apply)
                                       <tr style="vertical-align:top">
                                       <td><mark>{{$apply->user->name}}</mark></td>
                                        <td>
                                         @if($apply->leave_type->leavename == 'Sick leave')
                                          <span>Sick Leave</span><br>
                                          @if($apply->proof) 
                                          <a href="{{ route('proof.download', $apply->id) }}" target="_blank">view proof</a>
                                                     @else
                                                   <span  class="text-danger">No proof uploaded</span>  
                                                      @endif
                                                      
                                          @else
                                        {{ $apply->leave_type->leavename }}
                                           @endif
                                          
                                        </td>
                                        <td>{{$apply->start_date}}</td>
                                        <td>{{$apply->end_date}}</td>
                                        <td>{{$apply->total_day}} days</td>
                                        <td>{{$apply->day_remain}} days</td>
                                        
                                        
                             
         @if($apply->role == 'manager')
          <td>

                   @if(is_null($apply->statusHr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($apply->statusHr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$apply->directorApprover}}</span>
              @elseif($apply->statusHr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$apply->directorApprover}}</span>
        
                 
          @endif
          </td>
         
         
         @elseif($apply->role !== 'manager')
         <td>
        @if(is_null($apply->statusManager))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($apply->statusManager == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$apply->managerApprover}}</span>
                   @elseif($apply->statusManager == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$apply->managerApprover}}</span>
         @endif
                     @if(is_null($apply->statusHod))
                    @elseif($apply->statusHod == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$apply->hodApprover}}</span>
           @elseif($apply->statusHod == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$apply->hodApprover}}</span>
        
         @endif
                   @if(is_null($apply->statusHr))
                    @elseif($apply->statusHr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$apply->directorApprover}}</span>
              @elseif($apply->statusHr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$apply->directorApprover}}</span>
        
                 @endif</td>
                            
                     @endif   
                     
                  <td class="d-flex">
                                         @if (is_Null($apply->statusHr) || is_Null($apply->statusManager))

                                            <a href="{{ route('leave.edit', $apply->id)}}" title="Edit" class="mr-3 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $apply->id; ?>" >Edit</a>
                                             <form action="{{ route('leave.destroy', $apply->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                        <?= csrf_field() ?>
                                                    </form>
                                                    
                                              @elseif($apply->statusManager == 0 || $apply->statusHr == 0)
                                               <span class="text-danger">Reason: {{ $apply->rejection_reason }}</span>
                                               
                                         
                                         @else
   
                                            
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
        <div class="modal fade" id="appmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Leave Application</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="{{route('leave.store')}}" id="leaveapply" enctype="multipart/form-data">
                        <div class="modal-body">
                            
                            <div class="form-group">
                                <label>Employee</label>
                                <input type="text" name="employee_id" class="form-control" value={{$employee->name}} id="recipient-name1" readonly>
                            </div>
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control js-example-basic-single" class="form-control" tabindex="1" name="leave_type_id" id="leavetype"style="width:100%" required>
                                    <option value="">Select Here..</option>
                                            @foreach ($leave_type as $leave)
                                                <option value="{{ $leave->id }}"> {{ $leave->leavename }} </option>
                                            @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group" id="proofUpload" style="display: none;">
    <label for="proof">Proof of Sickness</label>
    <input type="file" class="form-control" name="proof" id="proof">
</div>
                            
                            
                            <div class="form-group">
                                <label class="control-label" id="hourlyFix">Start Date</label>
                                <input type="date" name="startdate" class="form-control" id="recipient-name1" required>
                            </div>
                            <div class="form-group" id="enddate">
                                <label class="control-label">End Date</label>
                                <input type="date" name="enddate" class="form-control" id="recipient-name1">
                            </div>
                            <div class="form-group">
                                <label class="control-label">Reason</label>
                                <textarea class="form-control" name="reason" id="message-text1" required minlength="10"></textarea>                                                
                            </div>
                            <div class="form-group">
                                <input hide="hidden" type="hidden" class="form-control"  name="total_day" id="message-text1" required minlength="10">                                                
                            </div>
                            <div class="form-group">
                                <input hide="hidden" type="hidden" class="form-control"  name="day_remain" id="message-text1" required minlength="10">                                                
                            </div>
                            
                      
<!--<div class="form-group">-->
<!--    <label class="control-label">Select Approvers</label>-->
<!--    <div class="custom-multiselect">-->
<!--        <input type="text" id="searchInput" placeholder="Search for Approvers" oninput="filterOptions()">-->
<!--        <ul id="optionsList">-->
<!--            @foreach($users as $collaborators)-->
<!--                <li>-->
<!--                    <input type="checkbox" name="assignto[]" value="{{ $collaborators->id }}">-->
<!--                    {{ $collaborators->name }}-->
<!--                </li>-->
<!--            @endforeach-->
<!--        </ul>-->
<!--    </div>-->
<!--</div>-->


</div>

                        
                        <div class="modal-footer">
                            <input type="hidden" name="id" class="form-control" id="recipient-name1" required>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?=csrf_field()?>
                    </form>
                </div>
            </div>
        </div>

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
    

<script>
$(document).ready(function() {
    $(".chosen-select").chosen({
        width: "100%", // Set the width as needed
        no_results_text: "No results found",
    });
});
</script>


<script>
function filterOptions() {
    var input, filter, ul, li, checkbox, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    ul = document.getElementById("optionsList");
    li = ul.getElementsByTagName("li");

    for (i = 0; i < li.length; i++) {
        checkbox = li[i].getElementsByTagName("input")[0];
        txtValue = li[i].textContent || li[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            li[i].style.display = "";
            checkbox.style.display = "inline";
        } else {
            li[i].style.display = "none";
            checkbox.style.display = "none";
        }
    }
}
</script>

<script>
// Get the leave type select element
var leaveTypeSelect = document.getElementById('leavetype');

// Get the proofUpload div
var proofUploadDiv = document.getElementById('proofUpload');

// Add an event listener to the select element
leaveTypeSelect.addEventListener('change', function() {
    // Check if the selected leave type is "sick leave"
    if (leaveTypeSelect.value === '4') {
        // If it is, display the proofUpload div
        proofUploadDiv.style.display = 'block';
    } else {
        // If it's not "sick leave," hide the proofUpload div
        proofUploadDiv.style.display = 'none';
    }
});
</script>







       
        @endsection