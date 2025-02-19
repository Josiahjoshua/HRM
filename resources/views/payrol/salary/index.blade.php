@extends('layouts.app')

@section('content')
    <div class="content-wrapper">
        <div class="message"></div>
        <div class="row page-titles">
            <div class="header">
                <div class="container-fluid">
                    <div class="header-body ml-3">
                        <div class="row align-items-end">
                            <div class="col">
                                <h1 class="header-title">
                                    Payroll
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            {{-- <div class="row m-b-10">
                <div class="col-12 text-right">
                    <button type="button" class="btn btn-info"><i class="fe fe-plus"></i><a data-toggle="modal"
                            data-target="#leavemodel" data-whatever="@getbootstrap" class="text-white"><i class=""
                                aria-hidden="true"></i> Generate Payroll</a></button>
                    <!-- <button type="button" class="btn btn-primary"><i class="fe fe-printer"></i><a href="{{ route('payrol.create') }}" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payroll</a></button>-->
                    <!-- <button type="button" class="btn btn-info"><i class="fe fe-printer"></i><a href="{{ route('payrol.create') }}" class="text-white"><i class="" aria-hidden="true"></i>  Generate Payslip</a></button>
                       -->
                </div>
            </div> --}}
            <div class="row mt-4">
                <div class="col-12">

                    <div class="card card-outline-info">
                        <div class="card-header">
                            <h4 class="m-b-0 text-white"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payroll
                                List
                            </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive ">
                                <table id="example123" class="display nowrap table table-hover table-striped table-bordered"
                                    cellspacing="0" width="100%">
                                    <thead>
                                        <tr>

                                            <th>Month</th>
                                            <th>Total Salaries</th>
                                            <th>Total Benefits</th>
                                            <th>Total Workovertimes</th>
                                            <th>Total Deductions</th>
                                            <th>Total Net Salaries</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach ($payroll as $payrollData)
                                        <tr>
                                            <td>
                                                @if(is_object($payrollData) && property_exists($payrollData, 'month'))
                                                    {{ $payrollData->month }}
                                                @else
                                                    {{ $payrollData }} <!-- Display the month string -->
                                                @endif
                                            </td>
                                            
                                            <td>
                                                @if(is_object($payrollData))
                                                    {{ number_format($payrollData->total_salaries) }}
                                                @else
                                                    0 <!-- Display 0 if no data for the month -->
                                                @endif
                                            </td>
                                            <td>
                                                @if(is_object($payrollData))
                                                    {{ number_format($payrollData->total_benefits) }}
                                                @else
                                                    0 <!-- Display 0 if no data for the month -->
                                                @endif
                                            </td>
                                            <td>
                                                @if(is_object($payrollData))
                                                    {{ number_format($payrollData->total_workovertimes) }}
                                                @else
                                                    0 <!-- Display 0 if no data for the month -->
                                                @endif
                                            </td>
                                            <td>
                                                @if(is_object($payrollData))
                                                    {{ number_format($payrollData->total_deductions) }}
                                                @else
                                                    0 <!-- Display 0 if no data for the month -->
                                                @endif
                                            </td>
                                            <td>
                                                @if(is_object($payrollData))
                                                    {{ number_format($payrollData->total_salaries + $payrollData->total_benefits + $payrollData->total_workovertimes - $payrollData->total_deductions) }}
                                                @else
                                                    0 <!-- Display 0 if no data for the month -->
                                                @endif
                                            </td>
                                                <td>
                                                    @if(is_object($payrollData))
                                                   {{-- 
                                                    <a href="{{ route('payrol.show', $payrolls->id) }}" title="compute"
                                                        class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp"
                                                        data-id="<?php echo $payrolls->id; ?>">View Payslips</a> --}}

                                                        <a href="{{ route('monthlyEmployeePayrol', ['month' => $payrollData->month]) }}" title="compute"
                                                            class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp">View Payroll</a>
                                                            @endif
                                                        
                                                </td>

                                            </tr>

                                            @endforeach
                                    </tbody>

                                </table>
                                </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="leavemodel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                    <div class="modal-content ">
                        <div class="modal-header">
                            <h4 class="modal-title" id="exampleModalLabel1">Generate Payroll</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                        <form method="post" ction="{{ route('payrol.store') }}" id="leaveform"
                            enctype="multipart/form-data">
                            <div class="modal-body">

                                <!-- <div class="form-group">
                                    <label class="control-label">month</label>
                                    <input type="month" name="month" class="form-control" id="recipient-name1" value="">
                                </div> -->
                                <div class="form-group">
                                    <label class="control-label">month</label>
                                    <input type="month" name="month" class="form-control" id="recipient-name1"
                                        value="">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="id" value="" class="form-control"
                                    id="recipient-name1">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <?= csrf_field() ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection
