<script>
import BreezeInput from './Input.vue';
import Pagination from './Pagination.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export default {
    components: {
        BreezeInput, Pagination,
        Link,
    },

    props: {
        collection: Object, // for pagination
        columns: Array,
        rows: Array,
        baseLink: String,
        filters: Object,
        showSearch: {
            type: Boolean,
            default: true,
        }
    },

    data() {
        return {
            searchWaitTimer: null,
            isDestroying: false,
            destroyingId: null,
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
        },

        deleteRow(id) {
            if (id == null || id == "") {
                return;
            }

            this.destroyingId = id;
            this.isDestroying = true;

            Swal.fire({
                icon: 'question',
                title: 'Confirm',
                text: 'Are you want to delete this row?',
                showConfirmButton: true,
                confirmButtonText: 'Yes! Delete',
                showCancelButton: true,
                cancelButtonText: 'No',
            }).then(btnResult => {
                if (btnResult.isDismissed) {
                    this.destroyingId = null;
                    this.isDestroying = false;
                    return;
                }

                if (btnResult.isConfirmed) {
                    axios.delete(route(this.baseLink + '.destroy', id))
                        .then(res => {
                            this.destroyingId = null;
                            this.isDestroying = false;

                            if (res.data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success !',
                                    text: res.data.message,
                                    timer: 2000,
                                });

                                setTimeout(() => {
                                    window.location = route(this.baseLink + '.index');
                                }, 2500);
                            }
                        });
                }
            });
        }
    },

    watch: {
        params: {
            handler() {
                clearTimeout(this.searchWaitTimer);

                this.searchWaitTimer = setTimeout(() => {
                    this.$inertia.get(route(this.baseLink + '.index'), this.params, { replace: true, preserveState: true });
                }, 300);
            },
            deep: true,
        },
    },
}
</script>

<template>
    <div>
        <div class="flex items-center mt-6">
            <BreezeInput class="w-full md:w-1/2 lg:w-1/4 my-4 inline-block px-2 py-2 rounded-md shadow-sm focus:outline-none" placeholder="Search" v-model="params.search" />
            <Link :href="route(this.baseLink + '.index')" class="ml-4 text-gray-600 hover:text-red-500 focus:text-red-500 focus:outline-none" v-if="params.search != null">Reset</Link>
        </div>

        <div class="bg-white rounded-tr-md rounded-tl-md shadow overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th
                            class="py-4 px-6"
                            v-for="column in columns"
                            @click="sort(column.field)"
                            :class="{'hover:cursor-pointer': column.sortable === true}"
                        >
                            <div class="flex items-center justify-between" v-if="column.sortable === true">
                                <div>{{ column.label }}</div>
                                <div v-if="this.params.field === column.field && this.params.direction === 'asc'">
                                    <img src="/svgs/sort-ascending.svg" alt="Sort Ascending SVG" width="16" height="16" />
                                </div>
                                <div v-if="this.params.field === column.field && this.params.direction === 'desc'">
                                    <img src="/svgs/sort-descending.svg" alt="Sort Descending SVG" width="16" height="16" />
                                </div>
                            </div>

                            <div v-else>{{ column.label }}</div>
                        </th>
                        <th class="text-left py-4 px-6 hover:cursor-pointer">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-if="rows.length == 0">
                        <td class="border-t text-center py-2" :colspan="this.columns.length + 1">No records found.</td>
                    </tr>

                    <tr v-else v-for="(row, rowKey) in rows" :key="row.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t py-4 px-6" v-for="column in columns">
                            {{ row[column.field] }}
                        </td>

                        <td class="border-t px-6 space-x-4">
                            <Link class="text-indigo-600 transition ease-in-out duration-150 hover:text-indigo-800 focus:text-indigo-800 focus:outline-none" :href="route(baseLink + '.show', row.id)" :class="{'opacity-25 cursor-not-allowed': this.isDestroying === true && this.destroyingId === row.id}">Show</Link>
                            <Link class="text-indigo-600 transition ease-in-out duration-150 hover:text-indigo-800 focus:text-indigo-800 focus:outline-none" :href="route(baseLink + '.edit', row.id)" :class="{'opacity-25 cursor-not-allowed': this.isDestroying === true && this.destroyingId === row.id}">Edit</Link>
                            <button @click.prevent="deleteRow(row.id)" class="text-red-600 transition ease-in-out duration-150 hover:text-red-800 focus:text-red-800 focus:outline-none" :class="{'opacity-25 cursor-not-allowed': this.isDestroying === true && this.destroyingId === row.id}">
                                <span v-if="this.isDestroying === true && this.destroyingId === row.id">Deleting...</span>
                                <span v-else>Delete</span>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <Pagination :links="collection.links" />
    </div>
</template>
