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

    public function store(Request $request)
    {
        $todo = $this->todoService->store($request);
        return response()->json(['success' => true, 'id' => $todo->id]);
    }

    public function update(Request $request, Todo $todo)
    {
        $this->todoService->store($request, $todo);
        return response()->json(['success' => true]);
    }

    public function destroy(Todo $todo)
    {
        $todo->delete();
        return response()->json(['success' => true]);
    }
}
