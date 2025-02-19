@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Bank Out Details for {{ $bank->bank_name }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Bank</li>
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
                        Expenditure</button>
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
                                <h3 class="card-title">List of Bank Expenditure</h3>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="text-nowrap">
                                            <th>Date</th>
                                            <th>Bank</th>
                                            <th>Amount</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($bankOut as $products)
                                            <tr class="text-nowrap">
                                                <td>{{ $products->date }}</td>
                                                <td>{{ $products->bank->bank_name }}</td>
                                                <td>{{ number_format($products->amount, 2) }}</td>

                                                <td>
                                                    <div class="d-flex">


                                                        <button class="view-materials btn btn-info mr-2" data-toggle="modal"
                                                            data-target="#EditMaterialTaken{{ $products->id }}"
                                                            onclick="setProductionDate(this)"
                                                            data-date="{{ $products->id }}">
                                                            Edit
                                                        </button>

                                                        <form action="{{ route('bankOutDelete', $products->id) }}"
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
                    <form role="form" method="post" action="{{ route('bankOutStore') }}" id="loanvalueform"
                        enctype="multipart/form-data">

                       

                        <input type="hidden" name="bank_id" value="{{ $bank->id }}">

                        <div class="form-group">
                            <label for="message-text" class="control-label">Amount</label>
                            <input type="number" step="any" name="amount" class="form-control" id="recipient-name1"
                                required>
                        </div>

                        <div class="form-group">
                            <label>To</label>
                            <select name="destination" class="form-control custom-select" id="destination" aria-placeholder="select product unit">
                                <option value="cash">Cash in hand</option>
                                <option value="pettyCash">Petty Cash</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                        
                        <!-- Field to enter money source when 'Other' is selected -->
                        <div class="form-group" id="otherField" style="display: none;">
                            <label>Other money source:</label>
                            <input type="text" name="otherSource" class="form-control" placeholder="Enter money source">
                        </div>
                        
                        <script>
                        $(document).ready(function() {
                            $('#destination').change(function() {
                                if ($(this).val() == 'other') {
                                    $('#otherField').show();
                                } else {
                                    $('#otherField').hide();
                                }
                            });
                        });
                        </script>
                        <div class="form-group">
                            <label for="message-text" class="control-label">Date</label>
                            <input type="date" name="date" class="form-control" id="recipient-name1" required>
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

    @foreach ($bankOut as $products)
        <div class="modal fade" id="EditMaterialTaken{{ $products->id }}" tabindex="-1" role="dialog"
            aria-labelledby="EditMaterialTaken{{ $products->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Bank Out Details</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="bank_id" id="productionDate" value="{{ $products->id }}">

                        @php
                            $id = $products->id;

                            $materialTaken = \App\Models\BankOut::find($id);

                        @endphp

                        <form role="form" method="post" action="{{ route('bankOutUpdate', $id) }}" id="editform">
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
                                <input type="date" name="date" value="{{ $materialTaken->date }}"
                                    class="form-control" id="recipient-name1" required>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Amount</label>
                                <input type="number" step="any" name="amount"
                                    value="{{ $materialTaken->amount }}" class="form-control" id="recipient-name1"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Destination</label>
                                <select name="destination" class="form-control custom-select" id="destination2"
                                    aria-placeholder="select product unit" required>
                                    <option value="cash" @if ($materialTaken->destination == 'cash') selected @endif>Cash in hand
                                    </option>
                                    <option value="pettyCash" @if ($materialTaken->destination == 'pettyCash') selected @endif>Petty Cash
                                    </option>
                                    <option value="other" @if ($materialTaken->destination == 'other') selected @endif>Other</option>
                                </select>
                            </div>

                            <div class="form-group" id="otherField2"
                                @if (!$materialTaken || $materialTaken->destination != 'other') style="display: none;" @endif>
                                <label>Other money destination:</label>
                                <input type="text" name="otherSource" class="form-control"
                                    placeholder="Enter money destination" value="{{ $materialTaken->otherSource ?? '' }}">
                            </div>


                            <script>
                                $(document).ready(function() {
                                    $('#destination2').change(function() {
                                        if ($(this).val() == 'other') {
                                            $('#otherField2').show();
                                        } else {
                                            $('#otherField2').hide();
                                        }
                                    });
                                });
                            </script>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
