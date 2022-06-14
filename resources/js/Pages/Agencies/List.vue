<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeInput from '@/Components/Input.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import Pagination from '@/Components/Pagination.vue';
import DataTable from '@/Components/DataTable.vue';

export default {
    components: {
        BreezeAuthenticatedLayout, BreezeInput,
        Head, Link, Pagination, DataTable,
    },

    props: {
        agencies: Object,
        filters: Object,
    },

    methods: {
        getColumns() {
            return [
                {label: 'Id', field: 'id', sortable: true, type: 'string',},
                {label: 'Name', field: 'name', sortable: true, type: 'string',},
                {label: 'Contact Person', field: 'contact_person', sortable: true, type: 'string',},
                {label: 'E-Mail', field: 'email', sortable: false, type: 'string',},
                {label: 'Mobile', field: 'mobile', sortable: false, type: 'string',},
            ];
        },
    }
}
</script>

<template>
    <Head title="Agencies" />

    <BreezeAuthenticatedLayout>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-xl md:text-3xl font-bold">Agencies</h1>
            </div>

            <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.create')">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Agency</span>
            </Link>
        </div>

        <DataTable
            :collection="this.agencies"
            :columns="this.getColumns()"
            :filters="this.filters"
            baseLink="agencies"
        />
    </BreezeAuthenticatedLayout>
</template>
