<?php

namespace App\Livewire;

use Livewire\Component;
use App\DbRepo\TodoRepo;
use Livewire\Attributes\Rule;
use Livewire\WithPagination;

class Todo extends Component
{

    use WithPagination;
    protected $repo;

    #[Rule('required|min:3')]
    public $todo = '';
    #[Rule('required|min:3')]
    public $currentEditTodo;

    public $edit;

    public $users;

    public function mount()
    {
        $this->users = $this->repo->getAllUsers();
    }

    public function boot(TodoRepo $repo)
    {
        $this->repo = $repo;
    }

    public function addTodo(){

        $validated = $this->validateOnly('todo');
        $this->repo->save($validated);
        $this->todo = '';
    }

    public function editTodo($todoId)
    {
        $todo = $this->repo->getTodo($todoId);
    
        // Check if the authenticated user is an admin
        if (auth()->user()->role === 'Admin') {
            $this->edit = $todoId;
            $this->currentEditTodo = $todo->todo;
        } else {
            $this->edit = $todoId;
            $this->currentEditTodo = $todo->todo;
            session()->flash('error', 'You are not authorized to edit this todo.');
        }
    }
    

    public function updateTodo($todoId){
        $validated = $this->validateOnly('currentEditTodo');
        // dd($validated);
        $this->repo->update($todoId, $validated['currentEditTodo']);
        $this->cancelEdit();
    }

    public function cancelEdit(){
        $this->edit ='';
    }

    public function deleteTodo($todoId){
        $this->repo->delete($todoId);
    }

    public function markAsCompleted($todoId){
        return $this->repo->completed($todoId);
    }

    public function getAllUsers()
    {
        $users=$this->repo->getAllUsers();
        dd($users);

        return $users;
    }

    public function render()
    {
        $todos = $this->repo->getAllTodos();
        return view('livewire.todo', compact('todos'));
    }
}
