<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import FormInput from '@/Components/FormInput.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton, BreezeInput, BreezeLabel, FormInput,
        Head, Link, Swal,
    },

    props: {
        agency: Object,
    },

    data() {
        return {
            errors: null,
            form: {
                name: this.agency.name,
                email: this.agency.email,
                mobile: this.agency.mobile,
                contact_person: this.agency.contact_person,
            },
        };
    },

    methods: {
        updateAgency() {
            this.form.processing = true;

            let self = this;

            axios.put(route('agencies.update', this.agency.id), this.form)
                .then(res => {
                    this.form.processing = false;

                    if (res.data.status === 'success') {
                        this.errors = null;

                        Swal.fire({
                            icon: 'success',
                            title: 'Success !',
                            text: res.data.message,
                        });
                    }
                }).catch(error => {
                    this.form.processing = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },
    },
};
</script>

<template>
    <Head title="Edit Agency" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="hidden sm:block font-semibold text-xl text-gray-800 leading-tight">
                Agencies
            </h2>

            <h2 class="sm:hidden font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.appName }}
            </h2>
        </template>

        <h1 class="text-3xl font-bold">
            <Link class="text-indigo-800 tracking-widest hover:text-indigo-600 focus:text-indigo-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.index')">
                Agencies
            </Link>
            / Edit
        </h1>

        <div v-if="this.errors" class="max-w-5xl bg-red-200 text-red-800 py-4 px-4 rounded mt-6">
            Oops! There were some errors while updating the agency details.
        </div>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <form @submit.prevent="updateAgency">
                <div class="px-10 py-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <FormInput
                            labelText="Name:"
                            labelFor="name"
                            v-model="this.form.name"
                            :error="this.errors && this.errors.name"
                            isRequired
                        />

                        <FormInput
                            labelText="Contact Person:"
                            labelFor="contact_person"
                            v-model="this.form.contact_person"
                            :error="this.errors && this.errors.contact_person"
                            isRequired
                        />

                        <FormInput
                            labelText="E-Mail:"
                            labelFor="email"
                            inputType="email"
                            v-model="this.form.email"
                            :error="this.errors && this.errors.email"
                            isRequired
                        />

                        <FormInput
                            labelText="Mobile:"
                            labelFor="mobile"
                            v-model="this.form.mobile"
                            :error="this.errors && this.errors.mobile"
                            isRequired
                        />
                    </div>
                </div>

                <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
                    <BreezeButton class="flex items-center ml-auto" :class="{ 'opacity-25': this.form.processing }" :disabled="this.form.processing" @click.prevent="updateAgency">Update Agency</BreezeButton>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
