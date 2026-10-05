<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Company;
use App\Models\JobCategory;
use App\Http\Requests\JobVacancyCreateRequest;
use App\Http\Requests\JobVacancyUpdateRequest;

class JobVacancyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = JobVacancy::with(['company', 'jobCategory'])->latest();

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $jobVacancies = $query->paginate(10)->withQueryString()->onEachSide(2);

        return view('job-vacancy.index', compact('jobVacancies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $companies = Company::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();

        return view('job-vacancy.create', compact('companies', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobVacancyCreateRequest $request)
    {
        $validated = $request->validated();
        JobVacancy::create($validated);

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobVacancy = JobVacancy::with(['company', 'jobCategory', 'jobApplications.user', 'jobApplications.resume'])->findOrFail($id);
        $applications = $jobVacancy->jobApplications;

        return view('job-vacancy.show', compact('jobVacancy', 'applications'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $companies = Company::orderBy('name')->get();
        $categories = JobCategory::orderBy('name')->get();

        return view('job-vacancy.edit', compact('jobVacancy', 'companies', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobVacancyUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->update($validated);

        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy updated successfully');
        }

        return redirect()->route('job-vacancy.show', $id)->with('success', 'Job vacancy updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobVacancy = JobVacancy::findOrFail($id);
        $jobVacancy->delete();

        return redirect()->route('job-vacancy.index')->with('success', 'Job vacancy archived successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $jobVacancy = JobVacancy::withTrashed()->findOrFail($id);
        $jobVacancy->restore();

        return redirect()->route('job-vacancy.index', ['archived' => 'true'])->with('success', 'Job vacancy restored successfully');
    }
}
