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
            Payslip View
                       </h1>
                    </div>
                </div> 
            </div> 
        </div>
    </div>
            </div>

            <div class="container-fluid">
                <div class="row mt-4">
                    <div class="col-12">
                       <div class="card card-outline-info">
                         <div class="card-header">
                                <h4 class="m-b-0 text-black"><i class="fa fa-hourglass-start" aria-hidden="true"></i> Payslip list  of month {{$payroll->month}}                
                                </h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table id="example123" class="display nowrap table table-hover table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>

                                                <th>Employee Name</th>
                                                <th>Salary</th>
                                                <th>Allowance Amount</th>
                                                <th>Deductions Amount</th>
                                                <th>Net Pay</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>
                                     
                                   

                                        @foreach( $payslip as $payslips)
                                <tr>

                                <td>{{$payslips->user->name}}</td>
                                <td>{{$payslips->salary}}</td>
                                <td>{{$payslips->allowance_amount}}</td>
                                <td>{{$payslips->deduction_amount}}</td>
                                <td>{{$payslips->net_pay}}</td>






                                    <td>
                            
                                           <a href="{{ route('payrol.payslip', $payslips->id)}}" title="compute" class="m-2 btn btn-sm btn-info waves-effect waves-light leaveapp" data-id="<?php echo $payslips->id; ?>" > view payslip</a>
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
                        
               
        </div>
    </div> 

@endsection