<?php 
namespace App\DbRepo;
use App\Models\Todo;
use App\Notifications\TodoDeletedNotification;


class TodoRepo
{
    public function save($data)
    {
        $createTodo = auth()->user()->todos()->create($data);
        if ($createTodo) {
            return $createTodo;
        }
    }

    public function getTodo($todoId){
        return auth()->user()->todos()->find($todoId);
    }

    public function getAllTodos(){
        // Check if the user is an admin
        if(auth()->user()->role === 'Admin') {
            $todos = Todo::latest()->get();
        } else {
            // For non-admin users, only retrieve their own todos
            $todos = Todo::where('user_id', auth()->id())->latest()->get();
        }
    
        return $todos;
    }
    

    public function update($todoId, $currentEditTodo){
        $todo = $this->getTodo($todoId);
        $todo->update([
            'todo' => $currentEditTodo
        ]);
    }

    public function completed($todoId){
        $todo = $this->getTodo($todoId);
        return ($todo->is_completed) ? $todo->update(['is_completed' => false]) : $todo->update(['is_completed'=>true]);
    }

    public function delete($todoId){
        return $this->getTodo($todoId)->delete();
    }

    public function getTodosById($userId){
        $todos=Todo::where('user_id',$userId)->get();
        return $todos;
    }
}