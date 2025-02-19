@extends('layouts.app')

@section('content')
<div class="content-wrapper">
        <div class="message"></div>
        <div class="row page-titles">
            <div class="container-fluid">
                <div class="header-body ml-3">
                    <div class="row align-items-end">
                        <div class="col">
                            <div class="header-title">
                               <p>Asset Name: <b>{{ $asset_list->asset_name}} </b> </p> 
                               <p>Asset Purchase Date:<b> {{ $asset_list->purchase_date}}</b> </p> 
                              <p>  Asset Purchase Price: <b> {{number_format($asset_list->price)}}</b> </p> 
                               <p> Depriciation Rate: <b> {{ $asset_list->depr_rate}}% </b> per Year</p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0"> Assets Depreciation History</h4>
                            <div style="float: right">
                                <a href="{{ route('assetlist.add.depreciation', $asset_list->id) }}"
                                    class="btn btn-info">Check Depreciations</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                   <thead>
    <tr>
        <th>As On</th>
        <th>Depreciation Value</th>
        <th>Market Value</th>
    </tr>
</thead>
<tbody>
    @php
        $currentMarketValue = $asset_list->price; // Initialize current market value with the initial market value
    @endphp

    @foreach ($asset_list->depreciations as $depreciation)
        @php
            $depreciatedValue = $depreciation->depreciated_value;
            $currentMarketValue -= $depreciatedValue; // Subtract depreciation value from current market value
        @endphp
        <tr>
            <td>{{ $depreciation->date }}</td>
            <td>{{ number_format($depreciatedValue, 2, '.', ',') }}</td>
            <td>{{ number_format($currentMarketValue, 2, '.', ',') }}</td>
        </tr>
    @endforeach
</tbody>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @push('scripts')
                <script>
                    $(document).ready(function() {
                        var table = $('#example').DataTable({
                            lengthChange: false,
                            ordering: false,
                            buttons: ['copy', 'excel', 'pdf', 'colvis']
                        });

                        table.buttons().container()
                            .appendTo('#example_wrapper .col-md-6:eq(0)');
                    });
                </script>
            @endpush
        @endsection
