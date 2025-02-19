@extends('layouts.app')

@section('content')
<div class="content-wrapper">
            <div class="message"></div>
            <div class="container-fluid">
            <div class="header-body m-1">
              <div class="row align-items-end">
                   <div class="col">
                      <h1 class="header-title">
                  Earn Leave
                       </h1>
                    </div>
                </div> 
            </div> 
        </div>
            <div class="container-fluid mt-4">
                <div class="row m-b-10"> 
                    <div class="col-12">
                        <button type="button" class="btn btn-info mb-4"><i class="fe fe-plus"></i><a data-toggle="modal" data-target="#earnmodel" data-whatever="@getbootstrap" class="text-white TypeModal"><i class="" aria-hidden="true"></i> Assign Earned Leave </a></button>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-12">
                        <div class="card card-outline-info">
                            <div class="card-header">
                                <h4 class="m-b-0 "> Earn Balance                      
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Employee PIN</th>
                                                <th>Employee Name </th>
                                                <!--<th>Total Day </th>-->
                                                <th>Total days</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th>Employee PIN</th>
                                                <th>Employee Name </th>
                                                <!--<th>Total Day </th>-->
                                                <th>Total days </th>
                                                <th>Action</th>
                                            </tr>
                                        </tfoot>
                                        <tbody>
                                        @foreach($leave_earn as $earn)
                                            <tr>
                                                <td>{{$earn->employee->em_code}}</td>
                                                <td>{{$earn->employee->first_name}}</td>
                                                <td>{{$earn->total_earndays}}</td>
                                                
                                               <td class="jsgrid-align-center">
                                                    <a href="{{ route('leave_earn.edit', $earn->id)}}" title="Edit" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $earn->em_id; ?>">Edit</a>
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
                        <div class="modal fade" id="earnmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content ">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="exampleModalLabel1">Earn Leave</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <form method="post" action="{{route('leave_earn.store')}}" id="earnform" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        
                                        <div class="form-group">
                                       <label>Employee </label>
                                        <select name="first_name" class="form-control select2 custom-select" style="width:100%" required>
                                        @foreach ($employee as $employees)
                                             <option value="{{ $employees->id }}"> {{ $employees->first_name }} </option>
                                                 @endforeach

                                        </select>
                                        </div>
                                        <div class="form-group">
                                        <label>Start Date </label>
                                        <input type="date" name="start_date" class="form-control mydatepicker" value="" required>
                                        </div>
                                        <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control mydatepicker" value="">
                                        </div>
                                        <div class="form-group">
                                        <input type="hidden" name="total_earndays" class="form-control" hide="hidden" value="" placeholder="number of days..." readonly>                                        </div>                                         
                                        
                                
                                    <div class="modal-footer">
                                    <input type="hidden" name="employee_id" value="" class="form-control" id="recipient-name1">                                       
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
    var table = $('#example').DataTable( {
        lengthChange: false,
        buttons: [ 'copy', 'excel', 'pdf', 'colvis' ]
    } );
 
    table.buttons().container()
        .appendTo( '#example_wrapper .col-md-6:eq(0)' );
} );
</script>
@endsection