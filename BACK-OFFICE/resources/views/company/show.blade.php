@php
    $tab = request()->input('tab', 'jobs');
    $activeClass = "text-white bg-black hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2";
    $inactiveClass = "text-white bg-gray-400 hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2";
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-xl text-gray-800 uppercase text-center flex justify-center">
          {{$company->name}}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <x-toast></x-toast>

        <div class="w-full mx-auto p-6 bg-white rounded-lg shadow-md">
            <div class="flex justify-end mb-6">
                  <a
                    href="{{ route('company.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-black text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2">
                    Back to Companies
            </a>
            </div>

            <div class="mb-6">
                
                <h1 class="text-xl font-bold">Company Information</h1>
                <p class="font-bold capitalize"><strong >Name: </strong>{{$company->name}}</p>
                <p class="font-bold capitalize"><strong >Address: </strong>{{$company->address}}</p>
                <p class="font-bold capitalize"><strong >Industry: </strong>{{$company->industry}}</p>
                <p class="font-bold capitalize"><strong >Website: </strong><a href="{{$company->website}}" class="text-blue-600 hover:text-blue-900 underline">{{$company->website}}</a></p>

            </div>
            <div class="flex justify-end space-x-4 px-6 mb-6">
        
              
        <!-- Edit -->
        <a
            href="{{ route('company.edit', ['company'=>$company->id , 'redirectToList' => 'false'])}}"
            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2">
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
            <div class="mb-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="{{ route('company.show', [
                            'company' => $company->id,
                            'tab' => 'jobs'
                            ]) }}"
                            
                            class="px-4 py-2 {{ $tab == 'jobs' ? $activeClass : $inactiveClass }}">Jobs</a>
                    </li>
                    <li>
                        <a href="{{ route('company.show', [
                            'company' => $company->id,
                            'tab' => 'applications'
                        ]) }}"
                            
                        class="px-4 py-2 {{ $tab == 'applications' ? $activeClass : $inactiveClass }}">Applications</a>
                    </li>
                </ul>

            </div>
            <div>
                <div id="jobs" class="{{ $tab == 'jobs' ? 'block' : 'hidden' }}">
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-md">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Job Title</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Type</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Location</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($company->jobs as $job)
                                <tr>
                                    <td class="py-3 px-10">{{ $job->title }}</td>
                                    <td class="py-3 px-10">{{ $job->type }}</td>
                                    <td class="py-3 px-10">{{ $job->location }}</td>
                                    <td class="py-3 px-10">
                                          <a
                                            href="{{ route('job-vacancy.show', $job->id) }}"
                                            class="px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800">View</a>
                                    </td>
                                    
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                    

                </div>
                <div id="applications" class="{{ $tab == 'applications' ? 'block' : 'hidden' }}">
                    
                    <table class="min-w-full bg-gray-50 rounded-lg shadow-md">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Applicant</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Job Title</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Type</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Location</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Status</th>
                                <th class="py-2 px-4 text-left bg-gray-200 rounded-lg">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($company->applications as $application)
                                <tr>
                                    <td class="py-3  text-left px-8">{{ $application->user->name ?? 'N/A' }}</td>
                                    <td class="py-3 text-left px-8">{{ $application->jobVacancy->title ?? 'N/A' }}</td>
                                    <td class="py-3 text-left px-8">{{ $application->jobVacancy->type ?? 'N/A' }}</td>
                                    <td class="py-3 text-left px-8">{{ $application->jobVacancy->location ?? 'N/A' }}</td>
                                    <td class="py-3 text-left px-8">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                            {{ ucfirst($application->status ?? 'pending') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-10">
                                        <a href="{{ route('job-application.show', $application->id) }}"
                                           class="px-4 py-2 text-white bg-black rounded-md hover:bg-gray-800">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-4 text-center text-gray-500">No applications found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    

    <div>

    </div>
</x-app-layout>