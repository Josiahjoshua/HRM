@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
        <h1>Worker Details</h1>
    <p>Name: <b>{{ $casual->worker_name }}</b></p>
    <p>Agreed amount per hour: {{number_format( $casual->amount) }}</p>
    <p>Start date: {{ $casual->start_date }}</p>
    <p>End date: {{ $casual->end_date }}</p>
         </div>
        
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Work Details</li>
          </ol>
        </div>
      </div>
    </div>


<div class="btn-group m-3">
    <div class="ml-3 mr-5">
        <button type="button" class="btn btn-primary float-left" data-toggle="modal" data-target="#modal-default">Add detail</button>
    </div>
    <div class="ml-auto mr-3"> 
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#modal-default2">Add Payment</button>
    </div>
</div>


  <section>
  <div class="modal fade" id="modal-default2">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Payment</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('casualPaymentDetails.store')}}" id="loanvalueform" enctype="multipart/form-data">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <input type="hidden" name="casual_id" value="{{ $casual->id }}">
            
          <div class="modal-body">
          <div class="form-group">
    <label class="control-label">Date:</label>
    <input type="date" name="dateofPay" class="form-control" id="date">
      </div>
      <div class="form-group">
              <label class="control-label">Payment Description</label>
              <input type="text" name="description" class="form-control" id="recipient-name1" required>
          </div> 

        <div class="form-group">
              <label class="control-label">Paid Amount</label>
              <input type="number" name="paid_amount" class="form-control" id="recipient-name1" required>
          </div>        
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Payment</button>
          </div>
          <?= csrf_field() ?>
        </form>
      </div>
    </div>
  </div>
</div>
</section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-7">
        <div class="card card-primary card-outline">
            <div class="card-header">            
              <h3 class="card-title">List of work days</h3>
            </div>
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                  <th>Date Worked</th>
                  <th>Hours Worked</th>
                  <th>Action</th>
                  
                  </tr>
                </thead>
                 <tbody>
                  @foreach ($casualDetails as $casuals)
                  <tr>
 
                    <td>{{ $casuals->date}}</td>
                    <td>{{ $casuals->hours}}</td>
                    <td  class="d-flex">
                            <a href="{{ route('casualDetails.edit', $casuals->id) }}" class="btn btn-primary mr-2">Edit</a>
                            <form action="{{ route('casualDetails.destroy', $casuals->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                            <?= csrf_field() ?>
                          </form>
                      </td>
                   </tr>                
                  @endforeach
                </tbody>
              </table>
              <br> <b>  <p>Total due amount: {{number_format( $totalDueAmount) }}</p></b> 
            </div>
          </div>
        </div>
        <div class="col-5">
        <div class="card card-primary card-outline" class="card bg-blue">
            <div class="card-header">            
              <h3 class="card-title">Payment Details</h3>
            </div>
            <div class="card-body">
              <table id="example" class="table table-bordered table-striped" style="width:100%">
                <thead>
                  <tr>
                  <th>Date</th>
                  <th>Payment Description</th>
                  <th>Paid Amount</th>     
                  <th>Action</th>   
                  </tr>
                </thead>
                <tbody>
                  @foreach ($casualPayment as $casuals)
                  <tr>
                    <td>{{ $casuals->dateofPay}}</td>
                    <td>{{ $casuals->description}}</td>
                    <td>{{number_format($casuals->paid_amount)}}</td>
                    <td> 
                    <div class="btn-group">
                    <a href="{{ route('casualPaymentDetails.edit', $casuals->id) }}" class="btn btn-primary mr-2">Edit</a>
                    <form action="{{ route('casualPaymentDetails.destroy', $casuals->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                            <?= csrf_field() ?>
                          </form>
                          </div>
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
  </section>
</div>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('casualDetails.store')}}" id="loanvalueform" enctype="multipart/form-data">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <input type="hidden" name="casual_id" value="{{ $casual->id }}">
            
          <div class="modal-body">
          <div class="form-group">
    <label class="control-label">Date:</label>
    <input type="date" name="date" class="form-control" id="date">
      </div>

        <div class="form-group">
              <label class="control-label">Number of Hours</label>
              <input type="number" name="hours" class="form-control" id="recipient-name1" required>
          </div>        
          <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Detail</button>
          </div>
          <?= csrf_field() ?>
        </form>
      </div>
    </div>
  </div>
</div>


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
    
      <script>
        $(function() {

            $('#example').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

@endsection