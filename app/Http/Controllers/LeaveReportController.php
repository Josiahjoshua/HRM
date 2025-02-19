<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Leave_type;
use App\Models\Leave_application;
use App\Models\Employee;
use App\Models\User;

class LeaveReportController extends Controller
{
    public function leaveReport()
{
    // Get all leave applications that are approved and have not expired
    $leaveApplications = LeaveApplication::where('status', 'approved')
        ->where('end_date', '>=', date('Y-m-d'))
        ->get();

    // Group the leave applications by employee ID
    $groupedApplications = $leaveApplications->groupBy('employee_id');

    // Initialize an empty array to store the report data
    $reportData = [];

    // Loop through each employee's leave applications
    foreach ($groupedApplications as $employeeId => $applications) {
        // Get the employee's details
        $employee = Employee::find($employeeId);

        // Initialize variables to store the employee's leave types and remaining days
        $leaveTypes = [];
        $remainingDays = [];

        // Loop through each of the employee's leave applications
        foreach ($applications as $application) {
            // Get the leave type and remaining days for the application
            $leaveType = $application->leaveType->leavename;
            $remainingDay = $application->day_remain;

            // If the leave type already exists in the employee's leave types, add the remaining days to the existing value
            if (array_key_exists($leaveType, $leaveTypes)) {
                $remainingDays[$leaveType] += $remainingDay;
            }
            // Otherwise, add the leave type and remaining days to the employee's leave types and remaining days arrays
            else {
                $leaveTypes[$leaveType] = $leaveType;
                $remainingDays[$leaveType] = $remainingDay;
            }
        }

        // Add the employee's details, leave types, and remaining days to the report data array
        $reportData[] = [
            'employee_name' => $employee->first_name . ' ' . $employee->last_name,
            'leave_types' => $leaveTypes,
            'remaining_days' => $remainingDays,
        ];
    }

    // Return the view with the report data
    return view('leave.report', compact('reportData'));
}

}
