<div class="flex flex-col items-center md:flex-row md:items-start md:space-x-10">
    <div class="w-full md:w-8/12">
        <div class="flex mb-3 space-x-2 px-4">
            <div class="w-4/12">
                <h6 class="font-bold">Name</h6>
            </div>
            <div class="w-4/12">
                <h6 class="font-bold">Email</h6>
            </div>
            <div class="w-2/12">
                <h6 class="font-bold">Role</h6>
            </div>
            <div class="w-2/12">
                <h6 class="font-bold">Action</h6>
            </div>
        </div>

        @foreach($users as $user)
        <div class="flex mb-3 bg-white shadow-sm rounded-md p-4 space-x-2">
            <div class="w-4/12">
                <h6 class="font-normal">{{ $user->name }}</h6>
            </div>
            <div class="w-4/12">
                <h6 class="font-normal">{{ $user->email }}</h6>
            </div>
            <div class="w-2/12">
                <h6 class="font-normal">{{ $user->role }}</h6>
            </div>
            <div class="w-2/12">
                <div class="flex justify-start space-x-2">
                    <button class="px-3 py-1 bg-white text-[13px] border border-gray-300 rounded-md hover:bg-gray-400" wire:click="editUser({{ $user->id }})">EDIT</button>
                    <button class="px-3 py-1 bg-red-600 text-white text-[13px] rounded-md hover:bg-red-500" wire:click="deleteUser({{ $user->id }})">DELETE</button>
                </div>
            </div>
        </div>
        @endforeach
            {{ $users->links() }}

    </div>
    <div class="w-full md:w-4/12">
        <div class="p-6 bg-white rounded-md">
            <h6 class="font-bold mb-2">New User</h6>
            <form wire:submit.prevent="addUser">
                <div class="mb-4">
                    <label for="name" class="block font-medium text-sm mb-1">Name:</label>
                    <input type="text" id="name" wire:model="name" placeholder="John Doe" class="w-full bg-gray-100 border-gray-100 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                    @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="email" class="block font-medium text-sm mb-1">Email:</label>
                    <input type="email" id="email" wire:model="email" placeholder="email@example.com" class="w-full bg-gray-100 border-gray-100 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="password" class="block font-medium text-sm mb-1">Password:</label>
                    <input type="password" id="password" wire:model="password" placeholder="********" class="w-full bg-gray-100 border-gray-100 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                    @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <div class="mb-4">
                    <label for="role" class="block font-medium text-sm mb-1">Role:</label>
                    <select id="role" wire:model="role" class="w-full bg-gray-100 border-gray-100 rounded-md shadow-sm focus:border-blue-400 focus:ring focus:ring-blue-400 focus:ring-opacity-50">
                        <option>Select</option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
                    @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:bg-blue-600">SAVE</button>
            </form>
        </div>
        
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('livewire:load', function () {
        Livewire.on('confirmDelete', userId => {
            if (confirm('Are you sure you want to delete this user?')) {
                Livewire.emit('deleteUser', userId);
            }
        });

        Livewire.on('userDeleted', () => {
            alert('User deleted successfully.');
        });
    });
</script>
@endpush