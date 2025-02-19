@extends('layouts.app')

@section('content')
<div class="content-wrapper">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
       <h1>       Casual Workers </h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active">Casual Workers</li>
          </ol>
        </div>
      </div>
    </div>
  </section>
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="col-sm-6">  
             <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> Add Workers</button>
           
              </div>
            </div>
            
            <div class="card-body">
            <h3 class="card-title">List of Casual Workers</h3>
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                  <tr>
                  <tr>
                  <th>Worker Name</th>
                    <th>Location</th>
                    <th>Phone number</th>
                    <th>Agreed Amount</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Action</th>
                    <th>View Details</th>

                </tr>
                  </tr>
                </thead>
               
                <tbody>
                @foreach($casual as $casuals)
                
                    <tr>
                        <td>{{$casuals->worker_name }}</td>
                        <td>{{$casuals->location }}</td>
                        <td>{{$casuals->phone }}</td>
                        <td>{{$casuals->amount}}</td>
                        <td>{{$casuals->start_date}}</td>
                        <td>{{$casuals->end_date}}</td>
                       
                       </td>
    
                    <td>
                      <div class="d-flex">
                                          <a href="{{ route('casual.edit', $casuals->id)}}" title="Edit"  class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $casuals->id; ?>" >Edit</a>
                                          <form action="{{ route('casual.destroy', $casuals->id) }}" method="post">
                            @csrf
                            @method('DELETE')
                            <button class="m-2 btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                            <?= csrf_field() ?>
                          </form>
                         </td>
                         <td >
                           <a class="btn btn-info btn-sm ml-2" href="{{ route('viewCasual', $casuals->id) }}"> View Details</a>     
                  
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


</div>
<div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Casual Workers</h4>
     
      </div>
      <div class="modal-body">
        <form role="form" method="post" action="{{route('casual.store')}}" id="loanvalueform" enctype="multipart/form-data">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
           
          <div class="modal-body">            

<div class="form-group">
    <label class="control-label">Worker Name</label>
    <input type="text" name="worker_name" class="form-control" id="recipient-name1" required>
</div>

<div class="form-group">
    <label class="control-label">Agreed Amount per Hour</label>
    <input type="text" name="amount" class="form-control" id="recipient-name1" required>
</div>
<div class="form-group">
  <label>Image</label>
    <input type="file" name="em_image" class="form-control" value="">
      </div>
      <div class="form-group">
  <label>Upload ID</label>
    <input type="file" name="id_card" class="form-control" value="">
      </div>
      <div class="form-group">
    <label class="control-label">Phone Number</label>
    <input type="text" name="phone" class="form-control" id="recipient-name1" maxlength="10" required>
</div>
<div class="form-group">
    <label class="control-label">Location</label>
    <input type="text" name="location" class="form-control" id="recipient-name1" required>
</div>

                                                                             
<div class="form-group">
    <label class="control-label">Start Date:</label>
    <input type="date" name="start_date" class="form-control" id="start_date">
</div>
<div class="form-group">
    <label class="control-label">End Date:</label>
    <input type="date" name="end_date" class="form-control" id="end_date">
</div> 
</div>


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
      "buttons": ["excel"]
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