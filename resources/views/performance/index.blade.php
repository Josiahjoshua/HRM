@extends('layouts.app')

@section('content')
    <h1>Performance Metrics</h1>
    <a href="{{ route('performance.create') }}">Add Metric</a>
    <table>
        <tr><th>Employee</th><th>KPI</th><th>Score</th><th>Actions</th></tr>
        @foreach($metrics as $metric)
            <tr>
                <td>{{ $metric->employee->name }}</td>
                <td>{{ $metric->kpi }}</td>
                <td>{{ $metric->score }}</td>
                <td>
                    <form method="POST" action="{{ route('performance.destroy', $metric->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
