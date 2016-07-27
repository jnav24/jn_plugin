jQuery(function($) {
    $('a[href="#"]').on('click', function(e) {
        e.preventDefault();
    });

    /*
    |--------------------------------------------------------------------------
    | Callables
    |--------------------------------------------------------------------------
    |
    | All ajax calls
    |
    */

    function Callables() {
        this.deleteRow = function (id, action, row) {
            $.ajax({
                url: window.location.href,
                method: "POST",
                data: {
                    "id": id,
                    "page_action": action
                },
                success: function (response) {
                    row.fadeOut(function () {
                        $(this).remove();
                    });
                }
            });
        };
    }

    /*
    |--------------------------------------------------------------------------
    | Popups
    |--------------------------------------------------------------------------
    |
    | Everywhere in the plugin that has a delete the functionality is here.
    |
    */

    function Popup()
    {
        var popup = this,
            rowObj;

        var getResponse = function (dis) {
            var response = dis.data('respond');
            if(response > 0)
            {
                var callable = new Callables();
                callable.deleteRow(rowObj.id, rowObj.delete, rowObj.row);
            }
        };

        this.confirm = function(msg, dis) {
            rowObj = dis;
            this.showPopup(msg);
        };

        this.showPopup = function(msg) {
            $('.popup__container').addClass('show');
            $('<p>' + msg + '</p>').prependTo('.popup__container--box .popup__container--msgs');
        };

        this.hidePopup = function(dis) {
            $('.popup__container').removeClass('show');
            $('.popup__container--msgs').text('');
            getResponse(dis);
        };
    }

    var popup = new Popup();

    $('.popup a').on('click', function() {
        popup.hidePopup($(this));
    });

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

    $('.wp-list-table').on('click','.remove_media', function() {
        var dump = {
            'delete' : 'delete',
            'id' : $(this).data('id'),
            'row' : $(this).closest('tr'),
        };

        popup.confirm('Are you sure?', dump);
    });

    $('.col_container').on('click','.remove_module', function() {
        var dump = {
            'delete' : 'module-delete',
            'id' : $(this).data('id'),
            'row' : $(this).closest('.module_each'),
        };

        popup.confirm('Are you sure?', dump);
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