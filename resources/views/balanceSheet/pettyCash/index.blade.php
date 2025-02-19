@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Petty Cash
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Petty Cash</li>
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


                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> Add
                        Details</button>
                </div>
            </div>

            <div class="col-sm-6 mt-3">
                <div class="card">
                  
                    <div class="card-body">
                        <table class="table table-bordered table-striped blue-bordered-table">
                            <thead>
                                <tr >
                                    <th class="text-primary">Available Petty Cash</th>
                                    <td>{{ number_format($pettyCashAvailable, 2) }}</td>
                                    
                                </tr>
                            </thead>
                            
                        </table>
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
                                <h3 class="card-title">List of Petty Cash details</h3>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>From/To</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pettyCash as $products)
                                            <tr class="text-nowrap">
                                                <td>{{ $products->date }}</td>
                                                <td>{{ $products->type }}</td>
                                                <td>{{ number_format($products->amount, 2) }}</td>
                                                <td>
                                                    @if ($products->source_destination == "other")
                                                    {{ $products->othersource_destination }}
                                                        
                                                    @else
                                                    {{ $products->source_destination }}
                                                    @endif
                                                   </td>
                                                <td>{{ $products->description }}</td>



                                                <td>
                                                    <div class="d-flex">


                                                        {{-- <button class="view-materials btn btn-info mr-2" data-toggle="modal"
                                                    data-target="#EditMaterialTaken{{ $products->id }}"
                                                    onclick="setProductionDate(this)" data-date="{{ $products->id }}">
                                                    Edit
                                                </button> --}}

                                                        <a href="{{ route('pettyCash.edit', $products->id) }}"
                                                            class="btn-sm btn-info mr-3">Edit</a>


                                                        <form action="{{ route('pettyCash.destroy', $products->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn-sm btn-danger" type="submit"
                                                                onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                            <?= csrf_field() ?>
                                                        </form>

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
                    <h4 class="modal-title">Add Amount</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="post" action="{{ route('pettyCash.store') }}" id="loanvalueform"
                        enctype="multipart/form-data">

                        <div class="form-group">
                            <label>Type</label>
                            <select name="type" class="form-control custom-select" id="type"
                                aria-placeholder="select product unit">
                                <option value="income">Income</option>
                                <option value="expenditure">Expenditure</option>
                            </select>
                        </div>

                        <div class="form-group" id="income">
                            <div class="form-group">
                                <label>From</label>
                                <select name="source_destination" class="form-control custom-select"
                                    id="source_desitination1" aria-placeholder="select product unit">
                                    <option value="cash">Cash in hand</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->bank_name }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Field to enter money source when 'Other' is selected -->
                            <div class="form-group" id="otherField" style="display: none;">
                                <label>Other money source:</label>
                                <input type="text" name="othersource_destination" class="form-control"
                                    placeholder="Enter money source">
                            </div>


                        </div>


                        <div class="form-group" id="expenditure" style="display: none;">
                            <div class="form-group">
                                <label>To</label>
                                <select name="source_destination" class="form-control custom-select"
                                    id="source_desitination2" aria-placeholder="select product unit">
                                    <option value="cash">Cash in hand</option>
                                    @foreach ($banks as $bank)
                                        <option value="{{ $bank->bank_name }}">{{ $bank->bank_name }}</option>
                                    @endforeach
                                    <option value="other">Other</option>
                                </select>
                            </div>

                            <!-- Field to enter money source when 'Other' is selected -->
                            <div class="form-group" id="otherField2" style="display: none;">
                                <label>Other money destination:</label>
                                <input type="text" name="othersource_destination" class="form-control"
                                    placeholder="Enter money source">
                            </div>


                        </div>



                        <div class="form-group">
                            <label for="message-text" class="control-label">Date</label>
                            <input type="date" name="date" class="form-control" id="recipient-name1" required>
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Amount</label>
                            <input type="number" step="any" name="amount" class="form-control"
                                id="recipient-name1" required>
                        </div>
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <textarea name="description" class="form-control" id="description" rows="3" required></textarea>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save </button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @foreach ($pettyCash as $products)
        <div class="modal fade" id="EditMaterialTaken{{ $products->id }}" tabindex="-1" role="dialog"
            aria-labelledby="EditMaterialTaken{{ $products->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Petty Cash</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        @php
                            $id = $products->id;

                            $pettyCashEdit = \App\Models\PettyCash::find($id);
                        @endphp

                        <form role="form" method="post" action="{{ route('pettyCash.update', $pettyCashEdit->id) }}"
                            id="loanvalueform" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label>Type</label>
                                <select name="type" class="form-control custom-select" id="type"
                                    aria-placeholder="select product unit" @readonly(true)>
                                    <option value="income" {{ $pettyCashEdit->type == 'income' ? 'selected' : '' }}>Income
                                    </option>
                                    <option value="expenditure"
                                        {{ $pettyCashEdit->type == 'expenditure' ? 'selected' : '' }}>Expenditure</option>
                                </select>
                            </div>

                            <div class="form-group" id="income"
                                style="{{ $pettyCashEdit->type == 'income' ? 'display:block;' : 'display:none;' }}">
                                <div class="form-group">
                                    <label>From</label>
                                    <select name="source_destination" class="form-control custom-select"
                                        id="source_desitination1" aria-placeholder="select product unit">
                                        <option value="cash"
                                            {{ $pettyCashEdit->source_destination == 'cash' ? 'selected' : '' }}>Cash in
                                            hand</option>
                                        <option value="pettyCash"
                                            {{ $pettyCashEdit->source_destination == 'pettyCash' ? 'selected' : '' }}>Bank
                                        </option>
                                        <option value="other"
                                            {{ $pettyCashEdit->source_destination == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>

                                <!-- Field to enter money source when 'Other' is selected -->
                                <div class="form-group" id="otherField"
                                    style="{{ $pettyCashEdit->source_destination == 'other' ? 'display:block;' : 'display:none;' }}">
                                    <label>Other money source:</label>
                                    <input type="text" name="othersource_destination" class="form-control"
                                        value="{{ $pettyCashEdit->othersource_destination ?? '' }}"
                                        placeholder="Enter money source">
                                </div>
                            </div>

                            <div class="form-group" id="expenditure"
                                style="{{ $pettyCashEdit->type == 'expenditure' ? 'display:block;' : 'display:none;' }}">
                                <div class="form-group">
                                    <label>To</label>
                                    <select name="source_destination" class="form-control custom-select"
                                        id="source_desitination2" aria-placeholder="select product unit">
                                        <option value="cash"
                                            {{ $pettyCashEdit->source_destination == 'cash' ? 'selected' : '' }}>Cash in
                                            hand</option>
                                        <option value="pettyCash"
                                            {{ $pettyCashEdit->source_destination == 'pettyCash' ? 'selected' : '' }}>Bank
                                        </option>
                                        <option value="other"
                                            {{ $pettyCashEdit->source_destination == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                </div>

                                <!-- Field to enter money source when 'Other' is selected -->
                                <div class="form-group" id="otherField2"
                                    style="{{ $pettyCashEdit->source_destination == 'other' ? 'display:block;' : 'display:none;' }}">
                                    <label>Other money destination:</label>
                                    <input type="text" name="othersource_destination" class="form-control"
                                        value="{{ $pettyCashEdit->othersource_destination ?? '' }}"
                                        placeholder="Enter money source">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="control-label">Date</label>
                                <input type="date" name="date" class="form-control"
                                    value="{{ $pettyCashEdit->date }}" id="recipient-name1" required>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Amount</label>
                                <input type="number" step="any" name="amount" class="form-control"
                                    value="{{ $pettyCashEdit->amount }}" id="recipient-name1" required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="control-label">Description</label>
                                <textarea name="description" class="form-control" id="description" rows="3" required>{{ $pettyCashEdit->description }}</textarea>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function setProductionDate(button) {
            var productionDate = button.getAttribute('data-date');
            document.getElementById('productionDate').value = productionDate;
            // Now submit the form or trigger the event to update the data
            document.getElementById('editform');
        }
    </script>

    <script>
        $(document).ready(function() {
            $('#source_desitination1').change(function() {
                if ($(this).val() == 'other') {
                    $('#otherField').show();
                } else {
                    $('#otherField').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#source_desitination2').change(function() {
                if ($(this).val() == 'other') {
                    $('#otherField2').show();
                } else {
                    $('#otherField2').hide();
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#type').change(function() {
                if ($(this).val() == 'income') {
                    $('#income').show();
                    $('#expenditure').hide();
                } else {
                    $('#expenditure').show();
                    $('#income').hide();
                }


            });
        });
    </script>

    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                // "buttons": ["copy", "csv", "excel"],
                "scrollX": true // Add this line to enable horizontal scrolling
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
