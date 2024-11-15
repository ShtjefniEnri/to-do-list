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

        const formData = new FormData();
        formData.append('_method', 'PUT');
        formData.append('title', row.find('[data-field="title"]').text());
        formData.append('description', row.find('[data-field="description"]').text());
        formData.append('status', row.find('[data-field="status"]').val());

        if (todoId) {
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: updateUrl,
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    showNotification(response.message, 'success');
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    showNotification(response.message, 'error');
                }
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
                success: function (response) {
                    row.remove();
                    showNotification(response.message, 'success');
                    resetCreateState();
                },
                error: function (xhr) {
                    const response = xhr.responseJSON;
                    showNotification(response.message, 'error');
                }
            });
        }
    });

    $('#create-todo').on('click', function () {
        $(this).prop('disabled', true);

        const newRow = $('<tr></tr>');

        const titleCell = $('<td></td>').attr('contenteditable', 'true').addClass('editable').attr('data-field', 'title');
        const descriptionCell = $('<td></td>').attr('contenteditable', 'true').addClass('editable').attr('data-field', 'description');

        const statusCell = $('<td></td>');
        const statusSelect = $('<select></select>').addClass('form-select editable').attr('data-field', 'status');
        statusSelect.append('<option value="To do">To do</option>');
        statusSelect.append('<option value="In progress">In progress</option>');
        statusSelect.append('<option value="Finished">Finished</option>');
        statusCell.append(statusSelect);

        const actionCell = $('<td></td>');
        const deleteButton = $('<button></button>').addClass('btn btn-danger btn-sm delete-btn').text('Delete').prop('disabled', true);
        actionCell.append(deleteButton);

        newRow.append(titleCell, descriptionCell, statusCell, actionCell);

        $('#todo-table-body').append(newRow);

        titleCell.focus();

        newRow.on('focusout', function () {
            setTimeout(() => {
                if (!newRow.find(':focus').length) {
                    const todoId = newRow.data('id');
                    const title = newRow.find('[data-field="title"]').text();

                    if (!todoId && title) {
                        saveNewTodo(newRow);
                        deleteButton.prop('disabled', false);
                    } else {
                        resetCreateState();
                    }
                    if (!todoId && !title) {
                        newRow.remove();
                    }
                }
            }, 10);
        });
    });

    function saveNewTodo(row) {
        const storeUrl = $('#create-todo').data('store-route');

        const formData = new FormData();
        formData.append('title', row.find('[data-field="title"]').text());
        formData.append('description', row.find('[data-field="description"]').text());
        formData.append('status', row.find('[data-field="status"]').val());

        $.ajax({
            type: 'POST',
            dataType: 'json',
            url: storeUrl,
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                row.attr('data-id', response.id)
                    .attr('data-update-route', `/update/${response.id}`)
                    .find('.delete-btn').attr('data-destroy-route', `/destroy/${response.id}`);
                row.find('.save-btn').remove();
                showNotification(response.message, 'success');
                resetCreateState()
            },
            error: function (xhr) {
                const response = xhr.responseJSON;
                showNotification(response.message, 'error');
                resetCreateState()
            }
        });
    }

    function showNotification(message, type) {
        const notification = $('#notification');
        notification.text(message).removeClass('success error').addClass(type).addClass('show');

        setTimeout(() => {
            notification.removeClass('show');
        }, 3000);
    }

    function resetCreateState() {
        $('#create-todo').prop('disabled', false);
    }
});

