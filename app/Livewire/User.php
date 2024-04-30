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
    $user = UserModel::findOrFail($userId);

    $this->name = $user->name;
    $this->email = $user->email;
    $this->role = $user->role;
    $this->password=$user->password;

    $this->userId = $userId;

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

        $user = UserModel::findOrFail($this->userId);

        $user->update($validatedData);

        $this->resetFormFields();

        $this->render();
    }

    public function cancelEdit()
    {
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
