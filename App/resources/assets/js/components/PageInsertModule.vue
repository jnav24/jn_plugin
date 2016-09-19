<template>
    <div class="module_each list-group-item" v-for="module in modules" track-by="$index">
        <p>{{ module.module_image }}</p>

        <div class="module_each-btn clearfix">
            <div class="module_close round" @click="removeModule(module)">
                <i class="fa fa-trash"></i>
            </div>

            <div class="module_move round">
                <i class="fa fa-arrows"></i>
            </div>
        </div>

        <input type="hidden" name="modules[{{ module.module_index }}]">
    </div>

    <div class="list-group-item empty" v-if="!modules.length">
        <p>Added modules will appear here.</p>
    </div>
</template>

<script>
    export default {
        props: ['modules'],
        methods: {
            removeModule: function(module)
            {
                this.modules.$remove(module);
            }
        }
    }
</script>