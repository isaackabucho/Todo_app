<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4 md:mb-0">
                @if(auth()->user()->role == 'Admin')
                    {{ __('Admin Dashboard') }}
                @else

                {{ __('Dashboard') }}
                @endif
            </h2>
            
            {{-- Admin links --}}
            @if(auth()->user()->role == 'Admin')
                <ul class="flex gap-4">
                    <h3><li><a href="/new_users" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">Users</a></li></h3> 
                    <h3><li><a href="/dashboard" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200">All Todos</a></li></h3>
                </ul>
            @endif
        </div>
    </x-slot>
    
    <div class="p-12">
        @livewire('user')

    </div>

    <div class="container mx-auto py-12">
        <div class="mx-auto sm:px-6">
            <div class="relative flex">

                
                {{-- Todo list section --}}

                
                
                
                {{-- Toggle sidebar button --}}
                <div class="absolute top-0 right-0 mt-4 mr-4 sm:hidden">
                    <button id="toggleSidebar" class="text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-200 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M14.707 3.293a1 1 0 1 1 1.414 1.414l-10 10a1 1 0 0 1-1.414 0l-10-10a1 1 0 1 1 1.414-1.414L10 12.086l4.293-4.293z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
