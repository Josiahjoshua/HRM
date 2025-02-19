@include('layouts.head')
@include('sweetalert::alert')
<div class="wrapper">
    <nav class="main-header navbar navbar-expand navbar-white navbar-light" style="height: 100px;">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ route('home') }}" class="nav-link">Home</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">

            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown mb-4">
                
                <a class="nav-link" data-toggle="dropdown" href="{{ route('home') }}">
                    <img src="{{ asset('assets/'. Auth::user()->profile_picture) }}" alt="Profile Picture"
                        style="border-radius: 50%; width: 70px; height: 65px; text-align: center;">
                </a>
                
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <img src="{{ asset('assets/'. Auth::user()->profile_picture) }}" data-src="{{ asset('storage/assets/images/'. Auth::user()->profile_picture) }}" class="mx-auto d-block"
                        alt="Profile Picture" style="border-radius: 100%; width: 100px; height: 100px;"><br>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal"
                        data-target="#changePasswordModal">Change
                        Password</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#updateProfileModal">Update
                        Profile</a>

                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                        style="color: red;">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </a>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>

            </li>
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span id="notification_badge" class="badge badge-warning navbar-badge"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">Notifications</span>
                    <div class="dropdown-divider"></div>
                    <div id="notification_body">
                    </div>
                    <a href="#" id="read_all_notification" class="dropdown-item dropdown-footer">See All
                        Notifications</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true"
                    href="{{ route('home') }}" role="button">
                    <i class="fas fa-th-large"></i>
                </a>
            </li>

        </ul>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <div class="sidebar" style="overflow-y: scroll;">
            <a href="{{ route('home') }}" class="brand-link">
                <img src="/dist/img/pejunlogo.png" alt="Logo" class="img-square "
                    style="width: 220px; height: 150px;">

            </a>

            <!-- Sidebar -->

            <!-- Sidebar user panel (optional) -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img src="/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
                </div>
                <div class="info">
                    <a href="{{ route('home') }}" class="d-block">{{ Auth::user()->name }}</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    @can('View Dashboard')
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="nav-icon fas fa-home"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                    @endcan
                    @canany(['View user', 'View role'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    User-management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('View user')
                                    <li class="nav-item">
                                        <a href="{{ route('users.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>users</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('View role')
                                    <li class="nav-item">
                                        <a href="{{ route('roles.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>roles</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>

                    @endcan
                    @canany(['View Department', 'View Designation'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-building"></i>
                                <p>
                                    Organization
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('View Department')
                                    <li class="nav-item">
                                        <a href="{{ route('department.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Departments</p>
                                        </a>
                                    </li>
                                @endcan
                                @can('View Designation')
                                    <li class="nav-item">
                                        <a href="{{ route('designation.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Designations</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan
                    @canany(['View employee', 'View casual-casualworkers'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-users"></i>
                                <p>
                                    Employees
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('View employee')
                                    <li class="nav-item">
                                        <a href="{{ route('employee.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Permanent Employees
                                            </p>
                                        </a>
                                    </li>
                                    @endcan
                                    @can('View casual-casualworkers')
                                    

                                    <li class="nav-item">
                                        <a href="{{ route('casual.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Casual Workers</p>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan


                    @can('View asset')
                        <li class="nav-item">
                            <a href="{{ route('asset.index') }}" class="nav-link">
                                <i class="fas fa-desktop mr-2"></i>
                                <p>
                                    Assets

                                </p>
                            </a>

                        </li>
                    @endcan

                    @canany([
                        'view holiday',
                        'view leave-type',
                        'view leave',
                        
                       
                        ])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-calendar mr-2"></i>
                                <p>
                                    Leave
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('view leave-type')
                                    <li class="nav-item">
                                        <a href="{{ route('holiday.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i> Holiday
                                        </a>
                                    </li>
                                
                                    <li class="nav-item">
                                        <a href="{{ route('leave_type.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i> Leave Type
                                        </a>
                                    </li>
                                @endcan
                                @can('view leave')
                                    <li class="nav-item">
                                        <a href="{{ route('leave.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i> Leave Application
                                        </a>
                                    </li>
                                @endcan
                              

                            </ul>

                        </li>
                    @endcan
                    @can('view perdeim')
                        <li class="nav-item">
                            <a href="{{ route('perdeim.index') }}" class="nav-link">
                                <i class="fas fa-money-bill mr-2"></i> Perdeim
                            </a>

                        </li>
                    @endcan

                    @can('view fund-request')
                        <li class="nav-item">
                            <a href="{{ route('fundRequest.index') }}" class="nav-link">
                                <i class="fas fa-calculator"></i> Fund Request
                            </a>

                        </li>
                    @endcan

                    @canany(['view payrol', 'view work-overtime'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-wallet"></i>
                                <p>
                                    Payroll
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view work-overtime')
                                    <li class="nav-item">
                                        <a href="{{ route('work-overtime.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Work Overtime
                                        </a>
                                    </li>
                                @endcan
                                @can('view mypayrol')
                                    <li class="nav-item">
                                        <a href="{{ route('myPayrol') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            My Payroll
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                        </li>
                    @endcan


                    @can('view invoice')
                    <li class="nav-item">
                        <a href="{{ route('invoice.index') }}" class="nav-link">
                            <i class="fas fa-file-invoice"></i>
                            <p>
                                Invoice

                            </p>
                        </a>

                    </li>
                    @endcan



                    @canany(['view deduction', 'view overal-payrol', 'view benefits', 'view salary'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-calendar mr-2"></i>
                                <p>
                                    Employee Payroll
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>

                            <ul class="nav nav-treeview">
                                @can('view deduction')
                                    <li class="nav-item">

                                        <a href="{{ route('deduction.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Deduction
                                        </a>
                                    </li>
                                @endcan
                                @can('view benefits')
                                    <li class="nav-item">

                                        <a href="{{ route('benefit.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Benefits
                                        </a>

                                    </li>
                                @endcan

                                @can('view salary')
                                    <li class="nav-item">

                                        <a href="{{ route('salary.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Salary
                                        </a>

                                    </li>
                                @endcan

                                @can('view overal-payrol')
                                    <li class="nav-item">
                                        <a href="{{ route('payrol.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Overall Payroll List
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                        </li>
                    @endcan

                    @canany(['view employee-timesheet', 'view machine-timesheet'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-wallet"></i>
                                <p>
                                    Timesheet
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view employee-timesheet')
                                    <li class="nav-item">
                                        <a href="{{ route('employeeTimesheet.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Employee Timesheet
                                        </a>
                                    </li>
                                @endcan
                                @can('view machine-timesheet')
                                    <li class="nav-item">
                                        <a href="{{ route('machine.index') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Machine Timesheet
                                        </a>
                                    </li>
                                @endcan
                            </ul>

                        </li>
                    @endcan


                    @canany(['view income', 'view expenditure','view profitlossreport','view balancesheet'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-wallet"></i>
                                <p>
                                    Finance Management
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('view income')
                                    <li class="nav-item">
                                        <a href="{{ route('incomeCategory.index') }}" class="nav-link">

                                            <i class="far fa-circle nav-icon"></i>
                                            Income


                                        </a>

                                    </li>
                                @endcan
                                @can('view expenditure')
                                    <li class="nav-item">
                                        <a href="{{ route('expenditureCategory.index') }}" class="nav-link">

                                            <i class="far fa-circle nav-icon"></i>
                                            Expenditure


                                        </a>

                                    </li>
                                @endcan

                                @can('view profitlossreport')
                                    <li class="nav-item">
                                        <a href="{{ route('profitNLoss') }}" class="nav-link">

                                            <i class="far fa-circle nav-icon"></i>
                                            Profit/Loss report


                                        </a>

                                    </li>
                                @endcan

                                @can('view balancesheet')
                                    <li class="nav-item">
                                        <a href="{{ route('balanceSheet.index') }}" class="nav-link">

                                            <i class="far fa-circle nav-icon"></i>
                                            Balance Sheet
                                        </a>

                                        <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ route('balanceSheet.index') }}" class="nav-link">
        
                                                    <i class="fas fa-caret-right nav-icon"></i>
                                                    Balance Sheet details
                                                </a>
                                            </li>


                                            
                                            <li class="nav-item">
                                                <a href="{{ route('bank.index') }}" class="nav-link">
                                                    <i class="fas fa-caret-right nav-icon"></i>
        
                                                    <p>Bank</p>
                                                </a>
                                            </li>
                                       

                                       
                                        <li class="nav-item">
                                            <a href="{{ route('cash.index') }}" class="nav-link">
                                                <i class="fas fa-caret-right nav-icon"></i>
    
                                                <p>Cash In hand</p>
                                            </a>
                                        </li>
                                   
                                    
                                    <li class="nav-item">
                                        <a href="{{ route('pettyCash.index') }}" class="nav-link">
                                            <i class="fas fa-caret-right nav-icon"></i>

                                            <p>Petty Cash</p>
                                        </a>
                                    </li>
                              
                                        </ul>

                                    </li>
                                    @endcan
                              
                            </ul>

                        </li>
                    @endcan
                  

                    @canany(['manager approve leave','manager approve fund-request','manager approve perdeim'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-check-circle"></i>
                                <p>
                                    Manager Approval
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('manager approve leave')
                                    <li class="nav-item">
                                        <a href="{{ route('leave.managerView') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            Approve Leave

                                        </a>
                                    </li>
                                @endcan

                                @can('manager approve work-overtime')
                                <li class="nav-item">
                                    <a href="{{ route('approveWorkOvertime') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        Approve Work Overtime

                                    </a>
                                </li>
                                @endcan

                                @can('manager approve perdeim')
                                <li class="nav-item">
                                    <a href="{{ route('perdeim.managerView') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>Approve Perdeim

                                    </a>
                                </li>
                                @endcan
                                @can('manager approve fund-request')
                                <li class="nav-item">
                                    <a href="{{ route('fundrequest.managerView') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>Approve Fundrequest

                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </li>
                    @endcan

                    @canany(['director approve leave', 'director approve fund-request', 'director approve perdeim'])
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fas fa-stamp"></i>
                                <p>
                                    Director Approval
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                @can('director approve leave')
                                    <li class="nav-item">
                                        <a href="{{ route('leave.hrView') }}" class="nav-link">
                                            <i class="fas fa-clipboard-check"></i>
                                            Approve Leave
                                        </a>
                                    </li>
                                @endcan

                                @can('director approve perdeim')
                                    <li class="nav-item">
                                        <a href="{{ route('perdeim.drView') }}" class="nav-link">
                                            <i class="fas fa-clipboard-check"></i>
                                            Approve Perdeim
                                        </a>
                                    </li>
                                @endcan
                                @can('director approve fund-request')
                                    <li class="nav-item">
                                        <a href="{{ route('fundrequest.drView') }}" class="nav-link">
                                            <i class="fas fa-clipboard-check"></i>
                                            Approve Fund Request
                                        </a>
                                    </li>
                                @endcan

                                @can('director approve work-overtime')
                                <li class="nav-item">
                                    <a href="{{ route('approveWorkOvertime') }}" class="nav-link">
                                        <i class="fas fa-clipboard-check"></i>
                                        Approve Work Overtime
                                    </a>
                                </li>
                                @endcan

                            </ul>

                        </li>
                    @endcan

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>
                                logout
                            </p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>

    <<!-- View code for change password modal -->
        <div class="modal fade" id="changePasswordModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Change Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form role="form" method="post" action="{{ route('changePassword') }}">
                            <div class="form-group">
                                <label for="current_password" class="control-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control"
                                    id="current_password" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password" class="control-label">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password"
                                    pattern="^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                                    title="Password must be at least 8 characters long and include at least one letter, one number, and one special character."
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password" class="control-label">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control"
                                    id="confirm_password" required>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Save changes</button>
                            </div>
                            <?= csrf_field() ?>
                        </form>

                    </div>
                </div>
            </div>
        </div>

        <<!-- View code for change password modal -->
            <div class="modal fade" id="updateProfileModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Profile</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form role="form" method="post" action="{{ route('updateProfile') }}"
                                enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="profile_picture" class="control-label">Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control"
                                        id="profile_picture" required>
                                </div>
                                <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-default"
                                        data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                                <?= csrf_field() ?>
                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <!-- JavaScript code -->
            <script>
                function openChangePasswordModal() {
                    // Code to open the password change modal
                    var modal = document.getElementById("changePasswordModal");
                    modal.style.display = "block";
                }

                function closeChangePasswordModal() {
                    // Code to close the password change modal
                    var modal = document.getElementById("changePasswordModal");
                    modal.style.display = "none";
                }
            </script>

            <main class="p-4">
                @yield('content')
            </main>
            @include('layouts.foot')
