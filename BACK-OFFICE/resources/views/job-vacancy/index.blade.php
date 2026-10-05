<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            Job Vacancies {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Success Message -->
        <x-toast></x-toast>

        <!-- Buttons -->
        <div class="flex justify-end items-center space-x-4">
            <div>

                @if(request()->input('archived') == 'true')

                    <!-- Active Job Vacancies -->
                    <a
                        href="{{ route('job-vacancy.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        Active Job Vacancies
                    </a>

                @else

                    <!-- Archive Job Vacancies -->
                    <a
                        href="{{ route('job-vacancy.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Archive Job Vacancies
                    </a>

                    <!-- Create Job Vacancy -->
                    <a
                        href="{{ route('job-vacancy.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Create New Job Vacancy +
                    </a>

                @endif

            </div>
        </div>

        <!-- Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-5 bg-white">

            <thead>
                <tr>
                    <th class="px-6 py-3 text-left uppercase">Title</th>
                    <th class="px-6 py-3 text-left uppercase">Company</th>
                    <th class="px-6 py-3 text-left uppercase">Location</th>
                    <th class="px-6 py-3 text-left uppercase">Salary</th>
                    <th class="px-6 py-3 text-left uppercase">Type / Category</th>
                    <th class="px-6 py-3 text-left uppercase">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($jobVacancies as $jobVacancy)

                    <tr>

                        <!-- Title -->
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <a
                                href="{{ route('job-vacancy.show', $jobVacancy->id) }}"
                                class="text-gray-900 hover:text-blue-600 underline">
                                {{ $jobVacancy->title }}
                            </a>
                        </td>

                        <!-- Company -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $jobVacancy->company->name ?? 'N/A' }}
                        </td>

                        <!-- Location -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $jobVacancy->location }}
                        </td>

                        <!-- Salary -->
                        <td class="py-4 px-6 text-gray-900">
                           $ {{ number_format($jobVacancy->salary, 2) }}
                        </td>

                        <!-- Type / Category -->
                        <td class="py-4 px-6 text-gray-900">
                            @if($jobVacancy->jobCategory)
                                <span class="font-semibold">{{ $jobVacancy->jobCategory->name }}</span>
                                @if($jobVacancy->type)
                                    <span class="text-xs text-gray-500">({{ $jobVacancy->type }})</span>
                                @endif
                            @else
                                <span class="text-gray-400">
                                    {{ $jobVacancy->type ?? 'No category' }}
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="flex space-x-4">

                                @if(request()->input('archived') == 'true')

                                    <!-- Restore -->
                                    <form
                                        action="{{ route('job-vacancy.restore', $jobVacancy->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="text-white bg-green-600 hover:bg-green-800 px-2 py-1 rounded">
                                            Restore ↩️
                                        </button>

                                    </form>

                                @else

                                    <!-- Edit -->
                                    <a
                                        href="{{ route('job-vacancy.edit', ['job_vacancy' => $jobVacancy->id, 'redirectToList' => 'true']) }}"
                                        class="text-white bg-blue-600 hover:bg-blue-800 px-2 py-1 rounded">
                                        Edit 🖊️
                                    </a>

                                    <!-- Archive -->
                                    <form
                                        action="{{ route('job-vacancy.destroy', $jobVacancy->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-white bg-red-600 hover:bg-red-800 px-2 py-1 rounded">
                                            Archive 🗑️
                                        </button>

                                    </form>

                                @endif

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="text-center py-4 text-gray-500">
                            No Job Vacancies found
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $jobVacancies->links() }}
        </div>

    </div>

</x-app-layout>