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

    public function boot(TodoRepo $repo)
    {
        $this->repo = $repo;
    }

    public function addTodo(){

        $validated = $this->validateOnly('todo');
        $this->repo->save($validated);
        $this->todo = '';
    }

    public function editTodo($todoId){
        $this->edit =$todoId;
        $this->currentEditTodo = $this->repo->getTodo($todoId)->todo;
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

    public function render()
    {
        $todos = $this->repo->getAllTodos();
        return view('livewire.todo', compact('todos'));
    }
}
