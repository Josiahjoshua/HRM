@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Cattle Batch</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Cattle Batch</li>
                            <li class="breadcrumb-item">
                                <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                    function goBack() {
                                        window.history.back();
                                    }
                                </script>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-primary">

                            <div class="card-body">
                                <form role="form" method="post" action="{{ route('batch.update', $batch->id) }}">
                                    @csrf
                                    @method('PUT')


                                    <div class="form-group">
                                        <label for="batch_name">Batch Name</label>
                                        <input type="text" class="form-control" name="batch_name" id="batch_name"
                                            value="{{ $batch->batch_name }}" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Date Created</label>
                                        <input type="date" class="form-control" name="date" id="date"
                                            value="{{ $batch->date }}" required>
                                    </div>

                                    <div class="form-group">
                                        <h3>Assigned Cattles</h3>
                                        <table class="table table-bordered table-striped">
                                            <thead>
                                                <th>Tag</th>
                                                <th>Enter Date</th>
                                                <th>Exit Date</th>
                                                <th>Action</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($batch->cattles as $cattle)
                                                    <tr>
                                                        <td> <input type="text"  class="form-control" name="tag[{{ $cattle->id }}]" value="{{ $cattle->tag }}" readonly/> </td>
                                                        <td> <input type="date"  class="form-control" name="batch_enter_date[{{ $cattle->id }}]" value="{{ $cattle->batch_enter_date }}" /></td>
                                                        <td>  <input type="date"  class="form-control" name="batch_exit_date[{{ $cattle->id }}]" value="{{ $cattle->batch_exit_date }}" /></td>
                                                        <td>
                                                           <a href="{{ route('removeFromBatch', ['batchId' => $batch->id, 'tag' => $cattle->tag]) }}">Remove</a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>

    {{-- <div class="form-group">
    <label for="cattle_to_assign">Add Cattle to Batch</label>
    <input type="text" list="cattleList" class="form-control" name="cattleTag" id="cattleTag" 
        placeholder="Select Cattle"> 
    <datalist id="cattleList"> 
        @foreach ($cattles as $cattle)
            <option value="{{ $cattle->tag }}">{{ $cattle->tag }}</option> 
        @endforeach 
    </datalist>

    <input type="date" class="form-control mt-2" name="assignDate" id="assignDate" 
        placeholder="assign date"> 

    <a href="#" onclick="checkFields();" id="link">Add</a>
</div> --}}




                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('batch.index') }}" class="btn btn-default">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
      function checkFields() {
          let tag = document.getElementById('cattleTag').value;
          let date = document.getElementById('assignDate').value;
      
          if(tag && !date) {
              event.preventDefault();
              alert('Please select a date');
          } else {
              window.location.href = "{{ route('addToBatch', ['batchId' => $batch->id]) }}";
          }
      }
      </script>

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
@endsection
