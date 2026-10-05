@php
    $tab = request()->input('tab', 'companies');
    $activeClass = "text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2";
    $inactiveClass = "text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2";
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            User: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast></x-toast>

        <div class="w-full max-w-5xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <!-- Header Actions -->
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    <p class="text-sm text-gray-500">Member since {{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A' }}</p>
                </div>
                <a href="{{ route('user.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                    Back to Users
                </a>
            </div>

            <!-- User Info Card -->
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <strong class="text-gray-700 block mb-1">Full Name:</strong>
                        <span class="text-gray-900 font-medium">{{ $user->name }}</span>
                    </div>
                    <div>
                        <strong class="text-gray-700 block mb-1">Email Address:</strong>
                        <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                    </div>
                    <div>
                        <strong class="text-gray-700 block mb-1">System Role:</strong>
                        @php
                            $roleClasses = [
                                'admin' => 'bg-purple-100 text-purple-800',
                                'company-owner' => 'bg-blue-100 text-blue-800',
                                'job-seeker' => 'bg-green-100 text-green-800',
                            ];
                            $roleClass = $roleClasses[$user->role] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClass }}">
                            {{ ucfirst(str_replace('-', ' ', $user->role ?? 'job-seeker')) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mb-6">
                <!-- Edit -->
                <a href="{{ route('user.edit', ['user' => $user->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Edit User
                </a>

                <!-- Archive -->
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this user?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                        Archive User
                    </button>
                </form>
            </div>

            <!-- Navigation Tabs -->
            <div class="mb-6">
                <ul class="flex space-x-4 border-b pb-3">
                    <li>
                        <a href="{{ route('user.show', ['user' => $user->id, 'tab' => 'companies']) }}"
                            class="px-4 py-2 rounded-md font-medium text-sm transition {{ $tab == 'companies' ? $activeClass : $inactiveClass }}">
                            Owned Companies ({{ $user->company ? $user->company->count() : 0 }})
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.show', ['user' => $user->id, 'tab' => 'applications']) }}"
                            class="px-4 py-2 rounded-md font-medium text-sm transition {{ $tab == 'applications' ? $activeClass : $inactiveClass }}">
                            Job Applications ({{ $user->jobApplications ? $user->jobApplications->count() : 0 }})
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('user.show', ['user' => $user->id, 'tab' => 'resumes']) }}"
                            class="px-4 py-2 rounded-md font-medium text-sm transition {{ $tab == 'resumes' ? $activeClass : $inactiveClass }}">
                            Resumes ({{ $user->resumes ? $user->resumes->count() : 0 }})
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Tab Content -->
            <div>
                <!-- Companies Tab -->
                <div id="companies" class="{{ $tab == 'companies' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Company Name</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Industry</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Address</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($user->company as $comp)
                                <tr>
                                    <td class="py-3 px-4 font-medium">{{ $comp->name }}</td>
                                    <td class="py-3 px-4">{{ $comp->industry }}</td>
                                    <td class="py-3 px-4">{{ $comp->address }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('company.show', $comp->id) }}"
                                            class="px-3 py-1 text-white bg-black rounded-md hover:bg-gray-800 text-sm">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No companies owned.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Applications Tab -->
                <div id="applications" class="{{ $tab == 'applications' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Job Title</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Company</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Status</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Submitted At</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($user->jobApplications as $app)
                                <tr>
                                    <td class="py-3 px-4 font-medium">{{ $app->jobVacancy->title ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">{{ $app->jobVacancy->company->name ?? 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($app->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $app->created_at ? $app->created_at->format('M d, Y') : 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        <a href="{{ route('job-application.show', $app->id) }}"
                                            class="px-3 py-1 text-white bg-black rounded-md hover:bg-gray-800 text-sm">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-500">No job applications submitted.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Resumes Tab -->
                <div id="resumes" class="{{ $tab == 'resumes' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-sm border">
                        <thead class="bg-gray-200">
                            <tr>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">File Name</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Contact Details</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Uploaded Date</th>
                                <th class="py-2 px-4 text-left font-semibold text-gray-700">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse ($user->resumes as $res)
                                <tr>
                                    <td class="py-3 px-4 font-medium">{{ $res->fileName ?? 'Resume Document' }}</td>
                                    <td class="py-3 px-4 text-sm">{{ Str::limit($res->contactDetails ?? 'N/A', 30) }}</td>
                                    <td class="py-3 px-4 text-sm text-gray-600">{{ $res->created_at ? $res->created_at->format('M d, Y') : 'N/A' }}</td>
                                    <td class="py-3 px-4">
                                        @if($res->fileUrl)
                                            <a href="{{ $res->fileUrl }}" target="_blank"
                                                class="px-3 py-1 text-white bg-blue-600 rounded-md hover:bg-blue-800 text-sm">Download 📄</a>
                                        @else
                                            <span class="text-xs text-gray-400">No Link</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">No resumes uploaded.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</x-app-layout>
