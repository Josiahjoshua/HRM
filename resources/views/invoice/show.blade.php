@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Invoice
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order</li>
                            <li class="breadcrumb-item"> <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                    function goBack() {
                                        window.history.back();
                                    }
                                </script>
                            </li>
                        </ol>
                    </div>

                </div>
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">Add
                            invoice
                    </div>
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
                                <h3 class="card-title">Invoice Details</h3>
                            </div>

                            <div class="card-body">
                                <table id="example" class="table table-bordered table-striped" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Invoice No.</th>
                                            <th>Purchase Order No.</th>
                                            <th>Client Order No.</th>
                                            <th>Customer Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Address</th>
                                            <th>Due date</th>
                                            <th>Unit</th>
                                            <th>Currency</th>
                                            <th>Discount rate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoices as $invoice)
                                            <tr>
                                                <td>{{ $invoice->date }}</td>
                                                <td>{{ $invoice->inv_number }}</td>
                                                <td>{{ $invoice->purchaseOrderNumber }}</td>
                                                <td>{{ $invoice->clientOrderNumber }}</td>
                                                <td>{{ $invoice->customer_name }}</td>
                                                <td>{{ $invoice->phone }}</td>
                                                <td>{{ $invoice->email }}</td>
                                                <td>{{ $invoice->address }}</td>
                                                <td>{{ \Carbon\Carbon::parse($invoice->date)->addDays(30)->format('d M Y') }}</td>
                                                <td>{{ $invoice->unit }}</td>
                                                <td>{{ $invoice->currency }}</td>
                                                <td>{{ $invoice->discount }}</td>

                                                <td>
                                                    <div class="d-flex">
                                                        @can('edit invoice')
                                                            <a href="{{ route('invoice.edit', $invoice->id) }}"
                                                                class="btn btn-primary mr-2">Edit</a>
                                                        @endcan

                                                        @can('delete invoice')
                                                            <form action="{{ route('invoice.destroy', $invoice->id) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button class="mr-2 btn btn-danger" type="submit"
                                                                    onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                                <?= csrf_field() ?>
                                                            </form>
                                                        @endcan

                                                        <button class="view-details btn btn-primary mr-2"
                                                            data-toggle="modal"
                                                            data-target="#DetailsModel{{ $invoice->id }}">
                                                            View Details
                                                        </button>
                                                        <a href="{{ route('invoice_generate', $invoice->id) }}"
                                                            class="btn btn-info mr-2">Generate Invoice</a>
                                                        @if ($invoice->status == 1)
                                                            <span class="text-success">paid on
                                                                {{ $invoice->pay_date }}</span>
                                                        @else
                                                            @can('update invoice')
                                                                <button class="view-retain-modal btn btn-secondary mr-2"
                                                                    data-toggle="modal" data-asset="{{ $invoice->id }}"
                                                                    data-asset-id="{{ $invoice->id }}" data-target="#PayModal"
                                                                    onclick="setAssetIdRetain(this)"> Paid
                                                                </button>
                                                            @endcan
                                                        @endif
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


            @foreach ($invoices as $invoice)
                <div class="modal fade" id="DetailsModel{{ $invoice->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="DetailsModel{{ $invoice->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="DetailsModalLabel">List of Products/Services</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th>Service</th>
                                            <th>Quantity</th>
                                            <th>Price@Unit</th>
                                            <th>Total</th>
                                            <th>Tax(%)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoiceDetails as $invoiceDetail)
                                            @if ($invoiceDetail->invoice_id == $invoice->id)
                                                <tr>
                                                    <td>{{ $invoiceDetail->service }}</td>
                                                    <td>{{ number_format($invoiceDetail->quantity) }}</td>
                                                    <td>{{ number_format($invoiceDetail->price) }}</td>
                                                    <td>{{ number_format($invoiceDetail->price * $invoiceDetail->quantity) }}
                                                    </td>
                                                    <td>{{ $invoiceDetail->tax }}</td>


                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </section>



        <div class="modal fade" id="modal-default">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Invoice</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="{{ route('invoice.store') }}" id="loanvalueform"
                            enctype="multipart/form-data">
                            @csrf

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
                                <label for="recipient-name1" class="control-label">Customer Name</label>
                                <input type="text" name="customer_name" class="form-control" id="recipient-name1"
                                    placeholder = "John Doe" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name1" class="control-label">Purchase Order No</label>
                                <input type="text" name="purchaseOrderNumber" class="form-control"
                                    id="recipient-name1" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name1" class="control-label">Client Order No.</label>
                                <input type="text" name="clientOrderNumber" class="form-control"
                                    id="recipient-name1">
                            </div>

                            <div class="form-group">
                                <label for="recipient-name1" class="control-label">Email</label>
                                <input type="email" name="email" class="form-control" id="recipient-name1"
                                    placeholder = "john@pejuni.com" required>
                            </div>


                            <div class="form-group">
                                <label for="recipient-name1" class="control-label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="recipient-name1"
                                    placeholder = "255123456789" required>
                            </div>

                            <div class="form-group">
                                <label for="recipient-name1" class="control-label">Address</label>
                                <input type="text" name="address" class="form-control" id="recipient-name1"
                                    placeholder = "Dsm, Tanzania" required>
                            </div>


                            <div class="form-group">
                                <label for="message-text" class="control-label">Date</label>
                                <input type="date" name="date" class="form-control" id="recipient-name1" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Product/service Unit:</label>
                                <input class="form-control" type="text" name="unit" 
                                    placeholder="Enter Unit" required>
                            </div>

                            <div class="col-md-3">
                                <label class="form-label">Currency:</label>
                                <input class="form-control" type="text" name="currency" 
                                    placeholder="Enter Currency" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Discount(%):</label>
                                <input class="form-control" type="text" name="discount" 
                                    placeholder="Enter Currency">
                            </div>

                          
                            <div id="cattle">
                                <div class="form-repeater">
                                    <div class="form-group form-group-repeater">
                                        <div class="form-group row d-flex justify-content-center align-items-center mt-3">

                                            <div class="col-md-3">
                                                <label class="form-label">Description:</label>
                                                <input class="form-control" type="text" name="service[]" required
                                                    placeholder="Enter service" required>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label">Quantity:</label>
                                                <input class="form-control" type="number" step="any"
                                                    name="quantity[]" required placeholder="Enter Quantity" required>
                                            </div>
                                         
                                            <div class="col-md-3">
                                                <label class="form-label">Price@Unit:</label>
                                                <input class="form-control" type="number" step="any" name="price[]"
                                                    required placeholder="Enter price" required>
                                            </div>

                                            <div class="form-group">
                                                <label>Taxable</label>
                                                <select name="tax[]" class="form-control custom-select" id="tax[]"
                                                    aria-placeholder="select product tax">

                                                    <option value="Yes">Yes</option>
                                                    <option value="No">No</option>

                                                </select>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button"
                                                    class="btn btn-danger repeater-remove">Delete</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group row d-flex justify-content-center align-items-center mt-2">
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-primary repeater-add">Add
                                                    More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

        <div>
            <div class="modal fade" id="PayModal" tabindex="-1" role="dialog" aria-labelledby="PayModal"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="PayModal">Update Pay Status</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="POST" action="{{ route('paid') }}" id="loanvalueform"
                                enctype="multipart/form-data">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <input type="hidden" id="asset_id_input_retain" name="invoice_id" value="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label">Pay Date </label>
                                        <input type="date" name="pay_date" id="example-email2" class="form-control"
                                            placeholder="" required>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    <?= csrf_field() ?>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
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
    {{--  <script>
        var $stockQuantities = {!! json_encode($stockQuantities) !!};
    </script>

    <!-- Include your JavaScript code here -->
    <script>
        $(document).ready(function() {
            var form = $('#cattle');
            var addButton = form.find('.repeater-add');
            var deleteButton = form.find('.repeater-remove');

            // hide the delete button for the first item
            deleteButton.first().hide();

            // Object to store product quantities
            var productQuantities = {};

            // Function to retrieve the quantity for a selected product (using the $stockQuantities array)
            function getProductQuantity(productId) {
                var quantity = parseFloat($stockQuantities[productId]);

                if (isNaN(quantity)) {
                    quantity = 0; // Handle the case where the quantity is not found in the array
                }

                return quantity;
            }

            // Add an event listener to the product select to update the available quantity
            form.on('change', 'select[name="product_id[]"]', function() {
                var productSelect = $(this);
                var productId = productSelect.val();

                // Simulate an AJAX call to fetch the quantity for the selected product
                var quantity = getProductQuantity(productId);

                // Store the quantity in the productQuantities object
                productQuantities[productId] = quantity;
            });

            // Add an event listener to the weight input to check quantity before adding more
            form.on('click', '.repeater-add', function() {
                var weightInputs = form.find('input[name="weight[]"]');
                var productSelects = form.find('select[name="product_id[]"]');
                var canAddMore = true;

                weightInputs.each(function(index, weightInput) {
                    var weight = parseFloat($(weightInput).val());
                    var productId = productSelects.eq(index).val();
                    var quantity = productQuantities[productId];

                    if (isNaN(weight) || weight > quantity) {
                        var productName = productSelects.eq(index).find('option:selected').text();
                        alert('Weight exceeds available quantity in stock for ' + productName +
                            '. Available quantity: ' + quantity);
                        canAddMore = false;
                        return false; // Stop the loop
                    }
                });

                if (canAddMore) {
                    // Clone and add a new repeater item if all checks pass
                    var newItem = form.find('.form-group-repeater').last().clone();
                    newItem.find('input').val('');
                    newItem.find('.repeater-remove').show();

                    // Clear any existing warning messages
                    newItem.find('.weight-warning').remove();

                    newItem.insertAfter(form.find('.form-group-repeater').last());
                    if (form.find('.form-group-repeater').length > 1) {
                        deleteButton.show();
                    }
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
    </script> --}}

    <script>
        // Initialize Select2 for the select element with class "select2"
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

    <script>
        $(function() {

            $('#example').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>

    <script>
        function setAssetIdRetain(button) {
            var assetId = button.getAttribute('data-asset-id');
            document.getElementById('asset_id_input_retain').value = assetId;
        }
    </script>


@endsection
