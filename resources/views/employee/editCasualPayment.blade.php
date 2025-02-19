@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Edit Casual Worker Payment
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Casuak Workers</li>
                            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                  function goBack() {
                                    window.history.back();
                                  }
                                </script></li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-8">
        <div class="card">
            <div class="card-body">
<form role="form" method="post" action="{{ route('casualPaymentDetails.update', $casual->id) }}" id="loanvalueform"
    enctype="multipart/form-data">
    @csrf
    @method('PUT') 

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

   
    <div class="form-group">
        <label for="message-text" class="control-label">Date Paid</label>
        <input type="date" name="dateofPay" class="form-control" id="recipient-name1" required value="{{ $casual->dateofPay }}">
    </div>



    <div class="form-group">
        <label class "control-label">Amount Paid</label>
        <input type="number" step="any" name="paid_amount" value="{{ $casual->paid_amount }}" class="form-control"
            id="recipient-name1">
    </div>

    <div class="form-group">
        <label class="control-label">Description</label>
        <textarea class="form-control" name="description" id="message-text1" required minlength="14"
            rows="4">{{ $casual->description }}</textarea>
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
        </section>
    </div>
@endsection
