<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head, Link
    },

    props: {
        agencies: Array,
    }
}
</script>

<template>
    <Head title="Agencies" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="hidden sm:block font-semibold text-xl text-gray-800 leading-tight">
                Agencies
            </h2>

            <h2 class="sm:hidden font-semibold text-xl text-gray-800 leading-tight">
                {{ $page.props.appName }}
            </h2>
        </template>

        <div class="px-4 flex items-center justify-between">
            <h1 class="text-3xl font-bold">Agencies</h1>

            <Link class="font-bold inline-flex items-center px-4 py-2 bg-indigo-800 border border-transparent rounded-md text-sm text-white tracking-widest hover:bg-amber-600 focus:bg-amber-600 focus:outline-none transition ease-in-out duration-150" :href="route('agencies.create')">
                <span>Create</span>
                <span class="hidden md:inline">&nbsp;Agency</span>
            </Link>
        </div>

        <div class="bg-white rounded-md shadow overflow-x-auto mt-8">
            <table class="w-full whitespace-nowrap">
                <thead>
                    <tr class="text-left font-bold">
                        <th class="py-4 px-6">Name</th>
                        <th class="py-4 px-6">Contact Person</th>
                        <th class="py-4 px-6">E-Mail / Mobile</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-if="agencies.length == 0">
                        <td class="border-t text-center py-2" colspan="3">No records found.</td>
                    </tr>

                    <tr v-else v-for="agency in agencies" :key="agency.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.name }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.contact_person }}</Link>
                        </td>
                        <td class="border-t">
                            <Link class="flex items-center py-4 px-6 focus:text-indigo-600" :href="route('agencies.show', agency.id)">{{ agency.email }} / {{ agency.mobile }}</Link>
                        </td>
                        <td class="w-px border-t">
                            <Link class="flex items-center px-4 text-2xl" :href="route('agencies.show', agency.id)"> &rsaquo;</Link>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </BreezeAuthenticatedLayout>
</template>
