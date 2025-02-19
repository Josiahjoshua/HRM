@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="row page-titles">
            <div class="container-fluid">
                <div class="header-body ml-3">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Furniture Assets
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#assetsmodel"
                        data-whatever="@getbootstrap"><i class="fe fe-plus"></i>
                        <a class="text-white"><i class="" aria-hidden="true"></i> Add Assets </a>
                    </button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0"> Assets List</h4>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>

                                            <th>Name </th>
                                            <th>Serial Number </th>
                                            <th>Price </th>
                                            <th>Action </th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($assetlist as $value)
                                            <tr>
                                                <td>{{ $value->asset_name }}</td>
                                               <td>{{ $value->asset_code }}</td>
                                                <td>{{ number_format($value->price) }}</td>


                                                <td>

                                                    <div class="d-flex">
                                                        @can('Update asset')
                                                            @if ($value->statusSale == 1)
                                                                <span class="text-info mr-2">Sold on {{ $value->sale_date }} for
                                                                    {{ number_format($value->sale_price) }}</span>
                                                            @elseif ($value->statusSale == 2)
                                                                <span class="text-info mr-2">Retained on
                                                                    {{ $value->sale_date }}</span>
                                                            @else
                                                                @if ($value->statusAssign == 1)
                                                                    <span class="text-success mr-2">Assigned to
                                                                        {{ $value->user->name }}</span>
                                                                    <button class="view-return-modal btn btn-info mr-2"
                                                                        data-toggle="modal" data-asset="{{ $value->id }}"
                                                                        data-asset-id="{{ $value->id }}"
                                                                        data-target="#ReturnModal"
                                                                        onclick="setAssetIdReturn(this)">
                                                                        Return
                                                                    </button>
                                                                @else
                                                                    <button class="view-assign-modal btn btn-success mr-2"
                                                                        data-toggle="modal" data-asset="{{ $value->id }}"
                                                                        data-asset-id="{{ $value->id }}"
                                                                        data-target="#AssignToEmployerModal"
                                                                        onclick="setAssetIdAssign(this)">
                                                                        Assign to Employer
                                                                    </button>
                                                                @endif

                                                                <button class="view-retain-modal btn btn-secondary mr-2"
                                                                    data-toggle="modal" data-asset="{{ $value->id }}"
                                                                    data-asset-id="{{ $value->id }}"
                                                                    data-target="#RetainModal" onclick="setAssetIdRetain(this)">
                                                                    Retain
                                                                </button>


                                                                <button class="view-sale-modal btn btn-warning mr-2"
                                                                    data-toggle="modal" data-asset="{{ $value->id }}"
                                                                    data-asset-id="{{ $value->id }}"
                                                                    data-target="#SaleModal" onclick="setAssetId(this)">
                                                                    Sale
                                                                </button>
                                                            @endif
                                                        @endcan


                                                        @can('check depreciation')
                                                            <a href="{{ route('assetlist.view.depreciation', $value->id) }}"
                                                                class="btn btn-info mr-2">View Depreciations</a>
                                                        @endcan
                                                        @can('Edit asset')
                                                            @if ($value->statusAssign >= 1 || $value->statusSale >= 1)
                                                            @else
                                                                <div class="btn-group">
                                                                    <a href="{{ route('assetlist.edit', $value->id) }}"
                                                                        class="btn btn-primary mr-2">Edit</a>

                                                                    <form action="{{ route('assetlist.destroy', $value->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button class="btn btn-danger" type="submit"
                                                                            onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                                                    </form>
                                                                </div>
                                                            @endif
                                                        @endcan
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


                <div>
                    <div class="modal fade" id="SaleModal" tabindex="-1" role="dialog" aria-labelledby="SaleModal"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="SaleModal">Add Asset to sold Assets List</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form role="form" method="POST" action="{{ route('assetSale') }}"
                                        id="loanvalueform" enctype="multipart/form-data">
                                        @if ($errors->any())
                                            <div class="alert alert-danger">
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif

                                        <input type="hidden" id="asset_id_input" name="asset_id" value="">
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label class="control-label">Date of Sale </label>
                                                <input type="date" name="sale_date" id="example-email2"
                                                    class="form-control" placeholder="" required>
                                            </div>
                                            <div class="form-group">
                                                <label class="control-label">Sale Price </label>
                                                <input type="number" name="sale_price" step="any"
                                                    id="example-email2" class="form-control" placeholder="" required>
                                            </div>

                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default"
                                                    data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Sale</button>
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

        <div class="modal fade" id="assetsmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add Asset </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form method="post" action="{{ route('assetlist.store') }}" id="btnSubmit"
                        enctype="multipart/form-data">
                        <div class="modal-body">
                            <div class="row">

                                <input type="hidden" id="asset_id" name="asset_id" value="{{$ass->id}}">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Asset name</label>
                                        <input type="text" name="asset_name" value="" class="form-control"
                                            id="recipient-name1" required>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label">Assets Serial Number</label>
                                        <input type="text" name="code" value="" class="form-control"
                                            id="recipient-name1 ">
                                    </div>
                                </div>
                              
                                    <div class="form-group">
                                        <label class="control-label">Purchaseing Date</label>
                                        <input type="date" name="purchase" value=""
                                            class="form-control mydatepicker" id="recipient-name1" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Price</label>
                                        <input type="number" name="price" value="" class="form-control"
                                            id="recipient-name1" required>
                                    </div>

                                </div>
                           
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Depreciation Interval</label>
                                        <select name="depr_interval" value=""
                                            class="select2 form-control custom-select" style="width: 100%" required
                                            value="">
                                            <option value="">Select Depreciation Interval</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                        </select>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label">Depreciation Rate (%)</label>
                                        <input type="number" step="0.01" min="0" name="depr_rate" required
                                            class="form-control mydatepicker" id="recipient-name1">
                                    </div>
                                </div>
                            </div>
                            <!--
                                                                        <div class="form-group">
                                                                            <input name="type" type="checkbox" id="radio_2" data-value="Logistic" value="Logistic" class="type">
                                                                            <label for="radio_2">Add To Logistic Support List</label>
                                                                        </div>-->
                     </div>
                   
                        <div class="modal-footer">
                            <input type="hidden" name="aid" value="">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>

        <div>
            <div class="modal fade" id="AssignToEmployerModal" tabindex="-1" role="dialog"
                aria-labelledby="AssignToEmployerModal" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AssignToEmployerModal">Assign to Employer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="POST" action="{{ route('employeeAsset.store') }}"
                                id="loanvalueform" enctype="multipart/form-data">
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <input type="hidden" id="asset_id_input_assign" name="asset_id" value="">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label class="control-label">Date of Assign </label>
                                        <input type="date" name="assign_date" id="example-email2"
                                            class="form-control" placeholder="" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label">Employee Name </label>
                                        <select name="employee_id" class="select2 form-control" style="width: 100%"
                                            required value="">
                                            <option value="">Select Employee Name</option>
                                            @foreach ($employees as $employee)
                                                <option value="{{ $employee->id }}"> {{ $employee->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default"
                                            data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Assign</button>
                                    </div>
                                    <?= csrf_field() ?>
                            </form>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="modal fade" id="RetainModal" tabindex="-1" role="dialog" aria-labelledby="RetainModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="RetainModal">Retain Asset</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="{{ route('assetRetain') }}" id="loanvalueform"
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
                            <input type="hidden" id="asset_id_input_retain" name="asset_id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Retain Date </label>
                                    <input type="date" name="sale_date" id="example-email2" class="form-control"
                                        placeholder="" required>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Retain</button>
                                </div>
                                <?= csrf_field() ?>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
    </div>

    <div>
        <div class="modal fade" id="ReturnModal" tabindex="-1" role="dialog" aria-labelledby="ReturnModal"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ReturnModal">Return to stock</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="{{ route('assetReturn') }}" id="loanvalueform"
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
                            <input type="hidden" id="asset_id_input_return" name="asset_id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Date of Return </label>
                                    <input type="date" name="return_date" id="example-email2" class="form-control"
                                        placeholder="" required>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Assign</button>
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
        function setAssetId(button) {
            // Get the asset_id from the clicked button's data-asset-id attribute
            var assetId = button.getAttribute('data-asset-id');

            // Set the asset_id in the hidden input field in the modal
            document.getElementById('asset_id_input').value = assetId;
        }
    </script>

    <script>
        function setAssetIdRetain(button) {
            var assetId = button.getAttribute('data-asset-id');
            document.getElementById('asset_id_input_retain').value = assetId;
        }
    </script>

    <script>
        function setAssetIdReturn(button) {
            var assetId = button.getAttribute('data-asset-id');
            document.getElementById('asset_id_input_return').value = assetId;
        }
    </script>

    <script>
        function setAssetIdAssign(button) {
            var assetId = button.getAttribute('data-asset-id');
            document.getElementById('asset_id_input_assign').value = assetId;
        }
    </script>




@endsection
