<template>
    <h4 class="alert alert-{{ type }}">
        <slot></slot>
    </h4>
</template>

<script>
    export default {
        props: ['type']
    }
</script>