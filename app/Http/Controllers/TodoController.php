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
        try {
            $todo = $this->todoService->store($request);
            return response()->json([
                'success' => true,
                'message' => "Todo created successfully!",
                'id' => $todo->id
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], responseStatusCode($exception->getCode()));
        }
    }

    public function update(Request $request, Todo $todo)
    {
        try {
            $this->todoService->store($request, $todo);
            return response()->json([
                'success' => true,
                'message' => "Todo updated successfully!"
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], responseStatusCode($exception->getCode()));
        }
    }

    public function destroy(Todo $todo)
    {
        try {
            $todo->delete();
            return response()->json([
                'success' => true,
                'message' => "Todo deleted successfully!"
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], responseStatusCode($exception->getCode()));
        }
    }
}
