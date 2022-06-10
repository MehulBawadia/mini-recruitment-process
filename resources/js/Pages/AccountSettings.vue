<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import FormInput from '@/Components/FormInput.vue';
import CustomForm from '@/Components/CustomForm.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { Inertia } from '@inertiajs/inertia';

export default {
    components: {
        BreezeAuthenticatedLayout,
        CustomForm, FormInput,
        Head, Link, Swal,
    },

    data() {
        return {
            errors: null,
            processing: false,
            form: {
                first_name: this.$page.props.auth.user.first_name,
                last_name: this.$page.props.auth.user.last_name,
                email: this.$page.props.auth.user.email,
            },
            changePasswordForm: {
                current_password: '',
                new_password: '',
                repeat_new_password: '',
            }
        };
    },

    methods: {
        updateAccSettings() {
            this.form.processing = true;

            axios.put(route('accountSettings.update'), this.form)
                .then(res => {
                    this.form.processing = false;

                    if (res.data.status === 'success') {
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

        updatePassword() {
            this.processing = true;

            axios.put(route('accountSettings.updatePassword'), this.changePasswordForm)
                .then(res => {
                    this.processing = false;

                    if (res.data.status === 'success') {
                        this.clearChangePasswordForm();

                        Swal.fire({
                            icon: 'success',
                            title: 'Success !',
                            text: res.data.message,
                        });
                    }

                    if (res.data.status === 'failed') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Failed !',
                            text: res.data.message,
                        });
                    }
                }).catch(error => {
                    this.processing = false;
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors;
                    }
                });
        },

        clearChangePasswordForm() {
            let self = this;
            Object.keys(this.changePasswordForm).forEach(function (key, index) {
                self.changePasswordForm[key] = '';
            });

            self.errors = null;
        }
    },
};
</script>

<template>
    <Head title="Account Settings" />

    <BreezeAuthenticatedLayout>
        <h1 class="text-3xl font-bold">
            <Link class="breadcrumbLink" :href="route('dashboard')">
                Dashboard
            </Link>
            / Account Settings
        </h1>

        <div v-if="this.errors" class="max-w-5xl bg-red-200 text-red-800 py-4 px-4 rounded mt-6">
            Oops! There were some errors while creating the agency.
        </div>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <CustomForm formType="edit" @update="updateAccSettings" submitButtonText="Update">
                <template #formFields>
                    <div class="px-10 py-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <FormInput
                                labelText="First Name:"
                                labelFor="first_name"
                                v-model="this.form.first_name"
                                :error="this.errors && this.errors.first_name"
                                isRequired
                            />

                            <FormInput
                                labelText="Last Name:"
                                labelFor="last_name"
                                v-model="this.form.last_name"
                                :error="this.errors && this.errors.last_name"
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
                        </div>
                    </div>
                </template>
            </CustomForm>
        </div>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <CustomForm formType="edit" @update="updatePassword" submitButtonText="Update" :processing="this.processing">
                <template #formFields>
                    <div class="px-10 py-6">
                        <FormInput
                            labelText="Current Password:"
                            labelFor="current_password"
                            inputType="password"
                            v-model="this.changePasswordForm.current_password"
                            :error="this.errors && this.errors.current_password"
                            isRequired
                        />

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6">
                            <FormInput
                                labelText="New Password:"
                                labelFor="new_password"
                                inputType="password"
                                v-model="this.changePasswordForm.new_password"
                                :error="this.errors && this.errors.new_password"
                                isRequired
                            />

                            <FormInput
                                labelText="Repeat New Password:"
                                labelFor="repeat_new_password"
                                inputType="password"
                                v-model="this.changePasswordForm.repeat_new_password"
                                :error="this.errors && this.errors.repeat_new_password"
                                isRequired
                            />
                        </div>
                    </div>
                </template>
            </CustomForm>
        </div>
    </BreezeAuthenticatedLayout>
</template>
