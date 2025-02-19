@extends('layouts.app')

@section('content')
    <h1>Leave Report</h1>
    
    <table>
    <thead>
        <tr>
            <th>Employee Name</th>
            <th>Leave Types</th>
            <th>Remaining Days</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reportData as $report)
        <tr>
            <td>{{ $report['employee_name'] }}</td>
            <td>
                @foreach($report['leave_types'] as $leaveType)
                {{ $leaveType }}<br>
                @endforeach
            </td>
            <td>
                @foreach($report['remaining_days'] as $remainingDay)
                {{ $remainingDay }}<br>
                @endforeach
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    
   
@endsection
