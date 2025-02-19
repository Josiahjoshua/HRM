@extends('layouts.app')

@section('content')

<!-- admin-dashboard -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3> <?= $employee?? '' ?></h3>
                            <p>Employees</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-user"></i>
                        </div>
                        <a href="{{route('employee.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                                <div class="col-lg-3 col-6">
                    <div class="small-box bg-indigo">
                        <div class="inner">
                            <h3> <?= $asset?? '' ?></h3>
                            <p>Assets</p>
                        </div>
                        <div class="icon">
                            <i class="nav-icon fas fa-tools"></i>
                        </div>
                        <a href="{{route('assetlist.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                
                     <div class="col-lg-3 col-6">
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3> <?= $leave?? '' ?></h3>
                            <p>Leaves</p>
                        </div>
                        <div class="icon">
                           <i class="nav-icon fas fa-calendar"></i>

                        </div>
                        <a href="{{route('leave.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>


            </div>
            
        </div>
 @endsection