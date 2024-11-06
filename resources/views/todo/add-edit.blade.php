@extends('layouts.layout')
@section('add-edit-field')
    <h2 class="my-4">{{ isset($todo) ? 'Edit Todo' : 'Create Todo' }}</h2>

    <form action="{{ isset($todo) ? route('todo.update', $todo->id) : route('todo.store') }}" method="POST">
        @csrf
        @if(isset($todo))
            @method('PUT')
        @endif

        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" class="form-control" id="title"
                   value="{{ old('title', $todo->title ?? '') }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" id="description" rows="4"
                      required>{{ old('description', $todo->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-control" id="status" required>
                <option value="To do" {{ old('status', $todo->status ?? '') == 'To do' ? 'selected' : '' }}>To do
                </option>
                <option value="In progress" {{ old('status', $todo->status ?? '') == 'In progress' ? 'selected' : '' }}>
                    In progress
                </option>
                <option value="Finished" {{ old('status', $todo->status ?? '') == 'Finished' ? 'selected' : '' }}>
                    Finished
                </option>
            </select>
        </div>

        <div>
            <button type="submit" class="btn btn-primary">
                {{ isset($todo) ? 'Update' : 'Save' }}
            </button>
            <a href="{{ route('todo.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
@endsection
