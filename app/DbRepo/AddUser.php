<?php

namespace App\DbRepo;

use App\Models\User as UserModel;
use App\Livewire\User as UserLivewire;
use App\Jobs\ProcessUserDeletion;
class AddUser
{
    public function addUser($name, $email, $password, $role)
    {
        $userComponent = app(UserLivewire::class);

        $userComponent->name = $name;
        $userComponent->email = $email;
        $userComponent->password = $password;
        $userComponent->role = $role;

        $userComponent->addUser();
    }

    public function getAllUsers()
    {
        return UserModel::latest()->paginate(5);
    }

    public function editUser($userId, $userData)
    {
        $user = UserModel::findOrFail($userId);
        $user->update($userData);
        return $user;
    }

    public function delete($userId){

            $user = UserModel::findOrFail($userId);
    
            $user->delete();
            ProcessUserDeletion::dispatch($user);

    }

}
