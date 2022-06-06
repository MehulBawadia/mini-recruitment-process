<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

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

            axios.delete(route('agencies.destroy', this.agency.id))
                .then(res => {
                    if (res.data.status === 'success') {
                        this.successMessage = res.data.message;

                        setTimeout(() => {
                            window.location = route('agencies.index');
                        }, 2000);
                    }
                });
        }
    },
}
</script>

<template>
    <Head title="Agency Details" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="hidden sm:block font-semibold text-xl text-gray-800 leading-tight">
                Agency Details
            </h2>

            <h2 class="sm:hidden font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.appName }}
            </h2>
        </template>

        <div class="px-4 flex items-center justify-between">
            <h1 class="text-3xl font-bold">
                <Link class="text-indigo-800 tracking-widest hover:text-indigo-600 focus:text-indigo-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.index')">
                    Agencies
                </Link>
                / {{ this.agency.name }}
            </h1>
        </div>

        <div v-if="this.successMessage" class="max-w-5xl bg-green-200 text-green-800 py-4 px-4 rounded mt-6">
            {{ this.successMessage }}
        </div>

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
