<div class="flex ">

    {{-- Todo list section --}}
    <div class="w-full">
        <div class="flex justify-center">
            <x-input-error :messages="$errors->get('todo')" class="mt-2" />
        </div>

        <form class="flex" method="POST" wire:submit.prevent='addTodo'>
            <x-text-input wire:model='todo' placeholder="New Todo ... " class="w-full mr-2"/>
            
            <x-primary-button >
                Add
            </x-primary-button>
        </form>
        <br>
        
        @forelse($todos as $todo)

            {{-- First todo --}}
            <div class="flex p-4 justify-between bg-white dark:bg-gray-800 rounded-md border shadow-sm hover:shadow-md" style="margin-bottom:16px">
                <div class="flex justify-start">
                        <div class="">
                            <input id="green-checkbox" wire:click='markAsCompleted({{ $todo->id }})' @if($todo->is_completed) @checked(true) @endif type="checkbox" class="w-4 h-4 text-green-600 bg-gray-100 border-gray-300 rounded focus:ring-green-500 dark:focus:ring-green-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                        </div>
                        <div class="px-3">
                            @if ($edit == $todo->id)
                            <x-text-input wire:model='currentEditTodo' class="w-full mr-2" />
                            
                            @else
                                <span @if($todo->is_completed) class='text-green-600' style="text-decoration: line-through;" @endif>{{ $todo->todo }}</span>
                            @endif
                    </div>

                    
                </div>

                <div>
                    @if($edit == $todo->id)
                        <x-secondary-button wire:click='updateTodo({{ $todo->id }})'>
                            Update
                        </x-secondary-button>
                        <x-danger-button wire:click='cancelEdit()'>
                            Cancel
                        </x-danger-button>
                    @else
                        <x-secondary-button wire:click='editTodo({{ $todo->id }})'>
                            Edit
                        </x-secondary-button>
                        
                        @if(auth()->user()->role == "Admin")
                            <x-danger-button wire:click='deleteTodo({{ $todo->id }})'>
                                Delete
                            </x-danger-button>
                        @endif
                    @endif
                </div>
            </div>

        @empty
            <p>No todos found.</p>
        @endforelse

        <div class="mt-5">
            {{ $todos->links() }}
            <div>
    </div>
</div>
