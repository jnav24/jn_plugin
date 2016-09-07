<template>
    blah

    <a href="#" v-for="page in pages" @click="updateCurrent(page)">{{ page + 1 }}</a>
</template>

<script>
    export default {
        props: ['data', 'paginate'],
        computed: { },
        data() {
            return {
                current: 0,
                pages: 0
            }
        },
        methods: {
            sortDataList: function() {
                let firstIndex = this.paginate * this.current;
                let lastIndex = (this.paginate * (this.current + 1));
                this.$parent.paginate_data = this.data.slice(firstIndex, lastIndex);
                this.pages = Math.ceil(this.data.length / this.paginate);
            },
            updateCurrent: function(current) {
                this.current = current;
                this.sortDataList();
            }
        },
        ready() {
            this.sortDataList();
        }
    }
</script>