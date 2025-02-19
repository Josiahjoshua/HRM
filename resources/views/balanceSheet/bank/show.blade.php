@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>
                            Cattles in {{ $batch->batch_name }}
                        </h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Feedlot</li>
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
            </div>
               @can('Update cattle-batch')
                <div class="col-sm-6">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default"> Add cattle
                        to batch</button>
                </div>
            @endcan
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">List of Cattles In the Feedlot</h3>
                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tag No</th>
                                            <th>Entered</th>
                                            <th>Exit</th>
                                            <th>Initial weight</th>
                                            <th>Current weight</th>
                                            <th>Weight gain</th>
                                            <th>Feed Cost</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($batchCattle as $cattle)
                                        <tr class="text-nowrap">
                                                <td>{{ $cattle->tag }}</td>
                                                <td>{{ $cattle->batch_enter_date }}</td>
                                                <td>{{ $cattle->batch_exit_date }}</td>
                                                <td>{{ $cattle->weight }}</td>
                                                <td>{{ $cattle->current_weight }}</td>
                                                <td>{{ $cattle->current_weight - $cattle->weight }}</td>
                                                <td>{{ number_format($cattle->feed_cost, 2) }}</td>
                                                <td><div class="d-flex">
                                                    @can('Update cattle-batch')
                                                    <button class="view-exit_date-modal btn btn-info mr-2"
                                                    data-toggle="modal" data-asset="{{ $cattle->id }}"
                                                    data-asset-id="{{ $cattle->id }}"
                                                    data-target="#ReturnModal"
                                                    onclick="setAssetIdReturn(this)">
                                                Exit date
                                                </button>
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
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Assign Cattle to Batch </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" method="POST" action="{{ route('cattleBatchAssign') }}" id="loanvalueform"
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
                        <input type="hidden" name="batch_id" value="{{ $batch->id }}">

                        <div id="cattle">
                            <div class="form-repeater">
                                <div class="form-group form-group-repeater">
                                    <div class="form-group row d-flex justify-content-center align-items-center mt-3">
                                        <div class="col-md-4">
                                            <label class="control-label">Select cattle</label>
                                            <!-- HTML -->
                                            <input type="text" list="cattleList" class="form-control" name="tag[]"
                                                placeholder="Select Cattle">
                                            <datalist id="cattleList">
                                                <!-- Options -->
                                                @foreach ($cattleAdded as $cattles)
                                                    <option value="{{ $cattles->tag }}">{{ $cattles->tag }}</option>
                                                @endforeach
                                            </datalist>

                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Date:</label>
                                            <input class="form-control" type="date" name="batch_enter_date[]" required
                                                placeholder="Enter weight">
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger repeater-remove">Delete</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-group row d-flex justify-content-center align-items-center mt-2">

                                        <button type="button" class="btn btn-primary repeater-add">Add
                                            More</button>

                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                        <?= csrf_field() ?>
                    </form>
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
                        <h5 class="modal-title" id="ReturnModal">Add Exit Date</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="POST" action="{{ route('exitDate') }}" id="loanvalueform"
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
                            <input type="hidden" id="asset_id_input_return" name="cattle_id" value="">
                            <div class="modal-body">
                                <div class="form-group">
                                    <label class="control-label">Exit Date </label>
                                    <input type="date" name="batch_exit_date" id="example-email2" class="form-control"
                                        placeholder="" required>
                                </div>

                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
    <script>
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>

<script>
    function setAssetIdReturn(button) {
        var assetId = button.getAttribute('data-asset-id');
        document.getElementById('asset_id_input_return').value = assetId;
    }
</script>


    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["excel"]
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

@endsection
