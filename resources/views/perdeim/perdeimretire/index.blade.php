@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="message"></div>
        <div class="row page-titles">
            <div class="container-fluid">
                <div class="header-body ml-3">
                    <div class="row align-items-end">
                        <div class="col">
                            <h1 class="header-title">
                                Perdeim Retirement
                            </h1>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid mt-4">
            <div class="row m-b-10">
                <div class="col-12">
                    <button type="button" class="btn btn-info"><i class="fa fa-plus"></i><a data-toggle="modal"
                            data-target="#loanmodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Add Allowance Retire </a></button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 "> Perdeim Retirement
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="loan123" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>


                                            <th>Amount Used </th>
                                            <th>File Title</th>
                                            <th>Proof</th>
                                            <th>Status</th>
                                            <th>Action</th>

                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($perdeim as $perdeims)
                                            <tr>

                                                <td>{{ $perdeims->amount_used }}</td>
                                                <td>{{ $perdeims->file_title }}</td>
                                                <td><a href="{{ route('retire.download', $perdeims->id) }}"
                                                        target="_blank">download</a></td>
                                                <td>
                                                    @if (is_null($perdeims->statusManager))
                                                        <span class="p-2 mb-1 bg-primary text-white">Pending</span>
                                                    @elseif($perdeims->statusManager == 1)
                                                        <span class="p-2 mb-1 bg-success text-white">Approved by the Manager</span>
                                                        @if (is_null($perdeims->statusDr))
                                                            
                                                        @elseif($perdeims->statusDr == 1)
                                                            <span class="p-2 mb-1 bg-success text-white">Approved by the Director</span>
                                                            
                                                        @else
                                                            <span class="p-2 mb-1 bg-danger text-white">Rejected by the Director</span>
                                                            
                                                        @endif
                                                    @else
                                                        <span class="p-2 mb-1 bg-danger text-white">Rejected by the Manager</span>
                                                    @endif
                                                </td>

                                                <td class="d-flex">
                                                    @if (isset($perdeims->statusManager) || isset($perdeims->statusDr))
                                                    @else
                                                        <a href="{{ route('perdeimretire.edit', $perdeims->id) }}"
                                                            class="btn btn-primary">Edit</a>
                                                        <form action="{{ route('perdeimretire.destroy', $perdeims->id) }}"
                                                            method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="ml-4 btn btn-danger" type="submit"
                                                                onclick="return confirm('Are you sure  you want to delete?')">Delete</button>
                                                            <?= csrf_field() ?>
                                                        </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- sample modal content -->
        <div class="modal fade" id="loanmodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header">
                        <h4 class="modal-title" id="exampleModalLabel1">Add Retirement</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                    <form role="form" method="post" action="{{ route('perdeimretire.store', $perdeim_id) }}"
                        id="loanvalueform" enctype="multipart/form-data">

                        <div class="modal-body">

                            <input hidden="hidden" type="text" name="perdeim_id" class="form-control form-control-line"
                                value="{{ $perdeim_id }}" placeholder=" Degree Name" minlength="1" required>

                            <div class="form-group">
                                <label for="message-text" class="control-label">Amount Used</label>
                                <input type="number" name="amount_used" class="form-control" id="recipient-name1">
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="balance" class="form-control mydatetimepickerFull"
                                    id="recipient-name1" required>
                            </div>

                            <div class="form-group">
                                <label for="message-text" class="control-label">File Title</label>
                                <input type="text" name="title" class="form-control" id="recipient-name1" required>
                            </div>
                            <div class="form-group">
                                <label for="message-text" class="control-label">Proof</label>
                                <input type="file" name="file_url" class="form-control" id="recipient-name1" required>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="loanid" value="">
                            <input type="hidden" name="id" value="">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>

                        <?= csrf_field() ?>
                    </form>
                </div>
            </div>
        </div>
        <!-- /.modal -->


        <script>
            $(document).ready(function() {
                $('.js-example-basic-single ').select2({
                    dropdownParent: $("#loanmodel")
                });
            });
        </script>
    @endsection
