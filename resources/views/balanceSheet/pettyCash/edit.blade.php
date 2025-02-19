@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Petty Cash</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Petty Cash</li>
                            <li class="breadcrumb-item">
                                <button class="btn btn-primary" onclick="goBack()">Go Back</button>
                                <script>
                                    function goBack() {
                                        window.history.back();
                                    }
                                </script>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-9">
                        <div class="card card-primary">

                            <div class="modal-header">

                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">


                                <form role="form" method="post"
                                    action="{{ route('pettyCash.update', $pettyCashEdit->id) }}" id="loanvalueform"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="type" class="form-control custom-select" id="type"
                                            aria-placeholder="select product unit" @readonly(true)>
                                            <option value="income" {{ $pettyCashEdit->type == 'income' ? 'selected' : '' }}>
                                                Income</option>
                                            <option value="expenditure"
                                                {{ $pettyCashEdit->type == 'expenditure' ? 'selected' : '' }}>Expenditure
                                            </option>
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
                                                <option value="other"
                                                    {{ $pettyCashEdit->source_destination == 'other' ? 'selected' : '' }}>Other
                                                </option>
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_name }}"
                                                        {{ $pettyCashEdit->source_destination == $bank->bank_name ? 'selected' : '' }}>
                                                        {{ $bank->bank_name }}</option>
                                                @endforeach
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
                                                @foreach ($banks as $bank)
                                                    <option value="{{ $bank->bank_name }}"
                                                        {{ $pettyCashEdit->source_destination == $bank->bank_name ? 'selected' : '' }}>
                                                        {{ $bank->bank_name }}</option>
                                                @endforeach
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
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

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
@endsection
