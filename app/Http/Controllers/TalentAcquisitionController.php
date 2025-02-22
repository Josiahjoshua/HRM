<?php

namespace App\Http\Controllers;

use App\Models\TalentAcquisition;
use Illuminate\Http\Request;

class TalentAcquisitionController extends Controller {
    public function index() {
        $jobs = TalentAcquisition::all();
        return view('talent.index', compact('jobs'));
    }

    public function create() {
        return view('talent.create');
    }

    public function store(Request $request) {
        $request->validate([
            'job_title' => 'required|string',
            'description' => 'required|string',
            'application_deadline' => 'required|date',
        ]);

        TalentAcquisition::create($request->all());
        return redirect()->route('talent.index')->with('success', 'Job Posted');
    }

    public function destroy(TalentAcquisition $job) {
        $job->delete();
        return redirect()->route('talent.index')->with('success', 'Job Deleted');
    }
}
