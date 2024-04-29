<?php

namespace App\Livewire;

use Livewire\Component;
use App\DbRepo\UsersRepo;

class Users extends Component
{
    protected $repo;

    public function boot(UsersRepo $repo)
    {
        $this->repo = $repo;
    }

    public function render()
    {
        $users=$this->repo->getAllUsers();


        // dd('isaac');
        return view('users');
    }
}
