@extends('layouts.app')

@section('content')
<div class="content-wrapper">
    <!-- Add your edit form code here -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                            <h1>Edit Perdeim Retire</h1>
                            </div>
                            
                                <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('perdeim.index') }}">Perdeim</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                  function goBack() {
                                    window.history.back();
                                  }
                                </script></li>
                        </ol>
                    </div>
                    
            <div class="col-md-6">

                <form method="POST" action="{{ route('perdeimretire.update', $perdeimretire->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Add your form fields for editing here -->
                    <div class="form-group">
                        <label for="reason">Amount:</label>
                        <input type="number" name="amount_used" class="form-control" value="{{ $perdeimretire->amount_used }}">
                    </div>
                    
                                                                <div class="form-group">
                                                <label for="message-text" class="control-label">File Title</label>
                                                <input type="text" name="file_title" class="form-control" id="recipient-name1" value="{{ $perdeimretire->file_title }}">
                                            </div>
                    

                                      <div class="form-group">
                                        <label for="proof">Proof</label>
                                       <input type="file" class="form-control" id="proof" name="file_url" accept=".pdf,.jpeg,.jpg,.png">
                                    </div>
                            <a href="{{ route('retire.download', $perdeimretire->id) }}" target="_blank">View Proof</a><br><br>

                    <!-- Add other form fields here -->

                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
