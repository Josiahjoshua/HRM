@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            {{ $balanceSheet->category_name }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Balance sheet</li>
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
                            Items

                    </div>
                </div>

        </section>
        <div class="card">
            <div class="card-body">
                <section class="content mt-2">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="card" style="background-color:#f4f6f9;">
                                    <div class="card-header">
                                        <h3 class="card-title">List of details</h3>
                                    </div>
                                    <div class="card-body">
                                        <table id="products_table" class="table table-bordered table-striped"
                                            id="example1">
                                            <thead>
                                                <tr>
                                                    <th>Item</th>
                                                    <th>Amount</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($balanceSheetItem as $items)
                                                    <tr>
                                                        <td>{{ $items['item'] }}</td>
                                                        <td>{{ number_format($items['amount']) }}</td>

                                                        <td>
                                                            <div class="btn-group">
                                                                @if($balanceSheet->category_name !== 'Current Assets' && $balanceSheet->category_name !== 'Fixed Assets')
                                                                <a href="{{ route('balanceSheetItems.edit', $items['id']) }}"
                                                                    class="btn btn-primary mr-2">Edit</a>

                                                                <form
                                                                    action="{{ route('balanceSheetItems.destroy', $items['id']) }}"
                                                                    method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button class="btn btn-danger" type="submit"
                                                                        onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                                                </form>
                                                                @else
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
                </section>
            </div>
        </div>



        <div>

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Add Item</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" action="{{ route('balanceSheetItems.store') }}"
                                id="loanvalueform" enctype="multipart/form-data">
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

                                <input type="hidden" name = "category_id" value="{{ $balanceSheet->id }}">


                                <div class="form-group">
                                    <label class="control-label">Item</label>
                                    <input type="text" name="item" value="" class="form-control"
                                        id="recipient-name1">
                                </div>

                                <div class="form-group">
                                    <label class="control-label">Amount</label>
                                    <input type="number" step="any" name="amount" value="" class="form-control"
                                        id="recipient-name1">
                                </div>


                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <script>
        // Initialize Select2 for the select element with class "select2"
        $(document).ready(function() {
            $('.select2').select2();
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
