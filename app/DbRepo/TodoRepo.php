<?php 
namespace App\DbRepo;

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
        $todos = auth()->user()->todos()->latest()->paginate(5);
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
}