@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
            
         Balance Sheet 
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active"> Balance Sheet </li>
            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
              <script>
                function goBack() {
                  window.history.back();
                }
              </script></li>
          </ol>
        </div>

      </div>
     
      <div class="col-sm-6">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> Add Category</button>

        <a href="{{route('balancesheetreport')}}" class="btn-sm btn-success">Generate Balance Sheet</a>
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
              <h3 class="card-title">Category Details</h3>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  
                    <th>Category name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($balanceSheet  as $products)
                  <tr>
                    <td>{{ $products->category_name}}</td>

                    <td>
                      <div class="d-flex">

                        @if ($products->category_name == 'Current Assets' && $products->category_name == 'Fixed Assets')
                          
                        @else
                          
                      
                          
                        <a href="{{route('balanceSheet.edit', $products->id)}}" class="btn-sm btn-primary mr-3">Edit</a>
                      
                        <form action="{{ route('balanceSheet.destroy', $products->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button class="btn-sm btn-danger mr-3" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                          <?= csrf_field() ?>
                        </form>
                        @endif
                       <a href="{{route('balanceSheet.show', $products->id)}}" class="btn-sm btn-info">View Category Items</a>
                      
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
          <h4 class="modal-title">Add Category</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="{{route('balanceSheet.store')}}" id="loanvalueform" enctype="multipart/form-data">
            <div class="modal-body">


              <div class="form-group">
                <label for="message-text" class="control-label">Category Name</label>
                <input type="text" name="category_name" class="form-control" id="recipient-name1" required>
              </div>

              <div class="form-group">
                <label>Category Type</label>
                <select name="type" class="form-control custom-select" id="type" aria-placeholder="select type">

                        <option value="Assets" >Asset</option>
                        <option value="Liabilities">Liability</option>
                        
                </select>
            </div>

           <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Save</button>
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
