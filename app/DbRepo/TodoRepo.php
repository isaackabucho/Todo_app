<?php 
namespace App\DbRepo;

use App\Models\User;
use app\Livewire\Todo;

class TodoRepo
{
    public function save($data)
    {
        $user = auth()->user();

        if ($user->is_admin) {
            // Admin can save todos for any user
            $createTodo = Todo::create($data);
        } else {
            // Regular user can only save todos for themselves
            $createTodo = $user->todos()->create($data);
        }

        return $createTodo;
    }

    public function getAllTodos($todoId)
    {
        // Fetch todo by ID, regardless of user
        return Todo::findOrFail($todoId);
    }

    public function getUserTodo($todoId){
        return auth()->user()->todos()->find($todoId);
    }

    // Get All Usert to do for A normal user
    public function getUserTodos(){
        $todos = auth()->user()->todos()->latest()->paginate(5);
        return $todos;
    }

    // All the todos for users for is_admin
    public function getAllUserTodos($userId)
    {
        // Fetch todos associated with a specific user
        $user = User::findOrFail($userId);
        $todos = $user->todos()->latest()->paginate(5);
        return $todos;
    }

    public function update($todoId, $currentEditTodo){
        $todo = $this->getUserTodo($todoId);
        $todo->update([
            'todo' => $currentEditTodo
        ]);
    }

    public function completed($todoId){
        $todo = $this->getUserTodo($todoId);
        return ($todo->is_completed) ? $todo->update(['is_completed' => false]) : $todo->update(['is_completed'=>true]);
    }

    public function delete($todoId){
        return $this->getUserTodo($todoId)->delete();
    }
}