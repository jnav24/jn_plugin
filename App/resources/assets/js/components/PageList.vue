<template>
    <div class="col_container">
        <input type="text" v-model="search_filter">
        {{ search_filter }}
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
        <div class="col_container sext" v-for="page in pages | filterBy search_filter">
            <div class="col"><strong><a href="{{ url }}{{ page.page_url|lowercase }}">{{ page.page_name }}</a></strong></div>
            <div class="col">{{ getUserName(page.created_by) }}</div>
            <div class="col">{{ getUserName(page.modified_by) }}</div>
            <div class="col">{{ page.updated_at|date 'm/d/Y h:i a' }}</div>
            <div class="col">Publish{{ page.page_status }}</div>
            <div class="col"><a href="#" @click="">Delete Page</a></div>
        </div>

        <div class="col_empty" v-else>There are no pages.</div>
    </div>
</template>

<script>
    export default {
        props: ['pages', 'url'],
        created() {
            this.pages = JSON.parse(this.pages);
        },
        data() {
            return {
                search_filter: '',
                columns: []
            }
        },
        methods: {
            getUserName: function(id) {
                return 'Admin'
//                this.$http(window.location.href, {page_action: users-retrieve, id: id}).then((response) => {});
            }
        }
    }
</script>