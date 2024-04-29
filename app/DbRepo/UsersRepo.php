<?php 
namespace App\DbRepo;

use App\Models\User;


class UsersRepo
{

    
    public function getAllUsers()
    {
        return User::all();
    }

}