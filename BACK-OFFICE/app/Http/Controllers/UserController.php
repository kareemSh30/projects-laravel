<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::withCount(['company', 'jobApplications', 'resumes'])->latest();

        if ($request->input('archived') == 'true') {
            $query->onlyTrashed();
        }

        $users = $query->paginate(10)->withQueryString()->onEachSide(2);

        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserCreateRequest $request)
    {
        $validated = $request->validated();
        User::create($validated);

        return redirect()->route('user.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with(['company', 'jobApplications.jobVacancy.company', 'resumes'])->findOrFail($id);

        return view('user.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, string $id)
    {
        $validated = $request->validated();
        $user = User::findOrFail($id);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        if ($request->query('redirectToList') == 'true') {
            return redirect()->route('user.index')->with('success', 'User updated successfully');
        }

        return redirect()->route('user.show', $id)->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'User archived successfully');
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(string $id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('user.index', ['archived' => 'true'])->with('success', 'User restored successfully');
    }
}
