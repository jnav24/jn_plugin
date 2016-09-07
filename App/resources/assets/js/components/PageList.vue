<template>
    <popup :popup="popup">Are you sure you want to delete this page?</popup>

    <div class="col_container">
        <select v-model="search_from">
            <option value="page_name" selected>Page Name</option>
            <!-- Commented because you can not search by username. You are currently able to search by user id. -->
            <!--<option value="created_by">Created By</option>-->
            <!--<option value="modified_by">Modified By</option>-->
        </select>
        <input type="text" v-model="search_filter">
        All <input type="radio" v-model="status_filter" value="" checked>
        publish <input type="radio" v-model="status_filter" value="publish">
        draft <input type="radio" v-model="status_filter" value="draft">
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
        <div class="col_container sext" v-for="page in paginate_data | filterBy search_filter in search_from | filterBy status_filter in 'page_status'">
            <div class="col"><strong><a href="{{ url }}{{ page.page_url|lowercase }}">{{ page.page_name }}</a></strong></div>
            <div class="col">{{ getUserName(page.created_by) }}</div>
            <div class="col">{{ getUserName(page.modified_by) }}</div>
            <div class="col">{{ page.updated_at|date 'm/d/Y h:i a' }}</div>
            <div class="col">{{ page.page_status }}</div>
            <div class="col"><a href="#" @click="showPopup(page)">Delete Page</a></div>
        </div>

        <div class="col_empty" v-if="!pages.length">There are no pages.</div>
    </div>

    <pagination :paginate="paginate" :data="pages"></pagination>
</template>

<script>
    import Popup from './Popup.vue'
    import Pagination from './Pagination.vue'

    export default {
        props: ['pages', 'url'],
        components: { Pagination, Popup },
        ready() {
            // get paginate index, 0 indexed
            // paginate index * total amount to show on page == first index
            // paginate index * total amount to show on page - 1 == last index
            console.log(this.pages.slice(0,1));
        },
        created() {
            this.pages = JSON.parse(this.pages);
        },
        data() {
            return {
                delete_page: {},
                columns: [],
                paginate: 2,
                paginate_data: {},
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
            }
        },
        ready() {
            console.log(this.paginate_data);
        }
    }
</script>