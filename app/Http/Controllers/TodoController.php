<?php

namespace App\Http\Controllers;

use App\Http\Services\TodoService;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct(protected TodoService $todoService)
    {
    }

    public function index()
    {
        $todo = Todo::all();
        return view('todo.index', compact('todo'));
    }

    public function create()
    {
        return view('todo.add-edit');
    }

    public function edit(Todo $todo)
    {
        return view('todo.add-edit', compact('todo'));
    }

    public function store(Request $request)
    {
        $todo = $this->todoService->store($request);
        return redirect()->route('todo.index')->with('success', 'Todo ' . $todo->title . ' created successfully.');
    }

    public function update(Request $request, Todo $todo)
    {
        $todo = $this->todoService->store($request, $todo);
        return redirect()->route('todo.index')->with('success', 'Todo ' . $todo->title . ' updated successfully.');
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return redirect()->route('todo.index')->with('success', 'Todo ' . $todo->title . ' deleted successfully.');
    }
}
