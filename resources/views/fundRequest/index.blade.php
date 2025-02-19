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
                                    Fund Request
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
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Request Fund</a></button>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Fund Request List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Employee Name</th>
                                            <th>Reason</th>
                                            <th>Amount Requested</th>
                                            <th>Request Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($fundRequest as $fundRequests)
                                            <tr>
                                                <td>{{ $fundRequests->date }}</td>
                                                <td>{{ $fundRequests->user->name }}</td>
                                                <td>{{ $fundRequests->reason }}</td>
                                                <td>{{ number_format($fundRequests->amount) }}</td>
                                                 @if($fundRequests->role == 'manager')
          <td>

                   @if(is_null($fundRequests->statusDr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($fundRequests->statusDr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$fundRequests->drApprover}}</span>
              @elseif($fundRequests->statusDr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$fundRequests->drApprover}}</span>
                 @endif
          </td>
            
          
                   @elseif($fundRequests->role !== 'manager')
         <td>
        @if(is_null($fundRequests->statusManager))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($fundRequests->statusManager == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$fundRequests->managerApprover}}</span>
                   @elseif($fundRequests->statusManager == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$fundRequests->managerApprover}}</span>
         @endif

                        @if(is_null($fundRequests->statusDr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($fundRequests->statusDr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$fundRequests->drApprover}}</span>
              @elseif($fundRequests->statusDr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$fundRequests->drApprover}}</span>
         @endif  
        
                 </td>
                            
                     @endif


                                                <td class="d-flex">
                                                    <a href="{{ route('fundRequest.show', $fundRequests->id) }}" title="View Items" class="m-2 btn btn-sm btn-info">View Items</a>
                                                      @if (isset($fundRequests->statusDr) || isset($fundRequests->statusManager))
                                                      @else
                                                   
                                                        @can('edit fund-request')
                                                        <a href="{{ route('fundRequest.edit', $fundRequests->id) }}" title="Edit" class="m-2 btn btn-sm btn-info " data-id="<?php echo $fundRequests->id; ?>">Edit</a>
                                                        @endcan
                                                        @can('delete fund-request')
                                                        <form action="{{ route('fundRequest.destroy', $fundRequests->id) }}" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="m-2 btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                            <?= csrf_field() ?>
                                                        </form>
                                                        
                                                        @endcan
                                                        
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
                            <h4 class="modal-title" id="exampleModalLabel1">Add Fund Request</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('fundRequest.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label>Employee</label>
                                    <input type="text" name="employee_name" class="form-control"
                                        value={{ $employee->name }} id="recipient-name1" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="message-text" class="control-label">Request Date</label>
                                    <input type="date" name="date" class="form-control" id="recipient-name1">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Reason</label>
                                    <textarea name="reason" class="form-control" id="recipient-name1" value=""></textarea>
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Amount</label>
                                    <input type="number" name="amount" class="form-control" id="recipient-name1"
                                        value="">
                                </div>
                                <div id="cattle">
                                    <div class="form-repeater">
                                        <div class="form-group form-group-repeater">
                                            <div
                                                class="form-group row d-flex justify-content-center align-items-center mt-3">
                                                <div class="col-md-3">
                                                    <label class="form-label">Product/Service</label>
                                                    <input class="form-control" type="text" name="product_name[]"
                                                        required placeholder="Enter Product/Service">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Quantity:</label>
                                                    <input class="form-control" type="number" step="any" name="quantity[]" required
                                                        placeholder="Enter Quantity">
                                                </div>
                                                <div class="col-md-3">
                                                    <label class="form-label">Price each</label>
                                                    <input class="form-control" type="number" step="any" name="price[]" required
                                                        placeholder="Enter Price">
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button"
                                                        class="btn btn-danger repeater-remove">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div
                                                class="form-group row d-flex justify-content-center align-items-center mt-2">

                                                <button type="button" class="btn btn-primary repeater-add">Add
                                                    More</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="" class="form-control"
                                    id="recipient-name1">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                var form = $('.form-repeater');
                var addButton = form.find('.repeater-add');
                var deleteButton = form.find('.repeater-remove');

                // hide the delete button for the first item
                deleteButton.first().hide();

                // add new repeater item
                addButton.on('click', function() {
                    var newItem = form.find('.form-group-repeater').last().clone();
                    newItem.find('input').val('');
                    newItem.find('.repeater-remove').show();
                    newItem.insertAfter(form.find('.form-group-repeater').last());
                    if (form.find('.form-group-repeater').length > 1) {
                        deleteButton.show();
                    }
                });

                // remove repeater item
                form.on('click', '.repeater-remove', function() {
                    $(this).parents('.form-group-repeater').remove();
                    if (form.find('.form-group-repeater').length == 1) {
                        deleteButton.hide();
                    }
                });
            });
        </script>
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-single ').select2({
                    dropdownParent: $("#exampleModal")
                });
            });
        </script>
        <script>
            // In your Javascript (external .js resource or <script> tag)
            $(document).ready(function() {
                $('.js-example-basic-multiple').select2();
            });
        </script>
        <script>
            $(document).ready(function() {
                var table = $('#example').DataTable({
                    lengthChange: false,
                    buttons: ['copy', 'excel', 'pdf', 'colvis']
                });

                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            });
        </script>
    @endsection
