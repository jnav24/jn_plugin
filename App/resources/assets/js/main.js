require('./instances/module_edit.js');
// require('./instances/page_create.js');

import Vue from 'vue'
import VueResource from 'vue-resource'
import Sortable from 'vue-sortable'
import MyForm from './components/MyForm.vue'
import PageCreateModules from './components/PageCreateModules.vue'
import PageCreateModulesNew from './components/PageCreateModulesNew.vue'
import PageList from './components/PageList.vue'

Vue.use(VueResource);
Vue.use(Sortable);

Vue.filter('date', function(output, format) {
    let date = new Date(output);
    let results = '';
    format = format.split('');
    format.map(function(elem) {
        if(elem.toLowerCase() == 'm')
        {
            results += date.getMonth() + 1;
        }
        else if(elem.toLowerCase() == 'd')
        {
            results += date.getDate();
        }
        else if(elem == 'y')
        {
            results += date.getYear();
        }
        else if(elem == 'Y')
        {
            results += date.getFullYear();
        }
        else if(elem == 'H')
        {
            results += date.getHours()
        }
        else if(elem == 'h')
        {
            let hour = date.getHours();
            if(hour > 12)
            {
                hour = hour - 12;
            }
            results += hour;
        }
        else if(elem.toLowerCase() == 'i')
        {
            let mins = date.getMinutes();
            results += (mins < 10 ? '0' + mins : mins);
        }
        else if(elem == 'a')
        {
            let hour = 'am';
            if(date.getHours() > 12)
            {
                hour = 'pm';
            }
            results += hour;
        }
        else
        {
            results += elem;
        }
    });
    return results;
});

new Vue({
    el: '.wrap',
    components: { MyForm, PageCreateModules, PageCreateModulesNew, PageList }
});

document.getElementsByTagName('body')[0].addEventListener('click', function(e) {
    if(e.target && e.target.nodeName == 'A' && e.target.getAttribute('href') == '#')
    {
        e.preventDefault();
    }
});

document.getElementById('jn_plugin').addEventListener('submit', function(e) {
    if(document.querySelectorAll('input[name="page_action"]')[0].value == 'page-store')
    {
        console.log(document.querySelectorAll('.list-group-item.empty').length);
        console.log(document.querySelectorAll('input[name="page_name"]')[0].value.trim() == '');
        if(document.querySelectorAll('input[name="page_name"]')[0].value.trim() == '' || document.querySelectorAll('.list-group-item.empty').length > 0)
        {
            console.log('Page not submitted');
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

const page_status = document.querySelectorAll('.page_status .col');
page_status.forEach(function(v, i) {
    v.addEventListener('click', () => {
        if (v.className == 'col selected') {
            return;
        }

        document.getElementById('page_status').value = v.getAttribute('data-status');
        let selected = document.getElementsByClassName('col selected')[0];
        selected.className = 'col';
        v.className = 'col selected';
        console.log(document.getElementById('page_status').value);
    });
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
