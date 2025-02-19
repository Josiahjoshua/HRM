@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            Profit Loss Report
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"> Profit Loss Report</li>
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

      <div class="col-sm-6">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">Generate
          report</button>
          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-default2">Generate
            report in pdf</button>
      </div>

    </div>
    @if ($errors->any())
    <div class="alert alert-danger mt-2">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Income Details</h3>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Amount</th>
                </thead>
                <tbody>
                 

  

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Expenditure Details</h3>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <th>Date</th>
                  <th>Name</th>
                  <th>Amount</th>
                </thead>
                <tbody>
                  

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      
    </div>

    <div>
      <div class="modal fade" id="modal-default2">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Generate Profit Loss Report in pdf</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form role="form" method="post" action="{{route('profitLossReport')}}" id="loanvalueform"
                enctype="multipart/form-data">
                <div class="modal-body">
      
      
                  <div class="form-group">
                    <label for="message-text" class="control-label">From</label>
                    <input type="date" name="start_date" class="form-control" id="recipient-name1" required>
                  </div>
      
                  <div class="form-group">
                    <label for="message-text" class="control-label">To</label>
                    <input type="date" name="end_date" class="form-control" id="recipient-name1" required>
                  </div>
                
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success">Generate</button>
                  </div>
                  <?= csrf_field() ?>
              </form>
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
        <h4 class="modal-title">Generate Profit Loss Report</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('profitLoss')}}" id="loanvalueform"
          enctype="multipart/form-data">
          <div class="modal-body">


            <div class="form-group">
              <label for="message-text" class="control-label">From</label>
              <input type="date" name="start_date" class="form-control" id="recipient-name1" required>
            </div>

            <div class="form-group">
              <label for="message-text" class="control-label">To</label>
              <input type="date" name="end_date" class="form-control" id="recipient-name1" required>
            </div>
          
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-success">Generate</button>
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
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
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