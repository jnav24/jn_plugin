<template>
    <a href="#" v-for="page in total_pages" @click="updateCurrent(page)">{{ page + 1 }}</a>
</template>

<script>
    export default {
        props: {
            data: {
                required: true
            },
            paginate: {
                required: true
            }
        },
        computed: { },
        data() {
            return {
                current: 0,
                total_pages: 0
            }
        },
        methods: {
            sortDataListOld: function() {
                let firstIndex = this.paginate * this.current;
                let lastIndex = (this.paginate * (this.current + 1));
                this.$parent.paginate_data = this.data.slice(firstIndex, lastIndex);
                this.total_pages = Math.ceil(this.data.length / this.paginate);
            },
            updateCurrent: function(current) {
                this.current = current;
                this.sortDataList();
            },
            sortDataList: function() {
                let firstIndex = this.paginate * this.current;
                let lastIndex = (this.paginate * (this.current + 1));
                let pagination = this;
                console.log(this.resource_data.length);

                if(!this.resource_data.length)
                {
                    this.data.forEach(function(v, i) {
                        pagination.resource_data.push(v);
                        pagination.resource_data[i].paginate_show = 0;

                        if(i >= firstIndex && i < lastIndex)
                        {
                            console.log(pagination.resource_data[i].page_name);
                            pagination.resource_data[i].paginate_show = 1;
                        }
                    });
                }
                else
                {
                    this.resource_data.forEach(function(v, i) {
                        v.paginate_show = 0;

                        if(i >= firstIndex && i < lastIndex)
                        {
                            console.log(v.page_name);
                            v.paginate_show = 1;
                        }
                    });
                }

//                this.$parent.paginate_data = this.resource;
//                this.$set('resource', this.resource);
                console.log(this.resource_data);
                this.total_pages = Math.ceil(this.resource_data.length / this.paginate);
            }
        },
        created() {
//            this.sortDataList();
        }
    }
</script>