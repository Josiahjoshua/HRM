@extends('layouts.app')

@section('content')
<div class="content-wrapper">
<div class="row m-b-10"> 
                    <div class="col-12 text-right">
                    <button type="button" class="btn btn-info"><i class="fe fe-print"></i><a href="{{route('download.payslip', $payslip->id)}}" class="text-white"><i class="" aria-hidden="true"></i>download Payslip</a></button>
                    </div>
                </div> 
<div class="container mt-5 mb-5">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center lh-1 mb-2">
                <h6 class="fw-bold">Payslip</h6> <span class="fw-normal">Payment slip for the month of {{$payslip->payroll->month}}</span>
            </div>
            <div class="d-flex justify-content-end"> <span>Company Name: Ark</span> </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-6">
                            <div> <span class="fw-bolder">EMP Code</span> <small class="ms-3">{{$employeeId->em_code}}</small> </div>
                        </div>
                        <div class="col-md-6">
                            <div> <span class="fw-bolder">EMP Name</span> <small class="ms-3">{{$employeeId->name}}</small> </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div> <span class="fw-bolder">PS No.</span> <small class="ms-3">{{$payslip->id}}</small> </div>
                        </div>
                       
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div> <span class="fw-bolder">Designation</span> <small class="ms-3">{{$employeeId->des_name}}</small> </div>
                        </div>
                        {{-- <div class="col-md-6">
                            <div> <span class="fw-bolder">Ac No. </span> <small class="ms-3">{{$payslip->employee->bank_info->account_number}}</small> </div>
                        </div> --}}
                    </div>
                </div>
                <table  class="mt-4  display nowrap table table-hover table-striped table-bordered">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th scope="col">Earnings</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Deductions</th>
                            <th scope="col">Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">Basic Salary</th>
                            <td>{{$payslip->salary}}</td>
                            <th>
                            @foreach ($payslip->deductions as $deduction)
                              <p>{{$deduction->deduction_name}}</p>
                            @endforeach
                            </th>

                            <td>
                            @foreach ($payslip->deductions as $deduction)
                            <p> {{$deduction->amount}}</p>
                            @endforeach
                            </td>

                        </tr>
                        
                        <tr>
                            <th>
                            @foreach ($payslip->benefits as $benefit)
                              <p>{{$benefit->benefit_name}}</p>
                            @endforeach
                            </th>

                            <td>
                            @foreach ($payslip->benefits as $benefit)
                            <p> {{$benefit->amount}}</p>
                            @endforeach
                            </td>
                            
                        </tr>
                        <tr class="border-top">
                            <th scope="row">Total Earning</th>
                            <td>{{$payslip->allowance_amount + $payslip->salary}}</td>
                            <td>Total Deductions</td>
                            <td>{{$payslip->deduction_amount}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="row">
                <div class="col-md-4"> <br> <span class="fw-bold">Net Pay : {{$payslip->net_pay}}</span> </div>
            </div>
            <div class="d-flex justify-content-end">
                <div class="d-flex flex-column mt-2"> <span class="fw-bolder">For {{$employeeId->name}}</span> <span class="mt-4">Authorised Signatory</span> </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
