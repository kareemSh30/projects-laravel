<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
            {{ __('Edit Company : ' . $company->name) }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">
        <div class="max-w-2xl mx-auto p-10 bg-white rounded-lg shadow-md">

            <form action="{{ route('company.update', ['company' => $company->id, 'redirectToList' => request()->query('redirectToList', 'true')]) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Company Name -->
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">
                        Company Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $company->name) }}"
                        class="{{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter company name">
                    @error('name')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

               

                <!-- Address -->
                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">
                        Address
                    </label>
                    <input type="text" name="address" id="address" value="{{ old('address',$company->address) }}"
                        class="{{ $errors->has('address') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="Enter company address">
                    @error('address')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                 <!-- Industry -->
                <div class="mb-4">
                    <label for="industry" class="block text-gray-700 text-sm font-bold mb-2">
                        Industry <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="industry" id="industry" value="{{ old('industry',$company->industry) }}"
                        class="{{ $errors->has('industry') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="e.g. Technology, Healthcare, Finance">
                    @error('industry')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website -->
                <div class="mb-4">
                    <label for="website" class="block text-gray-700 text-sm font-bold mb-2">
                        Website (Optional)
                    </label>
                    <input type="text" name="website" id="website" value="{{ old('website',$company->website) }}"
                        class="{{ $errors->has('website') ? 'border-red-500' : 'border-gray-300' }} mt-1 block w-full rounded-md border shadow-sm focus:border-blue-500 focus:ring-blue-500"
                        placeholder="https://example.com">
                    @error('website')
                        <p class="mt-2 text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>
                

                <!-- Buttons -->
                <div class="flex justify-end space-x-4 mt-6">
                    <button type="submit"
                        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
                        Edit Company
                    </button>

                    <a href="{{ request()->query('redirectToList') === 'false' ? route('company.show', $company->id) : route('company.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
