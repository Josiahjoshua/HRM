<?php

namespace App\Http\Controllers;

use App\Models\PerformanceMetric;
use App\Models\User;
use Illuminate\Http\Request;

class PerformanceMetricController extends Controller {
    public function index() {
        $metrics = PerformanceMetric::with('employee')->get();
        return view('performance.index', compact('metrics'));
    }

    public function create() {
        $employees = User::all();
        return view('performance.create', compact('employees'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:users,id',
            'kpi' => 'required|string',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        PerformanceMetric::create($request->all());
        return redirect()->route('performance.index')->with('success', 'Performance Metric Added');
    }

    public function destroy(PerformanceMetric $metric) {
        $metric->delete();
        return redirect()->route('performance.index')->with('success', 'Deleted Successfully');
    }
}
