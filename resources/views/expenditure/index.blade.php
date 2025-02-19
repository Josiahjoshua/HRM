@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Monthly {{$expenditure->category_name}}  Expenditure 
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                        <li class="breadcrumb-item active">Expenditure</li>
                        <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                            <script>
                                function goBack() {
                                    window.history.back();
                                  }
                            </script>
                        </li>
                    </ol>
                </div>
            </div>
            @if ($expenditure->category_name == "Net Salary" || $expenditure->category_name == "Perdeim" || $expenditure->category_name == "Fund Request") 
             
         @else

         <div class="row mb-2">

            <div class="col-sm-6">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Add
                    Expenditure
            </div>
        </div>
             
         @endif

            

    </section>
    <div class="card">
        <div class="card-body">
            <section class="content mt-2">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card" style="background-color:#f4f6f9;">
                                <div class="card-header">
                                    <h3 class="card-title">List of monthly income</h3>
                                </div>
                                <div class="card-body">
                                    <table id="products_table" class="table table-bordered table-striped" id="example1">
                                        @if ($expenditure->category_name == "Net Salary")
                                        <thead>
                                            <tr>
                                                <th>Month</th>
                                                <th>Net salary</th>
                                                
                                            </tr>
                                        </thead>
                                        <tbody>

                                           

                                            @foreach ($monthlyExpenditure as $monthlyExpenditures)
                                            <tr>
                                                <td>{{ $monthlyExpenditures->month }}</td>
                                                <td>{{ number_format($monthlyExpenditures->total_amount) }}</td>
                                                
                                            </tr>
                                            @endforeach
                                           
                                        </tbody>
                                                
                                            @else

                                            <thead>
                                                <tr>
                                                    <th>Month</th>
                                                    <th>Total Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                            
                                            @foreach ($monthlyExpenditure as $monthlyExpenditures)
                                            <tr>
                                                <td>{{ $monthlyExpenditures->month }}</td>
                                                <td>{{ number_format($monthlyExpenditures->total_amount) }}</td>
                                                <td>
                                                   
                                                        
                                                    
                                                    <button class="view-daily-sales btn btn-primary mr-2"
                                                        data-month="{{ $monthlyExpenditures->month }}" data-toggle="modal"
                                                        data-target="#dailyTimesheetModal">
                                                        View Daily Details
                                                    </button>
                                                   


                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Daily Sales Modal -->
    @foreach ($monthlyExpenditure as $monthlyExpenditures)
    <div class="modal fade" id="dailyTimesheetModal" tabindex="-1" role="dialog"
        aria-labelledby="dailyTimesheetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dailyTimesheetModalLabel">List of Daily Expenditure</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-striped">

                        @if ($expenditure->category_name == "Perdeim" || $expenditure->category_name == "Fund Request")
                        <thead>

                            <th>Date</th>
                            <th>Amount</th>
                            <th>Reason</th>
                            </thead>
                        <tbody>
                            

                            @foreach ($dailyExpenditure as $dailyExpenditures)
                            @if (date('Y-m', strtotime($dailyExpenditures->date)) === date('Y-m',
                            strtotime($monthlyExpenditures->month)))
                            <tr>
                                <td>{{ $dailyExpenditures->date }}</td>
                                <td>{{number_format($dailyExpenditures->amount ) }}</td>
                                <td>{{ $dailyExpenditures->reason }}</td>
                                
                            
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                                
                            @else

                            <thead>

                                <th>Date</th>
                                <th>Amount</th>
                                <th>For</th>
                                <th>Description</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                
                            
                            @foreach ($dailyExpenditure as $dailyExpenditures)
                            @if (date('Y-m', strtotime($dailyExpenditures->date)) === date('Y-m',
                            strtotime($monthlyExpenditures->month)))
                            <tr>
                                <td>{{ $dailyExpenditures->date }}</td>
                                <td>{{number_format($dailyExpenditures->amount ) }}</td>
                                <td>{{ $dailyExpenditures->for }}</td>
                                <td>{{ $dailyExpenditures->desc }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('expenditure.edit', $dailyExpenditures->id) }}"
                                            class="btn btn-primary mr-2">Edit</a>

                                        <form action="{{ route('expenditure.destroy', $dailyExpenditures->id) }}"
                                            method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger" type="submit"
                                                onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Expenditure</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="{{ route('expenditure.store') }}" id="loanvalueform"
                            enctype="multipart/form-data">
                            @csrf

                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <input type="hidden" name = "category_id" value="{{$expenditure->id}}">

                            <div class="form-group">
                                <label for="message-text" class="control-label">Date</label>
                                <input type="date" name="date" class="form-control" id="recipient-name1" required>
                            </div>



                            <div class="form-group">
                                <label class="control-label">For</label>
                                <input type="text" name="for" value="" class="form-control" id="recipient-name1">
                            </div>

                            <div class="form-group">
                                <label class="control-label">Amount</label>
                                <input type="number" step="any" name="amount" value="" class="form-control"
                                    id="recipient-name1">
                            </div>


                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <textarea class="form-control" name="desc" id="message-text1" required 
                                    rows="4"></textarea>
                            </div>

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>


<script>
    // Initialize Select2 for the select element with class "select2"
    $(document).ready(function() {
        $('.select2').select2();
    });
</script>

<script>
    $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel"],
                "scrollX": true // Add this line to enable horizontal scrolling
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
</script>

@endsection