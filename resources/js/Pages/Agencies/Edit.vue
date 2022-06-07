<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton, BreezeInput, BreezeLabel,
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
                        <div>
                            <BreezeLabel for="name" value="Name:" class="font-semibold" />
                            <BreezeInput id="name" type="name" class="mt-1 block w-full border py-2 pl-2 focus:outline-none" v-model="this.form.name" required :class="{'border-red-500' : this.errors && this.errors.name}" @keydown.enter.prevent="updateAgency" />

                            <span class="text-red-600" v-if="this.errors && this.errors.name">{{ this.errors.name[0] }}</span>
                        </div>
                        <div>
                            <BreezeLabel for="email" value="E-Mail:" class="font-semibold" />
                            <BreezeInput id="email" type="email" class="mt-1 block w-full border py-2 pl-2 focus:outline-none" v-model="this.form.email" :class="{'border-red-500' : this.errors && this.errors.email}" required @keydown.enter.prevent="updateAgency" />

                            <span class="text-red-600" v-if="this.errors && this.errors.email">{{ this.errors.email[0] }}</span>
                        </div>
                        <div>
                            <BreezeLabel for="contact_person" value="Contact Person:" class="font-semibold" />
                            <BreezeInput id="contact_person" type="contact_person" class="mt-1 block w-full border py-2 pl-2 focus:outline-none" v-model="this.form.contact_person" required :class="{'border-red-500' : this.errors && this.errors.contact_person}" @keydown.enter.prevent="updateAgency" />

                            <span class="text-red-600" v-if="this.errors && this.errors.contact_person">{{ this.errors.contact_person[0] }}</span>
                        </div>
                        <div>
                            <BreezeLabel for="mobile" value="Mobile:" class="font-semibold" />
                            <BreezeInput id="mobile" type="mobile" class="mt-1 block w-full border py-2 pl-2 focus:outline-none" v-model="this.form.mobile" required :class="{'border-red-500' : this.errors && this.errors.mobile}" @keydown.enter.prevent="updateAgency" />

                            <span class="text-red-600" v-if="this.errors && this.errors.mobile">{{ this.errors.mobile[0] }}</span>
                        </div>
                    </div>
                </div>

                <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
                    <BreezeButton class="flex items-center ml-auto" :class="{ 'opacity-25': this.form.processing }" :disabled="this.form.processing" @click.prevent="updateAgency">Update Agency</BreezeButton>
                </div>
            </form>
        </div>
    </BreezeAuthenticatedLayout>
</template>
