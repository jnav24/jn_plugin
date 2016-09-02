require('./instances/module_edit.js');
require('./instances/page_create.js');
require('./instances/page_list.js');

document.getElementsByTagName('body')[0].addEventListener('click', function(e) {
    if(e.target && e.target.nodeName == 'A' && e.target.getAttribute('href') == '#')
    {
        e.preventDefault();
    }
});

document.getElementById('jn_plugin').addEventListener('submit', function(e) {
    if(document.querySelectorAll('input[name="page_action"]')[0].value == 'page-store')
    {
        if(document.querySelectorAll('input[name="page_name"]')[0].value.trim() == '')
        {
            e.preventDefault();
            document.querySelectorAll('.alert')[0].style.display = 'block';
        }
    }

    if(document.querySelectorAll('input[name="page_action"]')[0].value == 'module-update')
    {
        let modulesAll = document.querySelectorAll('input[name^="module_file"]');

        modulesAll.forEach(function(input, index) {
            if(input.value.trim() == '')
            {
                e.preventDefault();
                document.querySelectorAll('.alert-error')[0].style.display = 'block';
            }
        });
    }
});



















var $ = require('jquery');

$(function() {
    
    /*
     |--------------------------------------------------------------------------
     | Callables
     |--------------------------------------------------------------------------
     |
     | All ajax calls
     |
     */

    function Callables() {
        this.deleteRow = function (id, action) {
            $.ajax({
                url: window.location.href,
                method: "POST",
                data: {
                    "id": id,
                    "page_action": action
                },
                success: function (response) {
                    // nothing here...
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
                rowObj.row.fadeOut(function () {
                    $(this).remove();
                });
                var callable = new Callables();
                callable.deleteRow(rowObj.id, rowObj.delete);
            }
        };

        this.confirm = function(msg, dis) {
            rowObj = dis;
            this.showPopup(msg);
        };

        this.showPopup = function(msg) {
            $('.popup__container').removeClass('hide');
            setTimeout(function() {
                $('.popup__bkgd').fadeIn();
                $('.popup__container').addClass('show');
                $('<p>' + msg + '</p>').prependTo('.popup__container--box .popup__container--msgs');
            }, 250);
        };

        this.hidePopup = function(dis) {
            $('.popup__container').removeClass('show');
            $('.popup__bkgd').fadeOut();
            setTimeout(function() {
                $('.popup__container--msgs').text('');
                $('.popup__container').addClass('hide');
            }, 500);
            getResponse(dis);
        };
    }

    var popup = new Popup();

    $('.popup a').on('click', function() {
        // popup.hidePopup($(this));
    });

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

        // popup.confirm('Are you sure?', dump);
    });

    $('.col_container').on('click','.remove_module', function() {
        var dump = {
            'delete' : 'module-delete',
            'id' : $(this).data('id'),
            'row' : $(this).closest('.module_each'),
        };

        // popup.confirm('Are you sure?', dump);
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
