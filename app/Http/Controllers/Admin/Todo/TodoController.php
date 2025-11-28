<?php

namespace App\Http\Controllers\Admin\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Todo;
use App\Http\Requests\Todo\TodoRequest;
use App\Http\Requests\Todo\UpdateTodoRequest;


class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::role('user')->get();  

        $todos = Todo::with('assignedUser')->orderBy('created_at', 'desc')->paginate(10);
    
        return view('admin.todo.index', compact('users', 'todos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TodoRequest $request)
    {
        Todo::create([
            'task_name' => $request->task_name,
            'due_date'   => $request->due_date,
            'assigned_to' => $request->assigned_to,
            'priority' => $request->priority,
            'status' => 'pending', // default
        ]);
    
        return back()->with('success', 'Task Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $todo  = Todo::findOrFail($id);
        $users = User::role('user')->get();

        return view('admin.todo.edit', compact('todo', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTodoRequest $request, string $id)
    {
       
        $todo = Todo::findOrFail($id);

        $todo->update([
            'task_name'   => $request->task_name,
            'assigned_to' => $request->assigned_to,
            'due_date'    => $request->due_date,
            'priority'    => $request->priority,
            'status'      => $request->status,
        ]);

        return back()->with('success', 'Task Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Todo::findOrFail($id)->delete();
        return back()->with('success', 'Task Deleted');
    }
}
