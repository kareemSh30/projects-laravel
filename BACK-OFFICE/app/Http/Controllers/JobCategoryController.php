<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //latest
        $query = JobCategory::latest();
        //filter archive
        if($request->input('archived')=='true'){
            $query->onlyTrashed();
        }
        $categories=$query->paginate(5)->withQueryString()->onEachSide(2);

        return view('job-category.index',compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
       $validate=$request->validated();
       JobCategory::create($validate);
       return redirect()->route('job-category.index')->with('success','Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category=JobCategory::findOrFail($id);
        return view('job-category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $validated= $request->validated();
        $category= JobCategory::findOrFail($id);
        $category->update($validated);
        return redirect()->route('job-category.index')->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category=JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-category.index')->with('success','Category deleted successfully');
    }

    public function restore(string $id){
        $category=JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('job-category.index',['archived' => 'true'])->with('success','Category restored successfully');
    }
}
