<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
           Job Categories {{ request()->input('archived') == 'true' ? '(Archived)' : '' }}
        </h2>
    </x-slot>

<div class="overflow-x-auto p-6">

    <!-- Success Message -->
    <x-toast></x-toast>

    <!-- Buttons -->
    <div class="flex justify-end items-center space-x-4">
        <div>

            @if(request()->input('archived') == 'true')

                <!-- Archive Button (Green) -->
                <a
                    href="{{ route('job-category.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Active Categories
                </a>

            @else

                <!-- Archive Button (Black) -->
                <a
                    href="{{ route('job-category.index', ['archived' => 'true']) }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Archive Categories
                </a>

                <!-- Create Button (Blue) -->
                <a
                    href="{{ route('job-category.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                    Create New Category +
                </a>

            @endif

        </div>
    </div>

    <!-- Table -->
    <table class="min-w-full divide-y divide-gray-200 rounded-lg shadow-md mt-5 bg-white">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left uppercase">Category Name</th>
                <th class="px-6 py-3 text-left uppercase">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td class="py-4 px-6 text-gray-900 font-medium">{{ $category->name }}</td>

                    <td>
                        <div class="flex space-x-4">

                            @if(request()->input('archived') == 'true')

                                <!-- Only Restore button when archived -->
                                <form
                                    action="{{ route('job-category.restore', $category->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit"
                                            class="text-green-600 hover:text-green-900 bg-green-200 px-2 py-1 rounded">
                                        Restore ↩️
                                    </button>
                                </form>

                            @else

                                <!-- Edit Button -->
                                <a
                                    href="{{ route('job-category.edit', $category->id) }}"
                                    class="text-blue-600 hover:text-blue-900 bg-blue-200 px-2 py-1 rounded">
                                    Edit 🖊️
                                </a>

                                <!-- Archive Button -->
                                <form
                                    action="{{ route('job-category.destroy', $category->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
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
                    <td colspan="2" class="text-center py-4">No categories found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="mt-4"> {{ $categories->links() }} </div>

</div>

</x-app-layout>
