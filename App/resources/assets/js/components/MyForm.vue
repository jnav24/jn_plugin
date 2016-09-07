<template>
    <form action="" method="POST" id="jn_plugin" @submit.prevent="savePage">
        <slot></slot>
    </form>
</template>

<script>
    export default {
        props: ['url'],
        methods: {
            savePage: function() {
                let formData = new FormData(document.getElementById('jn_plugin'));
                console.log(formData);
//                var formData = new FormData(form)
                this.$http(this.url + 'test.php', formData).then((response) => {});
            }
        }
    }
</script>