<div>
    <div class="flex justify-center">
        <x-input-error :messages="$errors->get('todo')" class="mt-2" />
    </div>

    <form class="flex" method="POST" >
        <x-text-input  class="w-full mr-2"/>
        <x-primary-button >
            Add
        </x-primary-button>
    </form>
    <br>

    {{-- User list --}}
    <div class="mt-5">
        <h2 class="text-lg font-semibold mb-3">User List</h2>
        @foreach($users as $user)
            <div class="flex justify-between items-center py-2 border-b">
                <div>
                    {{ $user->name }} {{-- Display user name --}}
                </div>
                <div>
                    <a href="{{ route('admin.todos', ['userId' => $user->id]) }}" class="text-blue-600 hover:underline">View Todos</a> {{-- Link to view todos for this user --}}
                </div>
            </div>
        @endforeach
    </div>

</div>
