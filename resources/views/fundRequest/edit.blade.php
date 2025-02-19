@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Edit Fund Request
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Fund Request</li>
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
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <form method="POST" action="{{ route('fundRequest.update', $item->id) }}" enctype="multipart/form-data">
                                    @csrf
                                    @method('PATCH')
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
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control" name="date" value="{{ $item->date }}" required />
                                    </div>

                                    <div class="form-group">
                                        <label for="date">Reason:</label>
                                        <textarea class="form-control" name="reason" required>{{ $item->reason }}</textarea>
                                           
                                    </div>


                                    <div class="form-group">
                                        <label for="price">Amount:</label>
                                        <input type="number" step="any" class="form-control" name="amount" value="{{ $item->amount }}" required />
                                    </div>

                                    <div class="form-group">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr></tr>
                                                <tr>
 
                                                    <th>Product/Service Name</th>
                                                    <th>Quantity</th>
                                                    <th>Price</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($item->fundrequestdetails as $added)
                                                    <tr>

                                                        <td>
                                                            <input type="text"  class="form-control" name="product_name[{{ $added->id }}]" value="{{ $added->product_name }}" />
                                                        </td>
                                                        <td>
                                                            <input type="number" step="any" class="form-control" name="quantity[{{ $added->id }}]" value="{{ $added->quantity }}" />
                                                        </td>
                                                        <td>
                                                            <input type="number" step="any" class="form-control" name="price[{{ $added->id }}]" value="{{ $added->price }}" />
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <a href="{{ route('fundRequest.index') }}" class="btn btn-secondary">Cancel</a>
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
