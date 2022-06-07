<script>
export default {
    props: {
        labelFor: String,
        labelText: String,
        inputType: {
            type: String,
            default: 'text',
        },
        isRequired: {
            type: Boolean,
            default: false,
        },
        error: Array,
        modelValue: String,
    },

    methods: {
        updateValue(event) {
            this.$emit('update:modelValue', event.target.value);
        }
    },
};
</script>

<template>
    <div>
        <label :for="labelFor" class="block font-semibold text-gray-700">
            {{ labelText }} <span v-if="isRequired" class="text-red-500">*</span>
        </label>

        <input
            :type="inputType"
            :id="labelFor"
            :value="modelValue"
            @input="updateValue"
            class="block mt-1 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-400 focus:ring-opacity-50 rounded-md shadow-sm"
            :class="{'border-red-500' : error}"
        />

        <span class="text-red-600" v-if="error">{{ error[0] }}</span>
    </div>
</template>
