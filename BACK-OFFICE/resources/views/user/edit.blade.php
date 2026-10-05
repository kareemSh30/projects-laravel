<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            {{ __('Edit User: ' . $user->name) }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-10 bg-white rounded-lg shadow-md">

            <form action="{{ route('user.update', ['user' => $user->id, 'redirectToList' => request()->query('redirectToList', 'true')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                        Full Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}"
                        class="{{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter full name">
                    @error('name')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">
                        Email Address <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="{{ $errors->has('email') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter email address">
                    @error('email')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">
                        Password <span class="text-xs font-normal text-gray-500">(Leave blank to keep current password)</span>
                    </label>
                    <input type="password" name="password" id="password"
                        class="{{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="New password (optional)">
                    @error('password')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Role -->
                <div class="mb-4">
                    <label for="role" class="block text-gray-700 text-sm font-bold mb-2">
                        Role <span class="text-red-500">*</span>
                    </label>
                    <select name="role" id="role"
                        class="{{ $errors->has('role') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="job-seeker" {{ old('role', $user->role) == 'job-seeker' ? 'selected' : '' }}>Job Seeker</option>
                        <option value="company-owner" {{ old('role', $user->role) == 'company-owner' ? 'selected' : '' }}>Company Owner</option>
                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                    @error('role')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Update User
                    </button>

                    <a href="{{ request()->query('redirectToList') === 'false' ? route('user.show', $user->id) : route('user.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
