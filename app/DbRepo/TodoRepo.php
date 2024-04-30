<?php 
namespace App\DbRepo;

use App\Models\Todo;
use App\Models\User;
use App\Notifications\TodoDeletedNotification;
use Illuminate\Support\Facades\DB;
use App\Jobs\ProcessTodoDeletionJob;


class TodoRepo
{

    public function getAllUsers()
    {
        return User::all();
    }

    public function save($data)
    {
        $createTodo = auth()->user()->todos()->create($data);
        if ($createTodo) {
            return $createTodo;
        }
    }

    public function getTodo($todoId)
    {
        if(auth()->user()->role==="Admin"){
            $todo = Todo::findOrFail($todoId);
        }else{
            $todo = auth()->user()->todos()->find($todoId);

        }

        if (!$todo) {
            // Todo not found, throw an exception or handle the error as needed
            throw new \Exception("Todo with ID $todoId not found.");
        }

        return $todo;
}

    public function getAllTodos(){
        if(auth()->user()->role === 'Admin') {
            $todos = Todo::latest()->paginate(10);
        } else {
            $todos = Todo::where('user_id', auth()->id())->latest()->paginate(10);
        }
    
        return $todos;
    }


    

    public function update($todoId, $currentEditTodo){
        if(auth()->user()->role=="Admin"){
            $todo = Todo::findOrFail($todoId);
        }
        else{
            $todo = $this->getTodo($todoId);
        }

        $todo->update([
            'todo' => $currentEditTodo
        ]);
    }

    public function completed($todoId){
        $todo = $this->getTodo($todoId);
        return ($todo->is_completed) ? $todo->update(['is_completed' => false]) : $todo->update(['is_completed'=>true]);
    }



public function delete($todoId){

    try {
        $todo = Todo::findOrFail($todoId);

        if ($todo) {
            if ($todo->user) {
                $user = $todo->user;
                $todo->delete();
                ProcessTodoDeletionJob::dispatch($user);
            } else {
                throw new \Exception('Todo does not have an associated user.');
            }
        } else {
            throw new \Exception('Todo does not exist.');
        }

    } catch (\Exception $e) {
        throw $e;
    }
}

    
    

    public function getTodosById($userId){
        $todos=Todo::where('user_id',$userId)->get();
        return $todos;
    }
}