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
            </div>
        </div>
    </div>

</x-app-layout>
