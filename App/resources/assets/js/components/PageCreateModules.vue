<template>
    <div class="col main_col right_big clearfix">
        <div class="col modules module_list col_wrapper">
            <div class="module_each" v-for="module in modules" data-module="{{ module.module_file }}" data-image="{{ module.module_image }}">
                <!--<p>{{ module.module_image }}</p>-->
                <a href="#" @click="addModule(module)">Add to page template</a>
            </div>
            <div class="module_none" v-show="!modules.length"> There are no modules.</div>
        </div>
        <div class="col modules">
            <div class="module_create col_wrapper list-group" v-sortable>
                <page-insert-module :modules="page_modules"></page-insert-module>
            </div>
        </div>
    </div>
</template>

<script>
    import PageInsertModule from './PageInsertModule.vue'

    export default {
        props: ['modules'],
        data() {
            return {
                page_modules: []
            }
        },
        created() {
            this.modules = JSON.parse(this.modules)
        },
        components: {
            PageInsertModule
        },
        methods: {
            addModule: function(module) {
                module.module_index = this.getModuleIndex(module.module_file);
                this.page_modules.push(module);
            },
            getModuleIndex: function(module) {
                let item = document.querySelectorAll("input[name*='" + module + "']");
                let count = 0;

                if(item != null)
                {
                    count = item.length;
                }

                return module + '_' + count;
            }
        }
    }
</script>