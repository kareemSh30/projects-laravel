<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            {{ $jobVacancy->title }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast></x-toast>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-end mb-6">
                <a
                    href="{{ route('job-vacancy.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                    Back to Job Vacancies
                </a>
            </div>

            <div class="mb-6 space-y-2">
                <h1 class="text-xl font-bold border-b pb-2 mb-4">Job Vacancy Information</h1>
                <p class="font-bold capitalize"><strong>Title: </strong><span class="font-normal">{{ $jobVacancy->title }}</span></p>
                <p class="font-bold capitalize"><strong>Company: </strong><span class="font-normal">{{ $jobVacancy->company->name ?? 'N/A' }}</span></p>
                <p class="font-bold capitalize"><strong>Category: </strong><span class="font-normal">{{ $jobVacancy->jobCategory->name ?? 'N/A' }}</span></p>
                <p class="font-bold capitalize"><strong>Location: </strong><span class="font-normal">{{ $jobVacancy->location }}</span></p>
                <p class="font-bold capitalize"><strong>Salary: </strong><span class="font-normal">$ {{ number_format($jobVacancy->salary, 2) }}</span></p>
                <p class="font-bold capitalize"><strong>Type: </strong><span class="font-normal">{{ $jobVacancy->type }}</span></p>
                <p class="font-bold capitalize"><strong>Description: </strong><span class="font-normal whitespace-pre-line">{{ $jobVacancy->description }}</span></p>
            </div>

            <div class="flex justify-end space-x-4 mb-6">
                <!-- Edit -->
                <a
                    href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'false']) }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Edit
                </a>

                <!-- Archive -->
                <form
                    action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}"
                    method="POST"
                    class="inline-flex">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2">
                        Archive
                    </button>
                </form>
            </div>

            <!-- Applications List -->
            <div>
                <h2 class="text-lg font-bold mb-4">Job Applications ({{ $applications->count() }})</h2>
                <table class="min-w-full bg-gray-50 rounded-lg shadow-md">
                    <thead>
                        <tr>
                            <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Applicant</th>
                            <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Status</th>
                            <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">AI Score</th>
                            <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr>
                                <td class="py-3 px-4">{{ $application->user->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst($application->status ?? 'pending') }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    {{ $application->aiGeneratedScore ?? 'N/A' }}
                                </td>
                                <td class="py-3 px-4">
                                    <a href="{{ route('job-application.show', $application->id) }}"
                                       class="px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 text-center text-gray-500">No applications found for this job vacancy.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>