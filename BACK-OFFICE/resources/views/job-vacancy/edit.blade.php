<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            {{ __('Edit Job Vacancy : ' . $jobVacancy->title) }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-10 bg-white rounded-lg shadow-md">

            <form action="{{ route('job-vacancy.update', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => request()->query('redirectToList', 'true')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Title -->
                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">
                        Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title', $jobVacancy->title) }}"
                        class="{{ $errors->has('title') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter job title">
                    @error('title')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="{{ $errors->has('description') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter job description">{{ old('description', $jobVacancy->description) }}</textarea>
                    @error('description')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location -->
                <div class="mb-4">
                    <label for="location" class="block text-gray-700 text-sm font-bold mb-2">
                        Location <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="location" id="location" value="{{ old('location', $jobVacancy->location) }}"
                        class="{{ $errors->has('location') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter location">
                    @error('location')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Salary -->
                <div class="mb-4">
                    <label for="salary" class="block text-gray-700 text-sm font-bold mb-2">
                        Salary ($) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" step="0.01" name="salary" id="salary" value="{{ old('salary', $jobVacancy->salary) }}"
                        class="{{ $errors->has('salary') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter salary">
                    @error('salary')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Type -->
                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">
                        Job Type <span class="text-red-500">*</span>
                    </label>
                    <select name="type" id="type"
                        class="{{ $errors->has('type') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Job Type</option>
                        <option value="full-time" {{ old('type', $jobVacancy->type) == 'full-time' ? 'selected' : '' }}>Full-time</option>
                        <option value="part-time" {{ old('type', $jobVacancy->type) == 'part-time' ? 'selected' : '' }}>Part-time</option>
                        <option value="remote" {{ old('type', $jobVacancy->type) == 'remote' ? 'selected' : '' }}>Remote</option>
                        <option value="hybrid" {{ old('type', $jobVacancy->type) == 'hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                    @error('type')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label for="categoryId" class="block text-gray-700 text-sm font-bold mb-2">
                        Job Category <span class="text-red-500">*</span>
                    </label>
                    <select name="categoryId" id="categoryId"
                        class="{{ $errors->has('categoryId') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('categoryId', $jobVacancy->categoryId) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoryId')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Company -->
                <div class="mb-4">
                    <label for="companyId" class="block text-gray-700 text-sm font-bold mb-2">
                        Company <span class="text-red-500">*</span>
                    </label>
                    <select name="companyId" id="companyId"
                        class="{{ $errors->has('companyId') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="">Select Company</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}" {{ old('companyId', $jobVacancy->companyId) == $company->id ? 'selected' : '' }}>
                                {{ $company->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('companyId')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Edit Job Vacancy
                    </button>

                    <a href="{{ request()->query('redirectToList') === 'false' ? route('job-vacancy.show', $jobVacancy->id) : route('job-vacancy.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
