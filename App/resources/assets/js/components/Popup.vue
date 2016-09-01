<template>
    <div class="popup popup__bkgd" transition="popup" v-show="popup"></div>

    <div class="popup popup__container" transition="popup" v-show="popup">
        <div class="popup__container--box">
            <div class="popup__container--icon">?</div>
            <div class="popup__container--msgs"><slot></slot></div>
            <a href="#" class="flat_btn btn__save" @click="popupAction(1)">Yes</a>
            <a href="#" class="flat_btn" @click="popupAction(0)">No</a>
        </div>
    </div>
</template>

<script>
    export default {
        props: ['popup'],
        data() {
            return  {
                popup_result: '',
                popup_confirm: ''
            }
        },
        methods: {
            popupAction: function(id) {
                this.popup = false;
                this.$emit('hidepopup');
                this.$dispatch('popupResults', id);
//                this.$parent.setPopupResult(id);
//                this.$parent.hidePopup();
            }
        }
    }
</script>

<style lang="sass">
    .popup-transition {
        transition: 0.5s opacity ease;

        .popup__container--box {
            transition: 0.5s all ease;
        }
    }

    .popup-enter, .popup-leave {
        opacity: 0;
        transition: 0.5s all ease;

        .popup__container--box {
            transform: scale(1.5);
            transition: 0.5s all ease;
        }
    }
</style>