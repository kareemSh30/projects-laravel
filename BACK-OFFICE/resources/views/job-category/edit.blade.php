<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800  uppercase text-center flex justify-center ">
            {{ __('Edit job category') }}
        </h2>
    </x-slot>
       <div class="overflow-x-auto p-6 ">
        <div class="max-w-2xl mx-auto p-10 bg-white rounded-lg shadow-md">

        <form action="{{route('job-category.update',$category->id)}}" method="POST" >
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Category Name</label>
                <input type="text" name="name" id=""  value="{{old('name',$category->name)}}"
                class="{{$errors->has('name') ? 'border-red-500' : ''}} mt-1 block w-full rounded-md border border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                
                @error('name')
                <p class=" mt-2 text-red-600 text-sm">{{$message}}</p>
                @enderror


                <div class="flex justify-end space-x-4">
                <button type="submit" 
                class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2 mt-4">
                 Update Category</button>


                <a href="{{route('job-category.index')}}"
                class="inline-flex items-center px-4 py-2 bg-red-400 text-white rounded-md hover:bg-red-800
                 focus:outline-none focus:ring-2 focus:ring-red-300 focus:ring-offset-2 mt-4">
                Cancel</a>
                </div>
            </div>
        </form>
    </div>
    </div>
    
</x-app-layout>