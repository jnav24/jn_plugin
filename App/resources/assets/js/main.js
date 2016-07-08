jQuery(function($) {
    function deleteRow(id, action, row) {
        if (confirm("Are you want to remove this?")) {
            $.ajax({
                url: window.location.href,
                method: "POST",
                data: {
                    "id": id,
                    "page_action": action
                },
                success: function (response) {
                    console.log(response);
                    row.fadeOut(function () {
                        $(this).remove();
                    });
                }
            });
        }
    }

    $('.wp-list-table').on('click','.remove_media', function() {
        var page_id = $(this).data('id'),
            row = $(this).closest('tr');

        deleteRow(page_id, 'delete', row)
    });

    $('.col_container').on('click','.remove_module', function() {
        var id = $(this).data('id'),
            row = $(this).closest('.module_each');

        deleteRow(id, 'module-delete', row);
    });
});