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
    
    public function render()
    {
        // $users = UserModel::get();
        $users = $this->repo->getAllUsers();
        
        return view('livewire.user', compact('users'));
    }
}
