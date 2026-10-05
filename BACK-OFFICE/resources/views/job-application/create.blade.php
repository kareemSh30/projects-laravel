<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            {{ __('Create New Job Application') }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-10 bg-white rounded-lg shadow-md">

            <form action="{{ route('job-application.store') }}" method="POST">
                @csrf

                <!-- User / Applicant -->
                <div class="mb-4">
                    <label for="userId" class="block text-gray-700 text-sm font-bold mb-2">
                        Applicant / User <span class="text-red-500">*</span>
                    </label>
                    <select name="userId" id="userId"
                        class="{{ $errors->has('userId') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Applicant</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('userId') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('userId')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Job Vacancy -->
                <div class="mb-4">
                    <label for="jobVacancyId" class="block text-gray-700 text-sm font-bold mb-2">
                        Job Vacancy <span class="text-red-500">*</span>
                    </label>
                    <select name="jobVacancyId" id="jobVacancyId"
                        class="{{ $errors->has('jobVacancyId') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Job Vacancy</option>
                        @foreach($jobVacancies as $vacancy)
                            <option value="{{ $vacancy->id }}" {{ old('jobVacancyId') == $vacancy->id ? 'selected' : '' }}>
                                {{ $vacancy->title }} {{ $vacancy->company ? ' - ' . $vacancy->company->name : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('jobVacancyId')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Resume -->
                <div class="mb-4">
                    <label for="resumeId" class="block text-gray-700 text-sm font-bold mb-2">
                        Resume <span class="text-red-500">*</span>
                    </label>
                    <select name="resumeId" id="resumeId"
                        class="{{ $errors->has('resumeId') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Resume</option>
                        @foreach($resumes as $resume)
                            <option value="{{ $resume->id }}" {{ old('resumeId') == $resume->id ? 'selected' : '' }}>
                                {{ $resume->fileName ?? 'Resume #' . substr($resume->id, 0, 8) }} {{ $resume->user ? ' (' . $resume->user->name . ')' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('resumeId')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div class="mb-4">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select name="status" id="status"
                        class="{{ $errors->has('status') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="accepted" {{ old('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                        <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                    @error('status')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- AI Generated Score -->
                <div class="mb-4">
                    <label for="aiGeneratedScore" class="block text-gray-700 text-sm font-bold mb-2">
                        AI Generated Score (0 - 100)
                    </label>
                    <input type="number" step="0.1" min="0" max="100" name="aiGeneratedScore" id="aiGeneratedScore" value="{{ old('aiGeneratedScore', 0.0) }}"
                        class="{{ $errors->has('aiGeneratedScore') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="e.g. 85.5">
                    @error('aiGeneratedScore')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- AI Generated Feedback -->
                <div class="mb-4">
                    <label for="aiGeneratedFeedback" class="block text-gray-700 text-sm font-bold mb-2">
                        AI Generated Feedback
                    </label>
                    <textarea name="aiGeneratedFeedback" id="aiGeneratedFeedback" rows="4"
                        class="{{ $errors->has('aiGeneratedFeedback') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter optional AI evaluation feedback">{{ old('aiGeneratedFeedback') }}</textarea>
                    @error('aiGeneratedFeedback')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Create Job Application
                    </button>

                    <a href="{{ route('job-application.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
