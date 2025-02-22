@extends('layouts.app')

@section('content')
    <h1>Talent Acquisition</h1>
    <a href="{{ route('talent.create') }}">Post New Job</a>
    <table>
        <tr><th>Job Title</th><th>Description</th><th>Deadline</th><th>Actions</th></tr>
        @foreach($jobs as $job)
            <tr>
                <td>{{ $job->job_title }}</td>
                <td>{{ $job->description }}</td>
                <td>{{ $job->application_deadline }}</td>
                <td>
                    <form method="POST" action="{{ route('talent.destroy', $job->id) }}">
                        @csrf @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
