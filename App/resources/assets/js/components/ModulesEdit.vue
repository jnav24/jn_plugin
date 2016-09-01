<template>
    <popup :popup="popup" @hidepopup="resetPopup">wassup</popup>

    <p class="clearfix">
        <a href="#" class="add_module flat_btn btn__save" @click="addModule">Add Module</a>
    </p>
<!--<pre>{{ modules|json }}</pre>-->
    <div class="col main_col col_wrapper modules_edit">
        <div class="module_each third" v-for="module in modules" track-by="$index" transition="fade" v-show="module.module_animate">
            <div class="col">
                <input type="hidden" value="{{ module.module_id }}" name="module_id[]">
                <input type="hidden" value="{{ module.module_image }}" name="module_image[]">
            </div>

            <div class="col">
                <label for="module_file">Enter filename for module</label>
                <input type="text" value="{{ getModuleName(module.module_file) }}" name="module_file[]">
            </div>

            <div class="col">
                <a href="#" class="remove_module flat_btn btn__del" @click="showPopup(module)">Delete</a>
            </div>
        </div>

        <div class="module_empty" v-show="!modules.length">There are no modules.</div>
    </div>
</template>

<script>
    import Popup from './Popup.vue'

    export default {
        data() {
            return {
                delete_module: {},
                popup: false
            }
        },
        props: ['modules', 'url'],
        created() {
            this.modules = JSON.parse(this.modules);
        },
        components: { Popup },
        events: {
            popupResults: function(id) {
                if(id)
                {
                    this.delete_module.module_animate = false;
                    this.$http.post('http://localhost/dev/wp-test/wp-admin/admin.php', {page_action: 'module-destroy', id: this.delete_module.module_id}).then((response) => {
                        this.modules.$remove(module);
                        this.delete_module = {};
                    });
                }
            }
        },
        methods: {
            addModule: function() {
                this.modules.push({ module_id: '', module_file: '',  module_image: "", module_animate: 1});
            },
            resetPopup: function() {
                this.popup = false;
            },
            showPopup: function(module) {
                this.popup = true;
                this.delete_module = module;
            },
            getModuleName: function(file) {
                if(typeof file == 'undefined' || file == '')
                {
                    return '';
                }

                let split = file.split('_');

                if(split[1] == null)
                {
                    return "Error: name is not correct";
                }

                return split[1];
            }
        }
    }
</script>

<style>
    .fade-transition {
        transition: 0.5s opacity ease;
    }

    .fade-enter, .fade-leave {
        opacity: 0;
        transition: 0.5s all ease;
    }
</style>