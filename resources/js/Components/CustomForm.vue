<script>
import BreezeButton from '@/Components/Button.vue';

export default {
    components: {
        BreezeButton,
    },

    props: {
        formType: String,
        submitButtonText: String,
        processing: {
            type: Boolean,
            default: false,
        },
    },

    methods: {
        submit() {
            if (this.formType === 'create') {
                this.$emit('store');
            }

            if (this.formType === 'edit') {
                this.$emit('update');
            }
        }
    }
};
</script>

<template>
    <div>
        <form @submit.prevent="submit">
            <slot name="formFields" />

            <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
                <BreezeButton class="flex items-center ml-auto" :class="{ 'opacity-25': this.processing }" :disabled="this.processing" @click.prevent="submit">{{ this.submitButtonText }}</BreezeButton>
            </div>
        </form>
    </div>
</template>
