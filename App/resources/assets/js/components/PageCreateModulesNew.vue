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

    <div class="module_create">
        <div class="col_wrapper">
            <h2 class="page_create_header">
                Create a Page
            </h2>

            <p class="page_create_text">
                The modules listed below are going to be the modules that will be available on your page.
                You can sort the order of how you want the modules to be on the page by clicking and dragging the blue move button.
            </p>

            <alerts type="error"><strong>Oops!</strong> Make sure you have entered a name and add a module.</alerts>

            <input type="text" name="page_name" placeholder="Enter Page Name">

            <label for="page_type">Page Category</label>
            <select name="page_type">
                <option value="uncategorized">Uncategorized</option>
            </select>
        </div>

        <!--<div class="list-group" v-sortable="{ handle: '.fa-arrows' }">-->
            <!--<page-insert-module :modules="page_modules"></page-insert-module>-->
        <!--</div>-->
        <div class="list-group" id="modules_all">
            <div v-for="page in page_html" track-by="$index">{{{ page }}}</div>
        </div>
    </div>

    <div class="module_save">
        <slot></slot>
    </div>
</template>

<script>
    import Alerts from '../components/Alerts.vue'
    import PageInsertModule from './PageInsertModule.vue'

    export default {
        props: [
            'base_url',
            'modules',
            'page_data'
        ],
        data() {
            return {
                page_data: {
                    'base_url': 'http://localhost/wp-test/wp-admin/admin.php',
                    'page_modules': [
                        {
                            'module_banner_2': {
                                'banner_img': 'thumbnail.png',
                                'banner_name': 'This banner',
                                'banner_alt_text': 'yo momma',
                                'banner_captions': 'Luke. I am your father.'
                            }
                        }
                    ]
                },
                page_html: [],
                page_modules: []
            }
        },
        created() {
            this.modules = JSON.parse(this.modules);
            this.getModule(this.page_data);
        },
        components: {
            Alerts,
            PageInsertModule
        },
        methods: {
            addModule: function(module) {
                const current_module = this.getModuleIndex(module.module_file);
                let obj = {};
                obj[current_module] = {};
                let page_data = {
                    'base_url': this.base_url,
                    'page_modules': []
                };
                page_data['page_modules'].push(obj);
                this.getModule(page_data);
            },
            animateBtn: function(module) {
                module.module_animate = false;
                setTimeout(
                        () => module.module_animate = true,
                        500
                );
            },
            getModule: function(page_data) {
                const vue = this;
                let module_file;

                page_data['page_modules'].forEach((v, i) => {
                    let module_key = Object.keys(v);
                    module = vue.getModuleName(module_key[0]);
                    vue.$http.post(page_data.base_url, {
                        page_action: 'module-retrieve',
                        module_int: module.module_int,
                        module_name: module.module_file,
                        module_data: v[module_key[0]]
                    }).then((response) => {
                        vue.page_html.push(response.body);
                    });
                });
            },
            getModuleIndex: function(module) {
                let item = document.querySelectorAll("div.module__layout[data-module='" + module + "']");
                let count = 0;

                if(item != null)
                {
                    count = item.length;
                }

                return module + '_' + count;
            },
            getModuleName: function(name) {
                name = name.split('_');
                return { module_file: name[0] + '_' + name[1], module_int: '_' + name[2] };
            }
        }
    }
</script>