<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import DataTable from '@/Components/DataTable.vue';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head, Link, DataTable,
    },

    props: {
        candidates: Object,
        filters: Object,
    },

    methods: {
        getColumns() {
            return [
                {label: 'Id', field: 'id', sortable: true, type: 'string',},
                {label: 'Name', field: 'name', sortable: true, type: 'string',},
                {label: 'E-Mail', field: 'email', sortable: false, type: 'string',},
                {label: 'Mobile', field: 'mobile', sortable: false, type: 'string',},
                {label: 'Interviewer', field: 'interview_by', sortable: false, type: 'string',},
                {label: 'Scheduled At', field: 'interview_scheduled_at', sortable: false, type: 'date'},
                {label: 'Is Selected', field: 'is_selected', sortable: false, type: 'toggle', toggleRouteName: 'toggleSelected'},
            ];
        },
    }
}
</script>

<template>
    <Head title="Candidates" />

    <BreezeAuthenticatedLayout>
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <h1 class="text-xl md:text-3xl font-bold">Candidates</h1>
            </div>

            <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('candidates.create')">
                <span>Add</span>
                <span class="hidden md:inline">&nbsp;Candidate</span>
            </Link>
        </div>

        <DataTable
            :collection="this.candidates"
            :columns="this.getColumns()"
            :filters="this.filters"
            baseLink="candidates"
            filterByDatePlaceholder="Interview Date"
            filterByDate
        />
    </BreezeAuthenticatedLayout>
</template>
