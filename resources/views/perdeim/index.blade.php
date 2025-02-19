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
                                    Perdeim Application
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
                                aria-hidden="true"></i> Add Perdeim</a></button>

                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Perdeim List </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Perdiem </th>
                                            <th>Allowance Requested </th>
                                            <th>Allowance Used</th>
                                            <th>Approval Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($perdeim as $perdeims)
                                            <tr>
                                                <td>{{ $perdeims->date }}</td>
                                                <td>{{ $perdeims->reason }}</td>
                                                <td>{{ number_format($perdeims->amount) }}</td>
                                                <td>{{ number_format($perdeims->allowance) }}</td>
<td>
    @if(isset($perdeims->allowance ))
    @if (is_null($perdeims->amount_used ))
        <span class="text-danger">Not yet retired</span>
    @else
        {{ number_format($perdeims->amount_used) }}
    @endif
    @else
    @endif
</td>

                                                     
                                                                                  
         @if($perdeims->role == 'manager')
          <td>

                   @if(is_null($perdeims->statusDr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($perdeims->statusDr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$perdeims->drApprover}}</span>
              @elseif($perdeims->statusDr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$perdeims->drApprover}}</span>
                 @endif
          </td>
            
          
                   @elseif($perdeims->role !== 'manager')
         <td>
        @if(is_null($perdeims->statusManager))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($perdeims->statusManager == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$perdeims->managerApprover}}</span>
                   @elseif($perdeims->statusManager == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$perdeims->managerApprover}}</span>
         @endif

                        @if(is_null($perdeims->statusDr))
        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                    @elseif($perdeims->statusDr == 1)
        <span class="p-2 mb-1 bg-success text-white">Approved by {{$perdeims->drApprover}}</span>
              @elseif($perdeims->statusDr == 0)
        <span class="p-2 mb-1 bg-danger text-white">Rejected by {{$perdeims->drApprover}}</span>
         @endif  
        
                 </td>
                            
                     @endif  
                                                <!--<td>-->
                                                <!--    @if (is_null($perdeims->statusDr))-->
                                                <!--        <span class="p-2 mb-1 bg-primary text-white">Pending</span>-->
                                                <!--    @elseif($perdeims->statusDr >= 1)-->
                                                <!--        <span class="p-2 mb-1 bg-success text-white">Approved</span>-->
                                                <!--    @elseif($perdeims->statusDr == 0)-->
                                                <!--        <span class="p-2 mb-1 bg-danger text-white">Rejected</span>-->
                                                <!--    @endif-->
                                                <!--</td>-->


                                                <td class="d-flex">
                                                    @if (isset($perdeims->statusDr) || isset($perdeims->statusManager))
                                                    @else
                                                    <a href="{{ route('perdeim.edit', $perdeims->id) }}"
                                                        class="btn btn-primary">Edit</a>
                                                    <form action="{{ route('perdeim.destroy', $perdeims->id) }}"
                                                        method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="ml-4 btn btn-danger" type="submit"
                                                            onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                        <?= csrf_field() ?>
                                                    </form>
                                                   
                                                    @endif

                                                    @if(isset($perdeims->allowance ))
                                                    @if ($perdeims->statusDr >= 1 && $perdeims->statusManager >= 1)
                                                        <a href="{{ route('perdeim.show', $perdeims->id) }}" title="Retirement"
                                                            class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp"
                                                            data-id="<?php echo $perdeims->id; ?>">Retirement</a>
                                                    @else
                                                    @endif
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
                            <h4 class="modal-title" id="exampleModalLabel1">Add Perdeim</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('perdeim.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="form-group "> <input type="hidden" name="perdeim_id" value="$perdeim->id"
                                        </div>

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
                                        <label class="control-label">Description</label>
                                        <textarea name="reason" class="form-control" id="recipient-name1"  required></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Perdeim Amount</label>
                                        <input type="number" name="amount" class="form-control" id="recipient-name1"
                                            value="" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Allowance Amount if any</label>
                                        <input type="number" name="allowance" class="form-control" id="recipient-name1"
                                            >
                                    </div>

<!--                          <div class="form-group">-->
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
    @endsection
