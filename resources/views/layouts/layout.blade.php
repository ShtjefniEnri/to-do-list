<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Todo List</title>
</head>

<body>
<div class="container">
    <h1>Todo List</h1>
    @yield('todo-field')
    @yield('add-edit-field')
</div>
</body>

</html>
