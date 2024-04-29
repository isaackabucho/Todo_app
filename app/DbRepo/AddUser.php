<?php

namespace App\DbRepo;

use App\Models\User as UserModel;
use App\Livewire\User as UserLivewire;
use App\Jobs\ProcessUserDeletion;
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

    public function editUser($userId, $userData)
    {
        // Find the user by ID and update the user data
        $user = UserModel::findOrFail($userId);
        $user->update($userData);
        return $user;
    }

    public function delete($userId){

            $user = UserModel::findOrFail($userId);
    
            $user->delete();
            ProcessUserDeletion::dispatch($user);

    }
    // public function deleteUser($userId){
    //     $this->repo->delete($userId);
    // }

}
