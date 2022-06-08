<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeButton,
        Head, Link
    },

    props: {
        agency: Object,
    },

    data() {
        return {
            successMessage: null,
            isDestroying: false,
        }
    },

    methods: {
        destroyAgency() {
            this.isDestroying = true;

            Swal.fire({
                icon: 'question',
                title: 'Confirm',
                text: 'Are you want to delete this agency?',
                showConfirmButton: true,
                confirmButtonText: 'Yes! Delete',
                showCancelButton: true,
                cancelButtonText: 'No',
            }).then(btnResult => {
                if (btnResult.isDismissed) {
                    this.isDestroying = false;
                }

                if (btnResult.isConfirmed) {
                    axios.delete(route('agencies.destroy', this.agency.id))
                        .then(res => {
                            if (res.data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success !',
                                    text: res.data.message,
                                    timer: 2000,
                                });

                                setTimeout(() => {
                                    window.location = route('agencies.index');
                                }, 2500);
                            }
                        });
                }
            });
        }
    },
}
</script>

<template>
    <Head title="Agency Details" />

    <BreezeAuthenticatedLayout>
        <h1 class="text-3xl font-bold">
            <Link class="breadcrumbLink" :href="route('agencies.index')">
                Agencies
            </Link>
            / {{ this.agency.name }}
        </h1>

        <div class="max-w-5xl bg-white rounded-md shadow overflow-x-auto mt-8">
            <div class="px-10 py-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <div class="font-semibold text-gray-600">Name:</div>
                        <div class="font-semibold">{{ this.agency.name }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Contact Person:</div>
                        <div class="font-semibold">{{ this.agency.contact_person }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">E-Mail:</div>
                        <div class="font-semibold">{{ this.agency.email }}</div>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-600">Mobile:</div>
                        <div class="font-semibold">{{ this.agency.mobile }}</div>
                    </div>
                </div>
            </div>

            <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex items-center justify-between">
                <button class="text-red-600 hover:text-red-800 focus:text-red-800 focus:outline-none transition ease-in-out duration-150" @click.prevent="destroyAgency" :class="{ 'opacity-25': this.isDestroying }">Destroy Agency</button>

                <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.edit', this.agency.id)">
                    <span>Edit</span>
                    <span class="hidden md:inline">&nbsp;Agency</span>
                </Link>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
