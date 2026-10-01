<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
          {{$company->name}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast></x-toast>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">

            <div>
                <h1 class="text-xl font-bold">Company Information</h1>
                <p class="font-bold capitalize"><strong >Name: </strong>{{$company->name}}</p>
                <p class="font-bold capitalize"><strong >Address: </strong>{{$company->address}}</p>
                <p class="font-bold capitalize"><strong >Industry: </strong>{{$company->industry}}</p>
                <p class="font-bold capitalize"><strong >Website: </strong><a href="{{$company->website}}" class="text-blue-600 hover:text-blue-900 underline">{{$company->website}}</a></p>

            </div>
        </div>

    </div>

    <div class="flex justify-end space-x-4 px-6 mb-6">
        <a
            href="{{ route('company.index') }}"
            class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
            Back to Companies
        </a>
        <!-- Edit -->
        <a
            href="{{ route('company.edit', $company->id) }}"
            class="inline-flex items-center px-4 py-2 bg-blue-400 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
            Edit 
        </a>

        <!-- Archive -->
        <form
            action="{{ route('company.destroy', $company->id) }}"
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
</x-app-layout>