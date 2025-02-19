@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Edit Income
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Income</li>
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
<form role="form" method="post" action="{{ route('income.update', $income->id) }}" id="loanvalueform"
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
        <label for="message-text" class="control-label">Date</label>
        <input type="date" name="date" class="form-control" id="recipient-name1" required value="{{ $income->date }}">
    </div>

    <div class="form-group">
        <label class="control-label">Description</label>
        <textarea class="form-control" name="desc" id="message-text1" required minlength="14"
            rows="4">{{ $income->desc }}</textarea>
    </div>

    <div class="form-group">
        <label class= "control-label">Amount</label>
        <input type="number" step="any" name="amount" value="{{ $income->amount }}" class="form-control"
            id="recipient-name1">
    </div>

 
    <div class="form-group">
        <label class= "control-label">From</label>
        <input type="text"  name="from" value="{{ $income->from }}" class="form-control"
            id="recipient-name1">
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
