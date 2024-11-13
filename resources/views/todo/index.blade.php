<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Todo List</title>
</head>

<body>
<div class="container">
    <h1>Todo List</h1>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>Title</th>
            <th>Description</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody id="todo-table-body">
        @foreach($todo as $item)
            <tr data-id="{{ $item->id }}" data-update-route="{{ route('todo.update', $item->id) }}">
                <td contenteditable="true" class="editable" data-field="title">{{ $item->title }}</td>
                <td contenteditable="true" class="editable" data-field="description">{{ $item->description }}</td>
                <td>
                    <select class="form-select editable" data-field="status">
                        <option value="To do" {{ $item->status == 'To do' ? 'selected' : '' }}>To do</option>
                        <option value="In progress" {{ $item->status == 'In progress' ? 'selected' : '' }}>In progress</option>
                        <option value="Finished" {{ $item->status == 'Finished' ? 'selected' : '' }}>Finished</option>
                    </select>
                </td>
                <td>
                    <button class="btn btn-danger btn-sm delete-btn" data-destroy-route="{{ route('todo.destroy', $item->id) }}">Delete</button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <button id="create-todo" class="btn btn-success" data-store-route="{{ route('todo.store') }}">Create Todo</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/action.js') }}"></script>
</body>

</html>
