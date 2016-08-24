<template>
    <div class="module_create list-group-item" v-for="module in modules" track-by="$index">
        <p>{{ module.module_file }}</p>

        <div class="module_close">
            <i class="fa fa-trash"></i>
        </div>

        <input type="hidden" name="modules[{{ module.module_index }}]">
    </div>
</template>

<script>
    export default {
        props: ['modules'],
        methods: {}
    }
</script>