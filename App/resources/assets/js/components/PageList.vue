<template>
    <div class="col_container sext" v-for="page in pages">
        <div class="col"><strong><a href="{{ url }}{{ page.page_url|lowercase }}">{{ page.page_name }}</a></strong></div>
        <div class="col">{{ getUserName(page.created_by) }}</div>
        <div class="col">{{ getUserName(page.modified_by) }}</div>
        <div class="col">{{ page.updated_at|date 'm/d/Y h:i a' }}</div>
        <div class="col">Publish{{ page.page_status }}</div>
        <div class="col"><a href="#" @click="">Delete Page</a></div>
    </div>
</template>

<script>
    export default {
        props: ['pages', 'url'],
        created() {
            this.pages = JSON.parse(this.pages);
        },
        methods: {
            getUserName: function(id) {
                return 'Admin'
//                this.$http('', {page_action: users-retrieve, id: id}).then((response) => {});
            }
        }
    }
</script>