<?php 
namespace App\DbRepo;

use App\Models\Todo;
use App\Notifications\TodoDeletedNotification;
use Illuminate\Support\Facades\DB;


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
            $todos = Todo::latest()->paginate(10);
        } else {
            // For non-admin users, only retrieve their own todos
            $todos = Todo::where('user_id', auth()->id())->latest()->paginate(10);
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
    // Start a database transaction
    DB::beginTransaction();

    try {
        $todo = Todo::findOrFail($todoId);

        // Check if $todo is not null
        if ($todo) {
            if ($todo->user) {
                $user = $todo->user;
                $todo->delete();
                // Queue the notification to be sent to the user
                $user->notify(new TodoDeletedNotification());
            } else {
                throw new \Exception('Todo does not have an associated user.');
            }
        } else {
            throw new \Exception('Todo does not exist.');
        }

        // Commit the transaction if all operations succeed
        DB::commit();
    } catch (\Exception $e) {
        // Rollback the transaction if an error occurs
        DB::rollback();
        throw $e;
    }
}

    
    

    public function getTodosById($userId){
        $todos=Todo::where('user_id',$userId)->get();
        return $todos;
    }
}