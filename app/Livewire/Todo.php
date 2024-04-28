<?php

namespace App\Livewire;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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

    public $userId; // public property to hold the user ID

    public function mount($userId)
    {
        $this->userId = $userId;
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

    public function editTodo($todoId){
        $this->edit =$todoId;
        $this->currentEditTodo = $this->repo->getUserTodo($todoId)->todo;
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

    // public function render()
    // {
    //     $todos = $this->repo->getAllTodos();
    //     return view('livewire.todo', compact('todos'));
    // }

    public function render()
{
    $user = Auth::user();
    if ($user->is_admin && $this->userId) {
        $todos = $this->repo->getAllUserTodos($this->userId);
        return view('livewire.admin-todo', compact('todos', 'users'));
    } else {
        $todos = $this->repo->getUserTodos();
        return view('livewire.todo', compact('todos'));
    }
}

    
}
