<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';

export default {
    components: {
        BreezeAuthenticatedLayout, BreezeInput,
        Head, Link, Pagination,
    },

    props: {
        agencies: Object,
        filters: Object,
    },

    data() {
        return {
            searchWaitTimer: null,
            params: {
                search: this.filters.search ?? null,
                field: this.filters.field ?? null,
                direction: this.filters.direction ?? null,
            }
        }
    },

    methods: {
        sort(field) {
            this.params.field = field;
            this.params.direction = this.params.direction == 'asc' ? 'desc' : 'asc';
        }
    },

    watch: {
        params: {
            handler() {
                clearTimeout(this.searchWaitTimer);

                this.searchWaitTimer = setTimeout(() => {
                    this.$inertia.get(route('agencies.index'), this.params, { replace: true, preserveState: true });
                }, 300);
            },
            deep: true,
        },
    }
}
</script>

<template>
    <Head title="Agencies" />

    <BreezeAuthenticatedLayout>
        <div class="flex items-center justify-between">
            <div class="flex items-center w-1/2">
                <h1 class="text-xl md:text-3xl font-bold">Agencies</h1>

                <BreezeInput class="hidden sm:block ml-4 px-2 py-2 w-1/2 rounded-md shadow-sm focus:outline-none" placeholder="Search" v-model="params.search" />

                <Link :href="route('agencies.index')" class="ml-4 text-gray-600 hover:text-red-500 focus:text-red-500 focus:outline-none" v-if="params.search != null">Reset</Link>
            </div>

            <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.create')">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Agency</span>
            </Link>
        </div>
        <BreezeInput class="sm:hidden my-4 block px-2 py-2 w-full rounded-md shadow-sm focus:outline-none" placeholder="Search" v-model="params.search" />

        <div class="bg-white rounded-tr-md rounded-tl-md shadow overflow-x-auto mt-8">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="py-4 px-6 hover:cursor-pointer" @click="sort('id')">
                            <div class="flex items-center justify-between">
                                <div>Id</div>
                                <div v-if="this.params.field === 'id' && this.params.direction === 'asc'">
                                    <img src="/svgs/sort-ascending.svg" alt="Sort Ascending SVG" width="16" height="16" />
                                </div>
                                <div v-if="this.params.field === 'id' && this.params.direction === 'desc'">
                                    <img src="/svgs/sort-descending.svg" alt="Sort Descending SVG" width="16" height="16" />
                                </div>
                            </div>
                        </th>
                        <th class="py-4 px-6 hover:cursor-pointer" @click="sort('name')">
                            <div class="flex items-center justify-between">
                                <div>Name</div>

                                <div v-if="this.params.field === 'name' && this.params.direction === 'asc'">
                                    <img src="/svgs/sort-ascending.svg" alt="Sort Ascending SVG" width="16" height="16" />
                                </div>
                                <div v-if="this.params.field === 'name' && this.params.direction === 'desc'">
                                    <img src="/svgs/sort-descending.svg" alt="Sort Descending SVG" width="16" height="16" />
                                </div>
                            </div>
                        </th>
                        <th class="py-4 px-6 hover:cursor-pointer" @click="sort('contact_person')">
                            <div class="flex items-center justify-between">
                                <div>Contact Person</div>

                                <div v-if="this.params.field === 'contact_person' && this.params.direction === 'asc'">
                                    <img src="/svgs/sort-ascending.svg" alt="Sort Ascending SVG" width="16" height="16" />
                                </div>
                                <div v-if="this.params.field === 'contact_person' && this.params.direction === 'desc'">
                                    <img src="/svgs/sort-descending.svg" alt="Sort Descending SVG" width="16" height="16" />
                                </div>
                            </div>
                        </th>
                        <th class="py-4 px-6">E-Mail</th>
                        <th class="py-4 px-6">Mobile</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-if="agencies.data.length == 0">
                        <td class="border-t text-center py-2" colspan="5">No records found.</td>
                    </tr>

                    <tr v-else v-for="agency in agencies.data" :key="agency.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.id }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.name }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.contact_person }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.email }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.mobile }}</Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4 text-2xl" :href="route('agencies.show', agency.id)"> &rsaquo;</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Pagination :links="this.agencies.links" />
    </BreezeAuthenticatedLayout>
</template>
