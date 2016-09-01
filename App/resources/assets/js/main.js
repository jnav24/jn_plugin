import Vue from 'vue'
import Sortable from 'vue-sortable'
import VueResource from 'vue-resource'
import ModulesEdit from './components/ModulesEdit.vue'
import PageCreateModules from './components/PageCreateModules.vue'

Vue.use(VueResource)
Vue.use(Sortable)
// Vue.config.delimiters = ['[[', ']]'];

new Vue({
    el: '.wrap',
    data: {},
    components: { ModulesEdit, PageCreateModules },
    methods: { }
});

document.getElementsByTagName('body')[0].addEventListener('click', function(e) {
    if(e.target && e.target.nodeName == 'A' && e.target.getAttribute('href') == '#')
    {
        e.preventDefault();
    }
});

document.getElementById('jn_plugin').addEventListener('submit', function(e) {
    e.preventDefault();
});

document.getElementsByTagName('BODY')[0].insertAdjacentElement('afterbegin', document.getElementsByClassName('popup__bkgd')[0]);

















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

        popup.confirm('Are you sure?', dump);
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
