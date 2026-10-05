<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobApplication;
use App\Models\JobVacancy;
use App\Models\User;
use App\Models\Resume;
use App\Http\Requests\JobApplicationCreateRequest;
use App\Http\Requests\JobApplicationUpdateRequest;

class JobApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobApplication::with(['user', 'jobVacancy.company', 'jobVacancy.jobCategory', 'resume'])->latest();

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $applications = $query->paginate(10)->withQueryString()->onEachSide(2);

        return view('job-application.index', compact('applications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jobVacancies = JobVacancy::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $resumes = Resume::with('user')->get();

        return view('job-application.create', compact('jobVacancies', 'users', 'resumes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobApplicationCreateRequest $request)
    {
        $validated = $request->validated();
        JobApplication::create($validated);

        return redirect()->route('job-application.index')->with('success', 'Job application created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobApplication = JobApplication::with(['user', 'jobVacancy.company', 'jobVacancy.jobCategory', 'resume'])->findOrFail($id);

        return view('job-application.show', compact('jobApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobVacancies = JobVacancy::orderBy('title')->get();
        $users = User::orderBy('name')->get();
        $resumes = Resume::with('user')->get();

        return view('job-application.edit', compact('jobApplication', 'jobVacancies', 'users', 'resumes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobApplicationUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->update($validated);

        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('job-application.index')->with('success', 'Job application updated successfully');
        }

        return redirect()->route('job-application.show', $id)->with('success', 'Job application updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobApplication = JobApplication::findOrFail($id);
        $jobApplication->delete();

        return redirect()->route('job-application.index')->with('success', 'Job application archived successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobApplication = JobApplication::withTrashed()->findOrFail($id);
        $jobApplication->restore();

        return redirect()->route('job-application.index', ['archived' => 'true'])->with('success', 'Job application restored successfully');
    }
}
