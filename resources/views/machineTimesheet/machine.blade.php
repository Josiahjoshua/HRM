@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>
         Machinery
          </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Machinery</li>
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
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> Add Machine</button>
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
              <h3 class="card-title">Machine Details</h3>
            </div>

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  
                    <th>Machine name</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($machine  as $products)
                  <tr>
                
                    
                    <td>{{ $products->machine_name}}</td>

                    <td>
                      <div class="d-flex">
                          
                        <a href="{{route('machine.edit', $products->id)}}" class="btn-sm btn-primary mr-3">Edit</a>
                      
                        <form action="{{ route('machine.destroy', $products->id) }}" method="post">
                          @csrf
                          @method('DELETE')
                          <button class="btn-sm btn-danger mr-3" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                          <?= csrf_field() ?>
                        </form>
                       <a href="{{route('machine.show', $products->id)}}" class="btn-sm btn-info">View Monthly Details</a>
                      
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
          <h4 class="modal-title">Add Machine</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="post" action="{{route('machine.store')}}" id="loanvalueform" enctype="multipart/form-data">
            <div class="modal-body">


              <div class="form-group">
                <label for="message-text" class="control-label">Machine Name</label>
                <input type="text" name="machine_name" class="form-control" id="recipient-name1" required>
              </div>
          <!--   <div class="form-group">-->
          <!--      <label>Product Unit</label>-->
          <!--      <select name="unit" class="form-control custom-select" id="unit" aria-placeholder="select product unit">-->

          <!--              <option value="kg" >Kg</option>-->
          <!--              <option value="piece">Piece</option>-->
          <!--              <option value="set">Set</option>-->
          <!--              <option value="litre">Litres</option>-->
          <!--      </select>-->
          <!--  </div>-->
          <!--  <div class="form-group">-->
          <!--    <label>Quater Category</label>-->
          <!--    <select name="quater_category" class="form-control custom-select" id="type" aria-placeholder="select quater category">-->

          <!--            <option value="Fifth Quater" >5th Quater</option>-->
          <!--            <option value="Carcass">Carcass</option>-->

          <!--    </select>-->
          <!--</div>-->
          <!--    <div class="form-group">-->
          <!--      <label for="message-text" class="control-label">Price Per Kg</label>-->
          <!--      <input type="text" name="price" class="form-control" id="recipient-name1" required>-->
          <!--    </div>-->
           <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
