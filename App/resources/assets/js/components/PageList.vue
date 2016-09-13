<template>
    <popup :popup="popup">Are you sure you want to delete this page?</popup>

    <div class="col_container filter_search">
        <!--<select v-model="search_from">-->
            <!--<option value="page_name" selected>Page Name</option>-->
            <!-- Commented because you can not search by username. You are currently able to search by user id. -->
            <!--<option value="created_by">Created By</option>-->
            <!--<option value="modified_by">Modified By</option>-->
        <!--</select>-->
        <input type="text" v-model="search_filter" @keyup="updatePaginate" placeholder="Search">

        <div class="filter_search_status">
            <div class="col" :class="{'selected': status_filter == ''}" @click="setStatus('')">All</div>
            <div class="col" :class="{'selected': status_filter == 'publish'}" @click="setStatus('publish')">Publish</div>
            <div class="col" :class="{'selected': status_filter == 'draft'}" @click="setStatus('draft')">Draft</div>
        </div>
    </div>
    
    <div class="col_container sext col_head">
        <div class="col">Page Title</div>
        <div class="col">Created By</div>
        <div class="col">Modified By</div>
        <div class="col">Last Updated</div>
        <div class="col">Status</div>
        <div class="col">Delete</div>
    </div>

    <div class="col_row_wrapper">
        <div class="col_container sext" v-for="page in pages | filterBy search_filter in 'page_name' | filterBy status_filter in 'page_status'" v-show="setPaginate($index)">
            <div class="col"><strong class="v_center"><a href="{{ url }}{{ page.page_url|lowercase }}">{{ page.page_name }}</a></strong></div>
            <div class="col"><span class="v_center">{{ getUserName(page.created_by) }}</span></div>
            <div class="col"><span class="v_center">{{ getUserName(page.modified_by) }}</span></div>
            <div class="col"><span class="v_center">{{ page.updated_at|date 'm/d/Y h:i a' }}</span></div>
            <div class="col"><span class="v_center">{{ page.page_status }}</span></div>
            <div class="col"><a href="#" @click="showPopup(page)" class="flat_btn btn__del">Delete Page</a></div>
        </div>

        <div class="col_empty" v-if="!pages.length">There are no pages.</div>
    </div>

    <div class="pagination">
        <a href="#" v-for="page_index in paginate_total" v-show="paginate_total > 1" @click="updateCurrent(page_index + 1)" class="pagination_link" :class="{'current': (page_index + 1) == current}">
            {{ page_index + 1 }}
        </a>
    </div>
</template>

<script>
    import Popup from './Popup.vue'

    export default {
        props: ['pages', 'url'],
        components: { Popup },
        created() {
            this.pages = JSON.parse(this.pages);
            this.paginate_total = this.pages.length / this.paginate;
        },
        data() {
            return {
                delete_page: {},
                columns: [],
                current: 1,
                paginate: 10,
                paginate_total: 0,
                popup: false,
                search_filter: '',
                search_from: '',
                status_filter: ''
            }
        },
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
            updateCurrent: function(i) {
                this.current = i;
            },
            updatePaginate: function() {
                this.current = 1;
                this.paginate_total = Math.ceil(document.querySelectorAll('.col_row_wrapper .col_container').length / this.paginate);
            },
            setPaginate: function(i) {
                if (this.current == 1) {
                    return i < this.paginate;
                }
                else {
                    return (i >= (this.paginate * (this.current - 1)) && i < (this.current * this.paginate));
                }
            },
            getUserName: function(id) {
                return 'Admin';
//                this.$http(window.location.href, {page_action: users-retrieve, id: id}).then((response) => {});
            },
            showPopup: function(page) {
                this.popup = true;
                this.delete_page = page;
            },
            hidePopup: function () {
                this.popup = false;
            },
            setStatus: function(filter_text) {
                this.status_filter = filter_text;
                this.$nextTick(function() {
                    this.updatePaginate();
                });
            }
        }
    }
</script>