<?php

namespace App\Http\Services;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoService
{
    public function store(Request $request, Todo $todo = null)
    {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        if ($request->isMethod('POST')) {
            $todo = new Todo();
        }

        $todo->title = $request->input('title');
        $todo->description = $request->input('description');
        $todo->status = $request->input('status');
        $todo->save();

        return $todo;
    }
}
