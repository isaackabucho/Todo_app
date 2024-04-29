<?php

namespace App\DbRepo;

use App\Models\User as UserModel;
use App\Livewire\User as UserLivewire;

class AddUser
{
    public function addUser($name, $email, $password, $role)
    {
        // Instantiate the User Livewire component
        $userComponent = app(UserLivewire::class);

        // Set the input values
        $userComponent->name = $name;
        $userComponent->email = $email;
        $userComponent->password = $password;
        $userComponent->role = $role;

        // Call the addUser method of the User Livewire component
        $userComponent->addUser();
    }

    public function getAllUsers()
    {
        return UserModel::latest()->paginate(5);
    }
}
