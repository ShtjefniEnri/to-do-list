$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).on('blur', '.editable', function () {
        const row = $(this).closest('tr');
        const todoId = row.data('id');
        const updateUrl = row.data('update-route');
        const title = row.find('[data-field="title"]').text();
        const description = row.find('[data-field="description"]').text();
        const status = row.find('[data-field="status"]').val();

        if (todoId) {
            $.ajax({
                type: 'PUT',
                dataType: 'json',
                url: updateUrl,
                data: {title, description, status},
            });
        }
    });

    $(document).on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const destroyUrl = $(this).data('destroy-route');

        if (confirm('Are you sure you want to delete this todo?')) {
            $.ajax({
                type: 'DELETE',
                dataType: 'json',
                url: destroyUrl,
                success: row.remove(),
            });
        }
    });

    $('#create-todo').on('click', function () {
        const newRow = `<tr>
                            <td contenteditable="true" class="editable" data-field="title"></td>
                            <td contenteditable="true" class="editable" data-field="description"></td>
                            <td>
                                <select class="form-select editable" data-field="status">
                                    <option value="To do">To do</option>
                                    <option value="In progress">In progress</option>
                                    <option value="Finished">Finished</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm save-btn" disabled>Save</button>
                                <button class="btn btn-danger btn-sm delete-btn">Delete</button>
                            </td>
                        </tr>`;
        $('#todo-table-body').append(newRow);
    });

    $(document).on('input change', '.editable', function () {
        const row = $(this).closest('tr');
        const title = row.find('[data-field="title"]').text();
        const description = row.find('[data-field="description"]').text();
        const status = row.find('[data-field="status"]').val();

        if (title && description && status) {
            row.find('.save-btn').prop('disabled', false);
        } else {
            row.find('.save-btn').prop('disabled', true);
        }
    });

    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const storeUrl = $('#create-todo').data('store-route');
        const title = row.find('[data-field="title"]').text();
        const description = row.find('[data-field="description"]').text();
        const status = row.find('[data-field="status"]').val();

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: storeUrl,
            data: {title, description, status},
            success: function (response) {
                row.attr('data-id', response.id)
                    .attr('data-update-route', `/update/${response.id}`)
                row.find('.delete-btn').attr('data-destroy-route', `/destroy/${response.id}`);
                row.find('.save-btn').remove();
            },
        });
    });
});

