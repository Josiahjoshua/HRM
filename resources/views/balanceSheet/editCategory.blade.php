@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Edit Balance Sheet Category 
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Balance Sheet Category</li>
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
                    <div class="col-6">
        <div class="card">
            <div class="card-body">
<form role="form" method="post" action="{{ route('balanceSheet.update', $balanceSheet->id) }}" id="loanvalueform"
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
        <label for="message-text" class="control-label">Category</label>
        <input type="text" name="category_name" class="form-control" id="recipient-name1" required value="{{ $balanceSheet->category_name }}">
    </div>

    <div class="form-group">
        <label>Category Type</label>
        <select name="type" class="form-control custom-select" id="type" aria-placeholder="select type">
            <option value="Assets" {{ $balanceSheet->type == 'Assets' ? 'selected' : '' }}>Asset</option>
            <option value="Liabilities" {{ $balanceSheet->type == 'Liabilities' ? 'selected' : '' }}>Liability</option>
        </select>
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
