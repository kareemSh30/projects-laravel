<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            Companies {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Success Message -->
        <x-toast></x-toast>

        <!-- Buttons -->
        <div class="flex justify-end items-center space-x-4">
            <div>

                @if(request()->input('archived') == 'true')

                    <!-- Active Companies -->
                    <a
                        href="{{ route('company.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        Active Companies
                    </a>

                @else

                    <!-- Archive Companies -->
                    <a
                        href="{{ route('company.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Archive Companies
                    </a>

                    <!-- Create Company -->
                    <a
                        href="{{ route('company.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Create New Company +
                    </a>

                @endif

            </div>
        </div>

        <!-- Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-5 bg-white">

            <thead>
                <tr>
                    <th class="px-6 py-3 text-left uppercase">Name</th>
                    <th class="px-6 py-3 text-left uppercase">Address</th>
                    <th class="px-6 py-3 text-left uppercase">Industry</th>
                    <th class="px-6 py-3 text-left uppercase">Website</th>
                    <th class="px-6 py-3 text-left uppercase">Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($companies as $company)

                    <tr>

                        <!-- Name -->
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <a
                                href="{{ route('company.show', $company->id) }}"
                                class="text-gray-900 hover:text-blue-600 underline">
                                {{ $company->name }}
                            </a>
                        </td>

                        <!-- Address -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $company->address }}
                        </td>

                        <!-- Industry -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $company->industry }}
                        </td>

                        <!-- Website -->
                        <td class="py-4 px-6 text-gray-900">
                            @if($company->website)
                                <a
                                    href="{{ $company->website }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-blue-600 hover:text-blue-900 underline">
                                    {{ $company->website }}
                                </a>
                            @else
                                <span class="text-gray-400">
                                    No website
                                </span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="flex space-x-4">

                                @if(request()->input('archived') == 'true')

                                    <!-- Restore -->
                                    <form
                                        action="{{ route('company.restore', $company->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('PUT')

                                        <button
                                            type="submit"
                                            class="text-green-600 hover:text-green-900 bg-green-200 px-2 py-1 rounded">
                                            Restore ↩️
                                        </button>

                                    </form>

                                @else

                                    <!-- Edit -->
                                    <a
                                        href="{{ route('company.edit', $company->id) }}"
                                        class="text-blue-600 hover:text-blue-900 bg-blue-200 px-2 py-1 rounded">
                                        Edit 🖊️
                                    </a>

                                    <!-- Archive -->
                                    <form
                                        action="{{ route('company.destroy', $company->id) }}"
                                        method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="text-red-600 hover:text-red-900 bg-red-200 px-2 py-1 rounded">
                                            Archive 🗑️
                                        </button>

                                    </form>

                                @endif

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="5" class="text-center py-4">
                            No Companies found
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $companies->links() }}
        </div>

    </div>

</x-app-layout>