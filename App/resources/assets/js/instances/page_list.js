import Vue from 'vue'
import VueResource from 'vue-resource'
import Popup from '../components/Popup.vue'

Vue.use(VueResource)

if(document.getElementById('page_list') != null)
{
    new Vue({
        el: '#page_list',
        data: {
            delete_page: {},
            popup: false
        },
        components: { Popup },
        events: {
            popupResults: function (id) {
                this.hidePopup();
                if(id)
                {
                    document.querySelectorAll('tr[data-id="' + this.delete_page.page_id+ '"]')[0].style.display = 'none';
                    this.$http.post('http://localhost/dev/wp-test/wp-admin/admin.php', {page_action: 'page-destroy', id: this.delete_page.page_id}).then((response) => {
                        this.delete_page = {};
                });
                }
            }
        },
        methods: {
            showPopup: function(page) {
                this.popup = true;
                this.delete_page = page;
            },
            hidePopup: function () {
                this.popup = false;
            }
        }
    });

    document.getElementsByTagName('BODY')[0].insertAdjacentElement('afterbegin', document.getElementsByClassName('popup__bkgd')[0]);
}