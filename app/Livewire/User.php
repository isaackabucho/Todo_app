<?php

namespace App\Livewire;

use Livewire\Component;
use App\DbRepo\AddUser;
use App\Models\User as UserModel;
use Livewire\WithPagination;

class User extends Component
{
    use WithPagination;
    protected $repo;
    public $name;
    public $email;
    public $password;
    public $role;

    public function boot(AddUser $repo)
    {
        $this->repo = $repo;
    }

    public function addUser()
    {
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
        ]);
        UserModel::create($validatedData);
        $this->reset(['name', 'email', 'password', 'role']);
    }

    public function getAllUsersList(){
        $users = UserModel::get();
        return $users;
    }

    
    public function editUser($userId)
    {
    // Find the user by ID
    $user = UserModel::findOrFail($userId);

    // Populate the form fields with the user's current data
    $this->name = $user->name;
    $this->email = $user->email;
    $this->role = $user->role;
    $this->password=$user->password;

    // Store the user ID in a hidden field for identification during update
    $this->userId = $userId;

    // Set a flag to indicate that the form is in edit mode
    $this->editMode = true;
    }

    public function updateUser()
    {
        // Validate the updated data
        $validatedData = $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $this->userId,
            'role' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        // Find the user by ID
        $user = UserModel::findOrFail($this->userId);

        // Update the user data
        $user->update($validatedData);

        // Reset form fields and edit mode
        $this->resetFormFields();

        // Refresh the user list
        $this->render();
    }

    public function cancelEdit()
    {
        // Reset form fields and edit mode
        $this->resetFormFields();
    }

    protected function resetFormFields()
    {
        $this->name = '';
        $this->email = '';
        $this->role = '';
        $this->userId = null;
        $this->editMode = false;
    }

    public function deleteUser($userId){
        UserModel::find($userId)->delete();
    }



    public function render()
    {
        // $users = UserModel::get();
        $users = $this->repo->getAllUsers();
        
        return view('livewire.user', compact('users'));
    }
}
