<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            Job Application Details
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <x-toast></x-toast>

        <div class="w-full max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <!-- Header Bar -->
            <div class="flex justify-between items-center mb-6 border-b pb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Application #{{ substr($jobApplication->id, 0, 8) }}</h1>
                    <p class="text-sm text-gray-500">Submitted on {{ $jobApplication->created_at ? $jobApplication->created_at->format('F d, Y \a\t h:i A') : 'N/A' }}</p>
                </div>
                <a href="{{ route('job-application.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                    Back to Applications
                </a>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Applicant Card -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Applicant Information</h3>
                    <p class="mb-2"><strong class="text-gray-700">Name:</strong> {{ $jobApplication->user->name ?? 'N/A' }}</p>
                    <p class="mb-2"><strong class="text-gray-700">Email:</strong> {{ $jobApplication->user->email ?? 'N/A' }}</p>
                    <p class="mb-2"><strong class="text-gray-700">Role:</strong> {{ ucfirst($jobApplication->user->role ?? 'N/A') }}</p>
                </div>

                <!-- Job Vacancy Card -->
                <div class="bg-gray-50 p-5 rounded-lg border border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Job Vacancy Information</h3>
                    @if($jobApplication->jobVacancy)
                        <p class="mb-2">
                            <strong class="text-gray-700">Job Title:</strong>
                            <a href="{{ route('job-vacancy.show', $jobApplication->jobVacancy->id) }}" class="text-blue-600 hover:underline font-semibold">
                                {{ $jobApplication->jobVacancy->title }}
                            </a>
                        </p>
                        <p class="mb-2"><strong class="text-gray-700">Company:</strong> {{ $jobApplication->jobVacancy->company->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong class="text-gray-700">Category:</strong> {{ $jobApplication->jobVacancy->jobCategory->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong class="text-gray-700">Location:</strong> {{ $jobApplication->jobVacancy->location ?? 'N/A' }}</p>
                    @else
                        <p class="text-gray-500">No associated job vacancy found.</p>
                    @endif
                </div>

            </div>

            <!-- Application Details Section -->
            <div class="bg-gray-50 p-5 rounded-lg border border-gray-200 mb-6">
                <h3 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2">Application Details</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Status -->
                    <div>
                        <strong class="text-gray-700 block mb-1">Status:</strong>
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'accepted' => 'bg-green-100 text-green-800',
                                'rejected' => 'bg-red-100 text-red-800',
                            ];
                            $badgeClass = $statusClasses[$jobApplication->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                            {{ ucfirst($jobApplication->status) }}
                        </span>
                    </div>

                    <!-- AI Score -->
                    <div>
                        <strong class="text-gray-700 block mb-1">AI Generated Score:</strong>
                        @if($jobApplication->aiGeneratedScore !== null && $jobApplication->aiGeneratedScore > 0)
                            <span class="px-3 py-1 bg-purple-100 text-purple-800 font-bold text-sm rounded-md">
                                {{ number_format($jobApplication->aiGeneratedScore, 1) }} / 100
                            </span>
                        @else
                            <span class="text-gray-400">N/A</span>
                        @endif
                    </div>

                    <!-- Resume -->
                    <div>
                        <strong class="text-gray-700 block mb-1">Resume Attached:</strong>
                        @if($jobApplication->resume)
                            <span class="text-gray-800 font-medium">
                                {{ $jobApplication->resume->fileName ?? 'Resume Document' }}
                            </span>
                            @if($jobApplication->resume->fileUrl)
                                <a href="{{ $jobApplication->resume->fileUrl }}" target="_blank" class="block text-xs text-blue-600 underline mt-1">
                                    View File 📄
                                </a>
                            @endif
                        @else
                            <span class="text-gray-400">No Resume Attached</span>
                        @endif
                    </div>
                </div>

                <!-- AI Feedback -->
                @if($jobApplication->aiGeneratedFeedback)
                    <div class="mt-4 pt-4 border-t border-gray-200">
                        <strong class="text-gray-700 block mb-2">AI Feedback & Evaluation:</strong>
                        <div class="p-4 bg-purple-50 text-purple-900 rounded-md text-sm border border-purple-200 whitespace-pre-wrap">
                            {{ $jobApplication->aiGeneratedFeedback }}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Actions Bar -->
            <div class="flex justify-end space-x-4">
                <!-- Edit -->
                <a href="{{ route('job-application.edit', ['job_application' => $jobApplication->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Edit Application
                </a>

                <!-- Archive -->
                <form action="{{ route('job-application.destroy', $jobApplication->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this job application?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                        Archive Application
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
