<template>
    <div class="col main_col right_big clearfix">
        <div class="col modules module_list col_wrapper">
            <div class="module_each" v-for="module in modules">
                <p>{{ module.module_image }}</p>
                <div class="module_each-btn">
                    <a href="#" @click="addModule(module)" class="round flat_btn btn__save" transition="btnpop" v-show="module.module_animate">+</a>
                </div>
            </div>
            <div class="module_none" v-show="!modules.length">There are no modules.</div>
        </div>
        <div class="col modules">
            <div class="module_create col_wrapper list-group" v-sortable="{ handle: '.fa-arrows' }">
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
                this.animateBtn(module);
                module.module_index = this.getModuleIndex(module.module_file);
                this.page_modules.push(module);
            },
            animateBtn: function(module) {
                module.module_animate = false;
                setTimeout(
                    () => module.module_animate = true,
                    500
                );
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

<style>
    .btnpop-transition {
        transition: 0.5s opacity ease;
    }

    .btnpop-enter, .btnpop-leave {
        opacity: 0;
        transform: scale(1.5);
        transition: 0.5s all ease;
    }
</style>