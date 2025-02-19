@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Invoice</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('invoice.update', $invoice->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                      <div class="form-group">
                                        <label for="name">Customer Name:</label>
                                        <input type="text" class="form-control" name="customer_name" value="{{ $invoice->customer_name }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name1" class="control-label">Purchase Order No</label>
                                        <input type="text"  name="purchaseOrderNumber" class="form-control" id="recipient-name1" value="{{ $invoice->purchaseOrderNumber }}" 
                                           required>
                                    </div>

                                    <div class="form-group">
                                        <label for="recipient-name1" class="control-label">Client Order No.</label>
                                        <input type="text"  name="clientOrderNumber" class="form-control" id="recipient-name1" value="{{ $invoice->clientOrderNumber }}" 
                                           >
                                    </div>

                                    
                                     <div class="form-group">
                                        <label for="name">Email:</label>
                                        <input type="text" class="form-control" name="email" value="{{ $invoice->email }}">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="name">Address:</label>
                                        <input type="text" class="form-control" name="address" value="{{ $invoice->address }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="recipient-name1" class="control-label">Phone</label>
                                        <input type="text"  name="phone" class="form-control" id="recipient-name1" placeholder = "255123456789" value="{{ $invoice->phone }}"
                                           required>
                                    </div>                              
                                    
                                    <div class="form-group">
                                        <label for="date">Date:</label>
                                        <input type="date" class="form-control" name="date" value="{{ $invoice->date }}">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Product/service Unit:</label>
                                        <input class="form-control" type="text" name="unit" 
                                            placeholder="Enter Unit" value="{{ $invoice->unit }}" required>
                                    </div>
        
                                    <div class="form-group">
                                        <label class="form-label">Currency:</label>
                                        <input class="form-control" type="text" name="currency" 
                                            placeholder="Enter Currency" value="{{ $invoice->currency }}" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Discount(%):</label>
                                        <input class="form-control" type="text" name="discount" 
                                            placeholder="Enter Currency" value="{{ $invoice->discount }}">
                                    </div>
                                    <div class="form-group">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr></tr>
                                                <tr>
                                                    <th>Service</th>
                                                    <th>Tax</th>
                                                    <th>Quantity</th>
                                                    <th>Price@unit</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($invoice->invoiceDetail as $added)
                                                    <tr>
                                                       <td>
                                                            <input type="text"  class="form-control" name="service[{{ $added->id }}]" value="{{ $added->service }}" />
                                                        </td>

                                                        <td>
                                                            <div class="form-group">
                                                           
                                                                <select name="tax[{{ $added->id }}]" class="form-control" id="tax" required>
                                                                  <option value="">Select Taxable Option</option>
                                                                  <option value="Yes" @if($added->tax == 'Yes') selected="selected" @endif>Yes</option>
                                                                  <option value="No" @if($added->tax == 'No') selected="selected" @endif>No</option>
                                                                
                                                                </select>
                                                              </div>
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
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
