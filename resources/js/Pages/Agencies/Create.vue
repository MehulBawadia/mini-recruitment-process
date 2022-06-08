<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import FormInput from '@/Components/FormInput.vue';
import CustomForm from '@/Components/CustomForm.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export default {
    components: {
        BreezeAuthenticatedLayout,
        CustomForm, FormInput,
        Head, Link, Swal,
    },

    data() {
        return {
            errors: null,
            form: {
                name: '',
                email: '',
                mobile: '',
                contact_person: '',
            },
        };
    },

    methods: {
        createAgency() {
            this.form.processing = true;

            let self = this;

            axios.post(route('agencies.store'), this.form)
                .then(res => {
                    this.form.processing = false;

                    if (res.data.status === 'success') {
                        this.clearForm();

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

        clearForm() {
            let self = this;
            Object.keys(this.form).forEach(function (key, index) {
                self.form[key] = '';
            });

            self.errors = null;
        }
    },
};
</script>

<template>
    <Head title="Create New Agency" />

    <BreezeAuthenticatedLayout>
        <h1 class="text-3xl font-bold">
            <Link class="breadcrumbLink" :href="route('agencies.index')">
                Agencies
            </Link>
            / Create
        </h1>

        <div v-if="this.errors" class="max-w-5xl bg-red-200 text-red-800 py-4 px-4 rounded mt-6">
            Oops! There were some errors while creating the agency.
        </div>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <CustomForm formType="create" @store="createAgency" submitButtonText="Create Agency">
                <template #formFields>
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
                </template>
            </CustomForm>
        </div>
    </BreezeAuthenticatedLayout>
</template>
