<template>
    <div class="module_list">
        <div class="module_each" v-for="module in modules">
            <p>{{ module.module_file }}</p>

            <div class="module_each-btn">
                <a href="#" @click="addModule(module)" class="round flat_btn btn__save">+</a>
            </div>
        </div>

        <div class="module_none" v-show="!modules.length">There are no modules.</div>
    </div>

    <div class="module_save">
        <slot></slot>
    </div>

    <div class="module_create col_wrapper">
        <h2 class="page_create_header">Create a Page</h2>
        <p class="page_create_text">
            The modules listed below are going to be the modules that will be available on your page.
            You can sort the order of how you want the modules to be on the page by clicking and dragging the blue move button.
        </p>

        <alerts type="error"><strong>Oops!</strong> Make sure you have entered a name and add a module.</alerts>

        <input type="text" name="page_name" placeholder="Enter Page Name">

        <div class="list-group" v-sortable="{ handle: '.fa-arrows' }">
            <page-insert-module :modules="page_modules"></page-insert-module>
        </div>
    </div>
</template>

<script>
    import Alerts from '../components/Alerts.vue'
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
            Alerts,
            PageInsertModule
        },
        methods: {
            addModule: function(module) {
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