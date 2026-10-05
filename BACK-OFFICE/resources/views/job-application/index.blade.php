<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            Job Applications {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Toast / Success Message -->
        <x-toast></x-toast>

        <!-- Action Buttons -->
        <div class="flex justify-end items-center space-x-4 mb-5">
            <div>
                @if(request()->input('archived') == 'true')
                    <!-- Active Job Applications -->
                    <a href="{{ route('job-application.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        Active Job Applications
                    </a>
                @else
                    <!-- Archive Job Applications -->
                    <a href="{{ route('job-application.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Archive Job Applications
                    </a>

                   
                @endif
            </div>
        </div>

        <!-- Applications Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Applicant</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Job Vacancy</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Company</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AI Score</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($applications as $application)
                    <tr>
                        <!-- Applicant -->
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <a href="{{ route('job-application.show', $application->id) }}"
                                class="text-blue-600 hover:text-blue-900 font-semibold underline">
                                {{ $application->user->name ?? 'N/A' }}
                            </a>
                            <div class="text-xs text-gray-500">{{ $application->user->email ?? '' }}</div>
                        </td>

                        <!-- Job Vacancy -->
                        <td class="py-4 px-6 text-gray-900">
                            @if($application->jobVacancy)
                                <a href="{{ route('job-vacancy.show', $application->jobVacancy->id) }}" class="hover:underline font-medium text-gray-800">
                                    {{ $application->jobVacancy->title }}
                                </a>
                            @else
                                <span class="text-gray-400">N/A</span>
                            @endif
                        </td>

                        <!-- Company -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $application->jobVacancy->company->name ?? 'N/A' }}
                        </td>

                        <!-- Status -->
                        <td class="py-4 px-6">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'accepted' => 'bg-green-100 text-green-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                ];
                                $badgeClass = $statusClasses[$application->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeClass }}">
                                {{ ucfirst($application->status) }}
                            </span>
                        </td>

                        <!-- AI Score -->
                        <td class="py-4 px-6 text-gray-900">
                            @if($application->aiGeneratedScore !== null && $application->aiGeneratedScore > 0)
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 font-bold text-xs rounded-md">
                                    {{ number_format($application->aiGeneratedScore, 1) }} / 100
                                </span>
                            @else
                                <span class="text-xs text-gray-400">N/A</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('job-application.restore', $application->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-white bg-green-600 hover:bg-green-800 px-3 py-1 rounded text-sm">
                                            Restore ↩️
                                        </button>
                                    </form>
                                @else
                                    <!-- View -->
                                    <a href="{{ route('job-application.show', $application->id) }}"
                                        class="text-white bg-black hover:bg-gray-800 px-3 py-1 rounded text-sm">
                                        View 👁️
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('job-application.edit', ['job_application' => $application->id, 'redirectToList' => 'true']) }}"
                                        class="text-white bg-blue-600 hover:bg-blue-800 px-3 py-1 rounded text-sm">
                                        Edit 🖊️
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('job-application.destroy', $application->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this job application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-white bg-red-600 hover:bg-red-800 px-3 py-1 rounded text-sm">
                                            Archive 🗑️
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-6 text-gray-500">
                            No Job Applications found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $applications->links() }}
        </div>

    </div>
</x-app-layout>
