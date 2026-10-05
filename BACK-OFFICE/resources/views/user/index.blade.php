<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            Users Management {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- Toast / Success Message -->
        <x-toast></x-toast>

        <!-- Action Buttons -->
        <div class="flex justify-end items-center space-x-4 mb-5">
            <div>
                @if(request()->input('archived') == 'true')
                    <!-- Active Users -->
                    <a href="{{ route('user.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 focus:ring-offset-2">
                        Active Users
                    </a>
                @else
                    <!-- Archive Users -->
                    <a href="{{ route('user.index', ['archived' => 'true']) }}"
                        class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Archive Users
                    </a>

                    <!-- Create User -->
                    <a href="{{ route('user.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 ml-2">
                        Create New User +
                    </a>
                @endif
            </div>
        </div>

        <!-- Users Table -->
        <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md bg-white">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stats</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined Date</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($users as $user)
                    <tr>
                        <!-- Name -->
                        <td class="py-4 px-6 text-gray-900 font-medium">
                            <a href="{{ route('user.show', $user->id) }}"
                                class="text-blue-600 hover:text-blue-900 font-semibold underline">
                                {{ $user->name }}
                            </a>
                        </td>

                        <!-- Email -->
                        <td class="py-4 px-6 text-gray-900">
                            {{ $user->email }}
                        </td>

                        <!-- Role -->
                        <td class="py-4 px-6">
                            @php
                                $roleClasses = [
                                    'admin' => 'bg-purple-100 text-purple-800',
                                    'company-owner' => 'bg-blue-100 text-blue-800',
                                    'job-seeker' => 'bg-green-100 text-green-800',
                                ];
                                $roleClass = $roleClasses[$user->role] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $roleClass }}">
                                {{ ucfirst(str_replace('-', ' ', $user->role ?? 'job-seeker')) }}
                            </span>
                        </td>

                        <!-- Stats -->
                        <td class="py-4 px-6 text-xs text-gray-600">
                            <div>Companies: <span class="font-bold">{{ $user->company_count ?? 0 }}</span></div>
                            <div>Applications: <span class="font-bold">{{ $user->job_applications_count ?? 0 }}</span></div>
                            <div>Resumes: <span class="font-bold">{{ $user->resumes_count ?? 0 }}</span></div>
                        </td>

                        <!-- Joined Date -->
                        <td class="py-4 px-6 text-gray-900 text-sm">
                            {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                        </td>

                        <!-- Actions -->
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2">
                                @if(request()->input('archived') == 'true')
                                    <!-- Restore -->
                                    <form action="{{ route('user.restore', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="text-white bg-green-600 hover:bg-green-800 px-3 py-1 rounded text-sm">
                                            Restore ↩️
                                        </button>
                                    </form>
                                @else
                                    <!-- View -->
                                    <a href="{{ route('user.show', $user->id) }}"
                                        class="text-white bg-black hover:bg-gray-800 px-3 py-1 rounded text-sm">
                                        View 👁️
                                    </a>

                                    <!-- Edit -->
                                    <a href="{{ route('user.edit', ['user' => $user->id, 'redirectToList' => 'true']) }}"
                                        class="text-white bg-blue-600 hover:bg-blue-800 px-3 py-1 rounded text-sm">
                                        Edit 🖊️
                                    </a>

                                    <!-- Archive -->
                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to archive this user?');">
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
                            No users found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $users->links() }}
        </div>

    </div>
</x-app-layout>
