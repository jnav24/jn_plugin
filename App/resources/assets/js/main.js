jQuery(function($) {
    /*
    |--------------------------------------------------------------------------
    | Add modules on page create
    |--------------------------------------------------------------------------
    |
    | When creating a new page, this ensures the proper naming of inputs.
    | Also handles drag and drop.
    |
    */

    var getModuleIndex = function(module) {
        var count = $("input[name*='" + module + "']").length;
        return module + '_' + count;
    };

    // TODO:
    // add a remove button

    $('.module_list .module_each').draggable({
        appendTo: "body",
        helper: "clone"
    });

    $('.module_create').droppable({
        accept: ":not(.ui-sortable-helper)",
        drop: function(event, ui) {
            var str = ui.draggable.context.outerHTML,
                module = ui.draggable.context.attributes['data-module'].value;
            $(str.replace("ui-draggable ui-draggable-handle", "")).html("<input type='hidden' name='modules["+ getModuleIndex(module) +"]'>").appendTo(this)
        }
    }).sortable();

    /*
    |--------------------------------------------------------------------------
    | All deletes
    |--------------------------------------------------------------------------
    |
    | Everywhere in the plugin that has a delete the functionality is here.
    |
    |
    */

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


    /*
    |--------------------------------------------------------------------------
    | Form Names in all modules
    |--------------------------------------------------------------------------
    |
    | For all modules with a class of module__layout, this will rename your
    | form name appropriately
    |
    */

    $('.module__layout').each(function(index, value) {
        var module = $(value).data('module'),
            newName = 'modules[' + module + '_' + $('.module__layout').index($(value)) + ']';

        $(value).find('input, select, textarea').each(function(i, v) {
            var formName = $(v).attr('name'); // modules[module_banner]
            $(v).attr('name', formName.replace(formName, newName));
        });
    });
});